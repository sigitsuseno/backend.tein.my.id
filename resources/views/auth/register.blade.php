@extends('layouts.web-layout')
@section('content')
    <main class="w-full h-full overflow-y-auto">
        <div class="max-w-4xl mx-auto h-screen flex items-center justify-center px-4">
            <div class="w-full grid grid-cols-1 lg:grid-cols-[400px_1fr] bg-white/30 rounded-2xl">
                <div class="p-4">
                    <div class="w-full flex items-center justify-center my-6">
                        <img src="{{ $main_logo }}" alt="" class="w-1/2">
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div id="generalError"
                            class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg"
                            role="alert">
                            <span id="generalErrorText" class="block"></span>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" name="name"
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="Your Name" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="nama@contoh.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata
                                Sandi</label>
                            <input type="password" id="password" name="password"
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="Ulangi Kata Sandi">
                        </div>

                        <div>
                            <button type="submit" id="submitButton"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 transform hover:scale-[1.01]">
                                Daftar
                            </button>
                        </div>
                    </form>
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('loginform') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Login sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
@endsection
