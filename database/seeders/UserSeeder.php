<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@app.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'type' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // Cek secara eksplisit dan isi UUID hanya jika record BARU dibuat
        if ($superAdmin->wasRecentlyCreated && is_null($superAdmin->uuid)) {
            $superAdmin->uuid = User::generateUniqueCustomId('MR', 'U');
            $superAdmin->save();
        }

        $allRoleIds = Role::pluck('id');
        $superAdmin->roles()->sync($allRoleIds);

        $member = User::updateOrCreate(
            ['email' => 'member@app.com'],
            [
                'name' => 'John Doe Member',
                'username' => 'johndoe',
                'type' => 'member',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // Cek secara eksplisit dan isi UUID hanya jika record BARU dibuat
        if ($member->wasRecentlyCreated && is_null($member->uuid)) {
            $member->uuid = User::generateUniqueCustomId('MR', 'U');
            $member->save();
        }

        $memberRole = Role::where('slug', 'member')->value('id');
        if ($memberRole) {
            $member->roles()->sync([$memberRole]);
        }
    }
}
