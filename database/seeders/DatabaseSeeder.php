<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ServiceSeeder::class);
        \App\Models\User::factory(100)->create();
        foreach(range(1, 5) as $item) {
            \App\Models\Group::factory()
                ->for(\App\Models\Service::query()->inRandomOrder()->first())
                // ->for(\App\Models\User::query()->inRandomOrder()->first())
                ->hasAttached(
                    \App\Models\User::query()->inRandomOrder()->first(),
                    [
                        'role' => \App\Enums\MembershipRole::ADMIN->value,
                        'status' => \App\Enums\MembershipStatus::ACTIVE->value,
                    ]
                )
                ->create();
        }
    }
}
