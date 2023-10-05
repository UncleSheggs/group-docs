<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
final class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>  Str::of(Str::remove(',', fake()->catchPhrase()))->words(1, ' ' . Arr::random(['Team', 'Group', 'Crew', 'Tribe'])),
            'interval' => fake()->randomElement(\App\Enums\PaymentInterval::values()),
            'limit' => fake()->numberBetween(2, 5)
        ];
    }
}
