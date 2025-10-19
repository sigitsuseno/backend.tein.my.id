@extends('layouts.auth-layout')

@section('content')
    <main id="lagimauregister" class="w-full h-full overflow-y-auto">
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
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}" class="space-y-4" id="registerForm">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap
                                *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('name') ? 'border border-red-500' : '' }}"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="nameError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email
                                *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('email') ? 'border border-red-500' : '' }}"
                                placeholder="nama@contoh.com">
                            <div id="emailAvailability" class="mt-1 text-xs"></div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="emailError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div>

                        <!-- Username (Opsional) -->
                        {{-- <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('username') ? 'border border-red-500' : '' }}"
                                placeholder="username (opsional)">
                            <div id="usernameAvailability" class="mt-1 text-xs"></div>
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="usernameError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div> --}}

                        <!-- Telepon (Opsional) -->
                        {{-- <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('phone') ? 'border border-red-500' : '' }}"
                                placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="phoneError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div> --}}

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                            <input type="password" id="password" name="password" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary {{ $errors->has('password') ? 'border border-red-500' : '' }}"
                                placeholder="Minimal 8 karakter">
                            <div class="text-xs text-gray-500 mt-1">
                                Password harus minimal 8 karakter.
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p id="passwordError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="Ketik ulang password">
                            <p id="passwordConfirmationError" class="error-message text-red-500 text-xs mt-1"></p>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="flex items-center justify-start space-x-1">
                            <input type="checkbox" id="agree_terms" name="agree_terms" value="1"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded {{ $errors->has('agree_terms') ? 'border border-red-500' : '' }}">
                            <label for="agree_terms" class="text-xs text-gray-700">
                                Saya menyetujui
                                <a href="#" class="text-indigo-600 hover:text-indigo-500" target="_blank">
                                    Syarat & Ketentuan
                                </a>
                                dan
                                <a href="#" class="text-indigo-600 hover:text-indigo-500" target="_blank">
                                    Kebijakan Privasi
                                </a>
                                *
                            </label>
                        </div>
                        @error('agree_terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p id="agreeTermsError" class="error-message text-red-500 text-xs mt-1"></p>

                        <div>
                            <button type="submit" id="submitButton"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 transform hover:scale-[1.01] disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="buttonText">Daftar</span>
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
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Masuk di sini
                        </a>
                    </p>
                </div>
                <div class="hidden w-full h-full lg:flex items-center justify-center p-4">
                    <div class="w-full h-full bg-white rounded-xl p-4">
                        <h3 class="text-lg font-semibold mb-4">Keuntungan Bergabung:</h3>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-600">
                            <li>Akses ke semua fitur member</li>
                            <li>Dashboard personal untuk mengelola data</li>
                            <li>Notifikasi dan update terbaru</li>
                            <li>Support 24/7 dari tim kami</li>
                            <li>Komunitas eksklusif member</li>
                        </ul>

                        <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
                            <h4 class="font-semibold text-indigo-800 mb-2">Tips Password Aman:</h4>
                            <ul class="text-xs text-indigo-700 space-y-1">
                                <li>• Gunakan kombinasi huruf besar & kecil</li>
                                <li>• Tambahkan angka dan simbol</li>
                                <li>• Minimal 8 karakter</li>
                                <li>• Jangan gunakan informasi pribadi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
@endsection
