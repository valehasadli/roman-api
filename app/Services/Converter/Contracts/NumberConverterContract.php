<?php

declare(strict_types=1);

namespace App\Services\Converter\Contracts;

/**
 * Interface NumberConverterContract
 * @package App\Services\Converter
 */
interface NumberConverterContract
{
    /**
     * @param int $number
     * @return string
     */
    public function convert(int $number): string;
}
