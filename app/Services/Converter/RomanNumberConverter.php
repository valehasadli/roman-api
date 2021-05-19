<?php

namespace App\Services\Converter;

use App\Services\Converter\Contracts\NumberConverterContract;

/**
 * Class RomanNumeralConverter
 * @package App\Services\Converter
 */
class RomanNumberConverter implements NumberConverterContract
{
    private const ROMAN_CHAR = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    ];

    /**
     * @param int $number
     * @return string
     */
    public function convert(int $number): string
    {
        $result = '';

        while ($number < 4000 && $number > 0) {
            foreach (self::ROMAN_CHAR as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $result .= $roman;
                    break;
                }
            }
        }

        return $result;
    }
}
