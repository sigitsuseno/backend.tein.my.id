<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\KontakDarurat;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * [READ] Menampilkan detail profil member yang sedang login.
     * Route: GET member.profile.index
     */
    public function index(string $keyname)
    {

        $userId = Auth::id();
        $profile = UserDetail::where('user_id', $userId)->first();

        return view('member.profile.index', [
            'user_profile' => User::where('id', $userId)->with('details')->first(),
            'user' => Auth::user()->load(['details', 'medis', 'kontakDarurat']),
        ]);
    }

    public function updateDetail(Request $request, $keyname)
    {

        $user = User::where('username', $keyname)->orWhere('uuid', $keyname)->firstOrFail();

        $data = $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'warganegara' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
        ]);

        $user->details()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        $user->update(['status' => 'member']);

        return response()->json(['message' => 'Profil berhasil diperbarui']);
    }

    public function storeKontak(string $keyname, Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'hubungan' => 'nullable|string|max:100',
            'no_telp' => 'required|string|max:20',
        ]);

        Auth::user()->kontakDarurat()->create($data);

        return response()->json(['message' => 'Kontak darurat ditambahkan']);
    }

    public function updateKontak(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'hubungan' => 'nullable|string|max:100',
            'no_telp' => 'required|string|max:20',
        ]);

        $kontak = KontakDarurat::where('user_id', Auth::id())->findOrFail($id);
        $kontak->update($data);

        return response()->json(['message' => 'Kontak darurat diperbarui']);
    }

    public function destroyKontak($id)
    {
        KontakDarurat::where('user_id', Auth::id())->where('id', $id)->delete();

        return response()->json(['message' => 'Kontak darurat dihapus']);
    }
}
