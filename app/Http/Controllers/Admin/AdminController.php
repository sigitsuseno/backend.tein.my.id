<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {

        return view('admin.dashboard.index', [
            'user' => Auth::user(),
        ]);
    }

    public function userManager()
    {
        $user = User::with('roles')->orderBy('id', 'asc')->get();

        return view('admin.user-manager.index', [
            'user' => $user,
        ]);
    }

    public function semuaUser()
    {
        $userData = User::orderBy('id', 'asc')->get();

        return response()->json(['userData' => $userData]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'type' => 'nullable|string',
        ]);

        $user = User::create([
            'uuid' => (string) Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan!',
            'data' => $user,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'type' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->type = $request->type;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User berhasil diperbarui!']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus!']);
    }
}
