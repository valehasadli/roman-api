<?php

declare(strict_types=1);

namespace App\Services\Converter;

use App\Services\Converter\Contracts\NumberConverterContract;

/**
 * Class ArabicNumeralConverter
 * @package App\Services\Converter
 */
class ArabicNumberConverter implements NumberConverterContract
{
    /**
     * @param int $number
     * @return string
     */
    public function convert(int $number): string
    {
        return 'some arabic number for testing purpose';
    }
}
