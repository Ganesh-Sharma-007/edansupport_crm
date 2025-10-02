<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'  => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'role'  => 'super-admin',
            'phone' => '0000000000',
        ]);
    }
}