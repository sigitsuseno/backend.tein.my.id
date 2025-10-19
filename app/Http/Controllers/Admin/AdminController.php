<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function manageUser()
    {
        $user = User::with('roles')->orderBy('id', 'asc')->get();

        return view('admin.user-manager.user', [
            'user' => $user,
        ]);
    }
}
