<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nama_role' => 'Admin'],
            ['nama_role' => 'Staff'],
            ['nama_role' => 'Manager'],
        ];

        DB::table('roles')->insert($roles);
    }
}
