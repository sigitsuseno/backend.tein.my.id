<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function page()
    {
        // view yang nanti akan kita buat: admin.user-manager.role-permission
        return view('admin.user-manager.role-permission');
    }

    // JSON: list semua role (ringkas)
    public function index()
    {
        $roles = Role::orderBy('level', 'asc')->get(['id', 'name', 'slug', 'level']);

        return response()->json(['data' => $roles]);
    }

    // detail role termasuk permissions (untuk modal edit)
    public function showRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json(['data' => $role]);
    }

    // assign permissions (sync)
    public function assign(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_ids' => 'nullable|array',
            'permission_ids.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);

        // sync: mengganti semua permission yang ada dengan array baru
        $role->permissions()->sync($request->permission_ids ?? []);

        return response()->json(['success' => true]);
    }
}
