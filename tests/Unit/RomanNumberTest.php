<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\Converter\RomanNumberConverter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class RomanNumberTest extends TestCase
{
    use RefreshDatabase;

    private RomanNumberConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = new RomanNumberConverter();
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
