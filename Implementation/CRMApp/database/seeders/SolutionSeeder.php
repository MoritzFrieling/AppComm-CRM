<?php

namespace Database\Seeders;

use App\Models\Solution;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Create 10 solutions
        $faker = Factory::create('nl_NL');
        foreach (range(1, 10) as $index) {
            $randomElement = $faker->randomElement(['Service', 'Product', 'Domain']);
            $solution = Solution::query()->create(
                [
                    'title' => $randomElement
                        . ''
                        . $faker->randomLetter()
                        . $faker->randomNumber(2, true),
                    'number' => $faker->randomNumber(5, true),
                    'category' => $randomElement,
                    'price_per_unit' => $faker->randomNumber(5, true),
                    'units' => $faker->randomNumber(3, true),
                    'recurring_period' => $faker->randomNumber(2),
                    'recurring_period_unit' => $faker->randomLetter(),
                    'vat_rate' => $faker->randomFloat(2, 0, 0.5),
                    'description' => $faker->realText(254),
                ]
            );
        }
    }
}


