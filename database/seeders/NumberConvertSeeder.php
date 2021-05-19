<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\NumberConvert;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumberConvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        NumberConvert::truncate();

        NumberConvert::factory(5)->create();
    }
}
