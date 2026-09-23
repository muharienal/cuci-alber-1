<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cucialber.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'), // GANTI setelah login pertama kali!
                'role' => 'admin',
            ]
        );

        $this->command->info('Admin default: admin@cucialber.local / admin123 (segera ganti password ini)');
    }
}
