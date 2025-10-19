<?php

namespace App\Traits;

use App\Models\Role;

trait HasRolePermission
{
    // --- Role Management ---
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return $this->roles->pluck('slug')->intersect($roles)->isNotEmpty();
        }

        return $this->roles->pluck('slug')->contains($roles);
    }

    public function assignRole($roles)
    {
        $roleIds = Role::whereIn('slug', (array) $roles)->pluck('id');
        $this->roles()->syncWithoutDetaching($roleIds);
    }

    public function removeRole($roles)
    {
        $roleIds = Role::whereIn('slug', (array) $roles)->pluck('id');
        $this->roles()->detach($roleIds);
    }

    public function hasPermission($permission)
    {
        $rolePermissions = $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique();

        if (is_array($permission)) {
            return $rolePermissions->intersect($permission)->isNotEmpty();
        }

        return $rolePermissions->contains($permission);
    }

    public function canAccess($permission)
    {
        return $this->hasPermission($permission);
    }
}
