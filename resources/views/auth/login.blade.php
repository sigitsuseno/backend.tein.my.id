@extends('layouts.auth-layout')

@section('content')
    <main id="lagimaulogin" class="w-full h-full overflow-y-auto">
        <div class="max-w-4xl mx-auto h-screen flex items-center justify-center px-4">
            <div class="w-full grid grid-cols-1 lg:grid-cols-[400px_1fr] bg-white/30 rounded-2xl">
                <div class="p-4">
                    <div class="w-full flex items-center justify-center my-6">
                        <img src="{{ $main_logo }}" alt="" class="w-1/2">
                    </div>

                    <!-- Error Alert untuk Server Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                            <strong class="font-bold">Terjadi Kesalahan!</strong>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Error Alert untuk General/JavaScript Errors -->
                    <div id="generalError"
                        class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4"
                        role="alert">
                        <span id="generalErrorText" class="block"></span>
                    </div>

                    <!-- Success Message -->
                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4"
                            role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Google Login Button -->
                    <div class="mb-6">
                        <a href="{{ route('google.redirect') }}"
                            class="w-full flex justify-center items-center gap-3 py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            Lanjutkan dengan Google
                        </a>
                    </div>

                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <div class="px-3 text-sm text-gray-500">atau</div>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('email') ? 'border border-red-500' : '' }}"
                                placeholder="nama@contoh.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="emailError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                            <input type="password" id="password" name="password" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('password') ? 'border border-red-500' : '' }}"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="passwordError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}"
                                        class="font-medium text-indigo-600 hover:text-indigo-500">
                                        Lupa password?
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div>
                            <button type="submit" id="submitButton"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 transform hover:scale-[1.01] disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="buttonText">Masuk</span>
                                <div id="buttonSpinner" class="hidden ml-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('registerform') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
                <div class="hidden w-full h-full lg:flex items-center justify-center p-4">
                    <div class="w-full h-full bg-white rounded-xl p-4">
                        <h3 class="text-lg font-semibold mb-4">Instruksi :</h3>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-600">
                            <li>Pastikan email yang dimasukkan sudah terdaftar</li>
                            <li>Gunakan password yang benar</li>
                            <li>Jika lupa password, klik link "Lupa password?"</li>
                            <li>Hubungi administrator jika mengalami kendala</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
@endsection
