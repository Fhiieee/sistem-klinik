<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@klinik.test'],
            [
                'name' => 'Admin Klinik',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
