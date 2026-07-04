<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil RoleSeeder terlebih dahulu agar ID Role tersedia untuk User
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
