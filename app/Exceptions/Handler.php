<?php

declare(strict_types=1);

namespace App\Exceptions;

use ErrorException;
use http\Exception\BadMethodCallException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use League\Flysystem\FileNotFoundException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    /**
     * @param Request $request
     * @param Throwable $exception
     * @return JsonResponse|RedirectResponse|\Illuminate\Http\Response|HttpResponse
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TooManyRequestsHttpException) {
            return Response::errorJson(
                'Server catch too many request',
                HttpResponse::HTTP_TOO_MANY_REQUESTS,
            );
        }

        if ($exception instanceof FatalError) {
            return Response::errorJson(
                $exception->getMessage(),
                HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }

        if ($exception instanceof NotFoundHttpException) {
            return Response::errorJson(
                'Not Found',
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof RouteNotFoundException) {
            return Response::errorJson(
                'Route Not found',
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof UnauthorizedHttpException) {
            return Response::errorJson(
                'Unauthorized',
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof UnprocessableEntityHttpException) {
            return Response::errorJson(
                'Unprocessable entity',
                HttpResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($exception instanceof FileNotFoundException) {
            return Response::errorJson(
                'File not found',
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof ErrorException) {
            return Response::errorJson(
                $exception->getMessage(),
                HttpResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));

            return Response::errorJson(
                sprintf('Does not exist any %s with the specified identificator', $modelName),
                HttpResponse::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof AuthorizationException) {
            return Response::errorJson(
                $exception->getMessage(),
                HttpResponse::HTTP_UNAUTHORIZED
            );
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return Response::errorJson(
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof BadMethodCallException) {
            return Response::errorJson(
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof QueryException) {
            return Response::errorJson(
                $exception->getMessage(),
                HttpResponse::HTTP_SERVICE_UNAVAILABLE,
            );
        }

        if ($exception instanceof BindingResolutionException) {
            return Response::errorJson(
                $exception->getMessage(),
                HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return Response::errorJson(
            'Unexpected exception. Try later',
            HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    /**
     * @param ValidationException $e
     * @param Request $request
     * @return JsonResponse|RedirectResponse|\Illuminate\Http\Response|HttpResponse
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        if ($this->isWebClient($request) && !$request->ajax()) {
            return redirect()->back()->withInput($request->input())->withErrors($errors);
        }

        return Response::formErrorJson($errors);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return RedirectResponse|HttpResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isWebClient($request)) {
            return redirect()->guest('login');
        }

        return Response::errorJson('Unauthenticated', HttpResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isWebClient(Request $request): bool
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
