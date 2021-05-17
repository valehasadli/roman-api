<?php

namespace Tests\Unit;

use App\Services\Converter\RomanNumeralConverter;
use PHPUnit\Framework\TestCase;

class RomanNumeralTest extends TestCase
{
    private RomanNumeralConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = new RomanNumeralConverter();
    }

    /** @test */
    public function convertsIntegersToRomanNumerals(): void
    {
        // Test more unique integers
        $this->assertEquals('I', $this->converter->convert(1));
        $this->assertEquals('MMMCMXCIX', $this->converter->convert(3999));
        $this->assertEquals('MMXVI', $this->converter->convert(2016));
        $this->assertEquals('MMXVIII', $this->converter->convert(2018));
        $this->assertEquals('MCMIV', $this->converter->convert(1904));
    }
}
