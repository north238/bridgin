<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Risk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Risk>
 */
class RiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1year');       
        return [
            'name' => $this->faker->randomElement(['なし', 'あり', 'その他']),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
