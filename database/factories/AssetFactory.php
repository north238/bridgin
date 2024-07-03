<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Process\FakeProcessResult;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * このファクトリに対応するモデル名
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $assets = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1year');
        return [
            'name' => $this->faker->sentence(rand(1,7)),
            'amount' => $this->faker->randomNumber(7, true),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
