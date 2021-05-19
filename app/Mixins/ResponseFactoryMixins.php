<?php

declare(strict_types=1);

namespace App\Mixins;

use Closure;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseFactoryMixins
 * @package App\Mixins
 */
class ResponseFactoryMixins
{
    /**
     * @return Closure
     */
    public function errorJson(): Closure
    {
        return function (string $message = 'error', int $status = Response::HTTP_BAD_REQUEST): object {
            return response()->json([
                'message' => $message,
                'status' => $status
            ], $status);
        };
    }

    /**
     * @return Closure
     */
    public function formErrorJson(): Closure
    {
        return function (array $errors, int $status = Response::HTTP_UNPROCESSABLE_ENTITY): object {
            return response()->json([
                'errors' => $errors,
                'status' => $status
            ], $status);
        };
    }

    /**
     * @return Closure
     */
    public function successJson(): Closure
    {
        return function (array $data, int $status = Response::HTTP_OK): object {
            return response()->json($data, $status);
        };
    }
}
