<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;

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
        return view('member.dashboard.index');
    }
}
