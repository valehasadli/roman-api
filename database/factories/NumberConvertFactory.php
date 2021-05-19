<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\NumberConvert;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class NumberConvertFactory
 * @package Database\Factories
 */
class NumberConvertFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NumberConvert::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomKey(config('convert_number.type')),
            'number' => $this->faker->unique()->numberBetween(1, 3999),
            'value' => $this->faker->unique()->word()
        ];
    }
}
