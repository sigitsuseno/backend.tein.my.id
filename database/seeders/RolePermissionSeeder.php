<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // --- Roles ---
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'superadmin', 'level' => 100],
            ['name' => 'Admin', 'slug' => 'admin', 'level' => 80],
            ['name' => 'Manager', 'slug' => 'manager', 'level' => 60],
            ['name' => 'Operator', 'slug' => 'operator', 'level' => 40],
            ['name' => 'Member', 'slug' => 'member', 'level' => 20],
        ];
        foreach ($roles as $r) {
            Role::firstOrCreate(['slug' => $r['slug']], $r);
        }

        // --- Permissions ---
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],
            ['name' => 'Access Forum', 'slug' => 'access-forum'],
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // Hubungkan role & permission
        $admin = Role::where('slug', 'admin')->first();
        $admin->permissions()->sync(Permission::pluck('id'));
    }
}
