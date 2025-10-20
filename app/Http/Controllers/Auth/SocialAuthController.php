<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Log;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah terdaftar dengan Google ID
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // User sudah terdaftar dengan Google - langsung login
                Auth::login($user);

                return $this->redirectUser($user);
            }

            // Cek apakah email sudah terdaftar (tanpa Google)
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // Update existing user dengan Google ID
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                Auth::login($existingUser);

                return $this->redirectUser($existingUser);
            }

            // Buat user baru
            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(24)), // Random password
                'username' => $this->generateUsername($googleUser->getName(), $googleUser->getEmail()),
                'status' => 'active',
                'uuid' => Str::uuid(),
                'email_verified_at' => now(), // Email sudah terverifikasi oleh Google
            ]);

            // Assign role 'member' secara default
            $memberRole = Role::where('name', 'member')->first();
            if ($memberRole) {
                $newUser->roles()->attach($memberRole);
            }

            Auth::login($newUser);

            return $this->redirectUser($newUser);

        } catch (Exception $e) {
            Log::error('Google OAuth Error: '.$e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }

    /**
     * Generate username dari nama atau email
     */
    private function generateUsername($name, $email)
    {
        $baseUsername = Str::slug($name);
        $emailUsername = Str::before($email, '@');

        $username = $baseUsername ?: $emailUsername;

        // Cek jika username sudah ada, tambahkan angka
        $counter = 1;
        $originalUsername = $username;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername.$counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Redirect user berdasarkan role
     */
    private function redirectUser($user)
    {
        $user->load('roles');

        if ($user->hasRole(['superadmin', 'admin', 'manager', 'operator'])) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login dengan Google berhasil!');
        }

        if ($user->hasRole('member')) {
            $keyname = $user->username ?? $user->uuid;

            return redirect()->route('member.dashboard', ['keyname' => $keyname])
                ->with('success', 'Login dengan Google berhasil!');
        }

        return redirect()->route('home')
            ->with('success', 'Login dengan Google berhasil!');
    }

    /**
     * Disconnect Google account
     */
    public function disconnectGoogle(Request $request)
    {
        $user = Auth::user();

        // Pastikan user memiliki password sebelum disconnect
        if (Hash::check('', $user->password) || ! $user->password) {
            return back()->with('error', 'Anda harus mengatur password sebelum memutus koneksi Google.');
        }

        $user->update([
            'google_id' => null,
            'avatar' => null,
        ]);

        return back()->with('success', 'Akun Google berhasil diputus.');
    }
}
