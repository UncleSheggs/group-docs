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
        \App\Models\User::factory(100)->create();
        foreach(range(1, 25) as $item) {
            \App\Models\Group::factory()
                ->hasAttached(
                    \App\Models\User::query()->inRandomOrder()->limit(rand(2, 5))->get()
                )
                ->create();
        }
    }
}
