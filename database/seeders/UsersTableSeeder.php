<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Customer Users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Customer User ' . $i,
                'email' => "customer{$i}@example.com",
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]);
        }

    }
}
