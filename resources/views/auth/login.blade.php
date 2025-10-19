@extends('layouts.auth-layout')

@section('content')
    <main class="w-full h-full overflow-y-auto">
        <div class="max-w-4xl mx-auto h-screen flex items-center justify-center px-4">
            <div class="w-full grid grid-cols-1 lg:grid-cols-[400px_1fr] bg-white/30 rounded-2xl">
                <div class="p-4">
                    <div class="w-full flex items-center justify-center my-6">
                        <img src="{{ $main_logo }}" alt="" class="w-1/2">
                    </div>
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <div id="generalError"
                            class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg"
                            role="alert">
                            <span id="generalErrorText" class="block"></span>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="nama@contoh.com">
                            <p id="emailError" class="error-message"></p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata
                                Sandi</label>
                            <input type="password" id="password" name="password" required
                                class="w-full h-10 outline-none flex items-center px-4 text-sm rounded-md bg-white/80 focus:bg-white focus:ring ring-primary"
                                placeholder="Minimal 8 karakter">
                            <p id="passwordError" class="error-message"></p>
                        </div>

                        <div>
                            <button type="submit" id="submitButton"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 transform hover:scale-[1.01]">
                                Masuk
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
                        <h3>Instruksi :</h3>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
@endsection
