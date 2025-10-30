<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@nuhigreattravels.com'],
            [
                'name' => 'Site Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
        $this->call([
            SettingsTableSeeder::class,
        ]);
    }
}
