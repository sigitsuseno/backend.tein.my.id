<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index($keyname)
    {
        $user = User::where('uuid', $keyname)->orWhere('username', $keyname)->firstOrFail();

        return view('member.profile.index', [
            'user' => $user,
        ]);
    }

    public function dashboard()
    {
        $user_id = Auth::user()->id;

        return view('member.dashboard.index', [
            'user' => User::where('id', $user_id)->with('roles')->first(),
        ]);
    }
}
