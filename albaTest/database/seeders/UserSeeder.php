<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'address' => 'Kantor',
            'birthdate' => date('Y-m-d', time()),
            'gender' => 'M',
            'phoneNum' => '082133330000',
            'position' => 'Admin',
        ],[
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'address' => 'Rumah',
            'birthdate' => date('Y-m-d', time()),
            'gender' => 'F',
            'phoneNum' => '085319192020',
            'position' => 'Customer',
        ],[
            'name' => 'Super User',
            'email' => 'superuser@gmail.com',
            'password' => Hash::make('superuser123'),
            'address' => 'Kos',
            'birthdate' => date('Y-m-d', time()),
            'gender' => 'M',
            'phoneNum' => '085324062023',
            'position' => 'Customer',
        ]]);
    }
}