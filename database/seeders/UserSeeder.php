<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- 1. AKUN ADMIN (Contoh: Super Admin) ---
        User::updateOrCreate(
            [
                'email' => 'admin@app.com', // Kolom unik untuk pengecekan
            ],
            [
                'uuid' => Str::uuid(), // Otomatis mengisi UUID
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'admin@app.com',
                'type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Password: 'password'
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // --- 2. AKUN MEMBER (Contoh: User Biasa) ---
        User::updateOrCreate(
            [
                'email' => 'member@app.com', // Kolom unik untuk pengecekan
            ],
            [
                'uuid' => Str::uuid(), // Otomatis mengisi UUID
                'name' => 'John Doe Member',
                'username' => 'johndoe',
                'email' => 'member@app.com',
                'type' => 'member',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Password: 'password'
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
