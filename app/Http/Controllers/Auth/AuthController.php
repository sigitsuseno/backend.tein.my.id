<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Cek apakah email ada di database
        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            $errorMessage = 'Email tidak ditemukan dalam database.';

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'errors' => [
                        'email' => [$errorMessage],
                    ],
                ], 422);
            }

            throw ValidationException::withMessages([
                'email' => $errorMessage,
            ]);
        }

        // Cek status user (jika ada kolom status)
        if (property_exists($user, 'status') && $user->status !== 'active') {
            $errorMessage = 'Akun Anda tidak aktif. Silakan hubungi administrator.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'errors' => [
                        'email' => [$errorMessage],
                    ],
                ], 422);
            }

            throw ValidationException::withMessages([
                'email' => $errorMessage,
            ]);
        }

        // Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user()->load('roles');

            // Determine redirect URL based on role
            $redirectUrl = $this->getRedirectUrl($user);

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => $redirectUrl,
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->roles->first()->name ?? 'user',
                    ],
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        // Jika password salah
        $errorMessage = 'Password yang Anda masukkan salah.';

        // Response untuk AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'errors' => [
                    'password' => [$errorMessage],
                ],
            ], 422);
        }

        throw ValidationException::withMessages([
            'password' => $errorMessage,
        ]);
    }

    public function formRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'username' => 'nullable|string|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'agree_terms' => 'required|accepted',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'agree_terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'agree_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'username' => $validated['username'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'status' => 'active', // atau 'pending' jika perlu verifikasi email
                'uuid' => \Illuminate\Support\Str::uuid(),
            ]);

            // Assign role 'member' secara default
            $memberRole = Role::where('name', 'member')->first();
            if ($memberRole) {
                $user->roles()->attach($memberRole);
            }

            // Login user otomatis setelah registrasi (opsional)
            Auth::login($user);

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil! Akun Anda telah dibuat.',
                    'redirect' => $this->getRedirectUrl($user),
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => $user->username,
                    ],
                ], 201);
            }

            return redirect()->route('member.dashboard', ['keyname' => $user->username ?? $user->uuid])
                ->with('success', 'Registrasi berhasil! Selamat datang.');

        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.';

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }

            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Check email availability (AJAX)
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'available' => ! $exists,
            'message' => $exists ? 'Email sudah terdaftar.' : 'Email tersedia.',
        ]);
    }

    /**
     * Check username availability (AJAX)
     */
    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        $exists = User::where('username', $request->username)->exists();

        return response()->json([
            'available' => ! $exists,
            'message' => $exists ? 'Username sudah digunakan.' : 'Username tersedia.',
        ]);
    }

    /**
     * Get redirect URL based on user role
     */
    private function getRedirectUrl($user)
    {
        if ($user->hasRole(['superadmin', 'admin', 'manager', 'operator'])) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('member')) {
            $keyname = $user->username ?? $user->uuid;

            return route('member.dashboard', ['keyname' => $keyname]);
        }

        return route('home');
    }

    /**
     * Handle logout with AJAX support
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Response untuk AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil!',
                'redirect' => route('login'),
            ]);
        }

        return redirect()->route('login');
    }

    /**
     * Check authentication status (for AJAX calls)
     */
    public function checkAuth(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'authenticated' => Auth::check(),
                'user' => Auth::check() ? [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'roles' => Auth::user()->roles->pluck('name'),
                ] : null,
            ]);
        }

        return abort(404);
    }

    /**
     * Get current user info (for AJAX calls)
     */
    public function getUserInfo(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if (Auth::check()) {
                $user = Auth::user()->load('roles');

                return response()->json([
                    'success' => true,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'roles' => $user->roles->pluck('name'),
                        'permissions' => $user->getAllPermissions()->pluck('name'),
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        return abort(404);
    }
}
