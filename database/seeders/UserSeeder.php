<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Akun Admin',
                'email' => 'admin@telkomin.id',
                'password' => Hash::make('12345678'),
                'role_id' => 1, // Mengacu ke role Admin
            ],
            [
                'name' => 'Akun Staff',
                'email' => 'staff@telkomin.id',
                'password' => Hash::make('12345678'),
                'role_id' => 2, // Mengacu ke role Staff
            ],
            [
                'name' => 'Akun Manager',
                'email' => 'manager@telkomin.id',
                'password' => Hash::make('12345678'),
                'role_id' => 3, // Mengacu ke role Manager
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}