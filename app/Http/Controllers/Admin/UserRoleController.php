<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function page()
    {
        return view('admin.user-manager.user-role');
    }

    public function index()
    {
        $users = User::with('roles')->get(['id', 'name', 'email']);

        return response()->json(['data' => $users]);
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return response()->json([
            'data' => $user,
            'all_roles' => Role::orderBy('level')->get(['id', 'name', 'slug', 'level']),
        ]);
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_ids' => 'nullable|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->roles()->sync($request->role_ids ?? []);

        return response()->json(['success' => true]);
    }
}
