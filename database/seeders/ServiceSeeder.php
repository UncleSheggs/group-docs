<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('services')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('services')->insert([
            [
                'type' => 'rent',
                'acceptance_criteria' => null,
            ],
            [
                'type' => 'subscription',
                'acceptance_criteria' => 'email',
            ]
        ]);
    }
}
