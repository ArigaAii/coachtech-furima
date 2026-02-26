<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test1@example.com'],
            ['name' => 'test1', 'password' => Hash::make('password')]
        );

        User::firstOrCreate(
            ['email' => 'test2@example.com'],
            ['name' => 'test2', 'password' => Hash::make('password')]
        );

        User::firstOrCreate(
            ['email' => 'test3@example.com'],
            ['name' => 'test3', 'password' => Hash::make('password')]
        );

        User::firstOrCreate(
            ['email' => 'test4@example.com'],
            ['name' => 'test4', 'password' => Hash::make('password')]
        );
    }
}
