<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
final class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'name' => fake()->randomElement(['rent', 'subscription']),
            'name' => Arr::random(['rent', 'subscription']),
            'acceptance_criteria' => fake()->randomElement(['email', 'mobile', null]),
        ];
    }
}
