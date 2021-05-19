<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NumberConvertStoreRequest;
use App\Http\Resources\NumberConvertResource;
use App\Models\NumberConvert;
use App\Services\Converter\Registry\NumberConverterTypeRegistry;

/**
 * Class NumberConvertController
 * @package App\Http\Controllers\Api
 */
class NumberConvertController extends Controller
{
    /** @var NumberConverterTypeRegistry $converterTypeRegistry */
    private NumberConverterTypeRegistry $converterTypeRegistry;

    /**
     * NumberConvertController constructor.
     * @param NumberConverterTypeRegistry $converterTypeRegistry
     */
    public function __construct(NumberConverterTypeRegistry $converterTypeRegistry)
    {
        $this->converterTypeRegistry = $converterTypeRegistry;
    }

    /**
     * @param NumberConvertStoreRequest $request
     * @return NumberConvertResource
     * @throws \Exception
     */
    public function store(NumberConvertStoreRequest $request): NumberConvertResource
    {
        $validatedData = $request->validated();
        $value = $this->converterTypeRegistry->get($validatedData['type'])->convert((int)$validatedData['number']);

        $response = NumberConvert::where([
            ['type', '=', $validatedData['type']],
            ['number', '=', $validatedData['number']],
            ['value', '=', $value],
        ])->firstOr(function () use ($validatedData, $value) {
            return NumberConvert::create([
                'type' => $validatedData['type'],
                'number' => $validatedData['number'],
                'value' => $value
            ]);
        });

        return new NumberConvertResource($response);
    }
}
