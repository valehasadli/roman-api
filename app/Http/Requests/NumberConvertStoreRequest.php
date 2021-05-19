<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class NumberConvertStoreRequest
 * @package App\Http\Requests
 */
class NumberConvertStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'number' => 'required|integer|between:1,3999',
            'type' => [
                'required',
                'string',
                Rule::in(config('convert_number.type'))
            ]
        ];
    }
}
