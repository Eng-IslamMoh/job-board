<?php

namespace Database\Seeders;

use Database\Seeders\FullDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FullDatabaseSeeder::class,
        ]);
    }
}
