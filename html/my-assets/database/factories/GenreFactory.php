<?php

namespace Database\Factories;

use App\Models\Risk;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
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
            'name' => $this->faker->country(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
