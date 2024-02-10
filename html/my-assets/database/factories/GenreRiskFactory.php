<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Risk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GenreRiskFactory extends Factory
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
            'genre_id' => Genre::factory(),
            'risk_id' => Risk::factory(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
