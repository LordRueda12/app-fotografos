<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the RolesSeeder first
        $this->call([
            RoleSeeder::class,
            CategoriaImagenSeeder::class
        ]);
    }
}
