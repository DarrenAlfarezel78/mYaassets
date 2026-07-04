<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'password' => Hash::make('password'),
                'role_id' => 1, // Mengacu ke Admin
            ],
            [
                'name' => 'Akun Staff',
                'email' => 'staff@telkomin.id',
                'password' => Hash::make('password'),
                'role_id' => 2, // Mengacu ke Staff
            ],
            [
                'name' => 'Akun Manager',
                'email' => 'manager@telkomin.id',
                'password' => Hash::make('password'),
                'role_id' => 3, // Mengacu ke Manager
            ],
        ];

        DB::table('users')->insert($users);
    }
}
