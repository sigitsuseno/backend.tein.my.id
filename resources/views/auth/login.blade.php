@extends('layouts.auth-layout')

@section('content')
    <main class="w-full h-full overflow-y-auto">
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
    <script>
        class AuthManager {
            constructor() {
                this.loginForm = document.getElementById('loginForm');
                this.submitButton = document.getElementById('submitButton');
                this.buttonText = document.getElementById('buttonText');
                this.buttonSpinner = document.getElementById('buttonSpinner');
                this.generalError = document.getElementById('generalError');
                this.generalErrorText = document.getElementById('generalErrorText');

                this.init();
            }

            init() {
                this.bindEvents();
                this.checkAuthenticationStatus();
            }

            bindEvents() {
                // Form submission
                this.loginForm.addEventListener('submit', (e) => this.handleLogin(e));

                // Clear errors on input
                const inputs = this.loginForm.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        this.hideFieldError(input.name);
                        this.hideGeneralError();
                    });
                });

                // Enter key support
                this.loginForm.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.handleLogin(e);
                    }
                });
            }

            async handleLogin(e) {
                e.preventDefault();

                // Reset errors
                this.hideGeneralError();
                this.hideFieldError('email');
                this.hideFieldError('password');

                // Validate form
                if (!this.validateForm()) {
                    return;
                }

                // Show loading state
                this.setLoadingState(true);

                try {
                    await this.submitLogin();
                } catch (error) {
                    console.error('Login error:', error);
                    this.showGeneralError('Terjadi kesalahan jaringan. Silakan coba lagi.');
                    this.setLoadingState(false);
                }
            }

            validateForm() {
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;

                // Check empty fields
                if (!email || !password) {
                    this.showGeneralError('Harap isi semua field yang diperlukan.');
                    return false;
                }

                // Validate email format
                if (!this.isValidEmail(email)) {
                    this.showFieldError('email', 'Format email tidak valid.');
                    return false;
                }

                // Validate password length
                if (password.length < 8) {
                    this.showFieldError('password', 'Password minimal 8 karakter.');
                    return false;
                }

                return true;
            }

            async submitLogin() {
                const formData = new FormData(this.loginForm);

                // Add AJAX indicator
                formData.append('_ajax', 'true');

                try {
                    const response = await fetch(this.loginForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw data;
                    }

                    // Login successful
                    this.handleLoginSuccess(data);

                } catch (error) {
                    this.handleLoginError(error);
                }
            }

            handleLoginSuccess(data) {
                // Show success message
                this.showSuccessMessage(data.message || 'Login berhasil!');

                // Redirect after short delay
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                }, 1000);
            }

            handleLoginError(error) {
                this.setLoadingState(false);

                // Handle validation errors
                if (error.errors) {
                    Object.keys(error.errors).forEach(field => {
                        this.showFieldError(field, error.errors[field][0]);
                    });

                    // Focus on first error field
                    const firstErrorField = Object.keys(error.errors)[0];
                    const firstInput = document.getElementById(firstErrorField);
                    if (firstInput) {
                        firstInput.focus();
                    }
                }
                // Handle general error message
                else if (error.message) {
                    this.showGeneralError(error.message);
                }
                // Handle server errors
                else {
                    this.showGeneralError('Terjadi kesalahan server. Silakan coba lagi.');
                }

                // Log error for debugging
                if (console && console.error) {
                    console.error('Login error:', error);
                }
            }

            async checkAuthenticationStatus() {
                try {
                    const response = await fetch('/auth/check', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.authenticated) {
                        console.log('User is authenticated:', data.user);
                        // Anda bisa melakukan sesuatu jika user sudah login
                    }
                } catch (error) {
                    console.log('Auth check failed - user probably not authenticated');
                }
            }

            // Utility Methods
            setLoadingState(loading) {
                if (loading) {
                    this.submitButton.disabled = true;
                    this.buttonText.textContent = 'Memproses...';
                    this.buttonSpinner.classList.remove('hidden');
                } else {
                    this.submitButton.disabled = false;
                    this.buttonText.textContent = 'Masuk';
                    this.buttonSpinner.classList.add('hidden');
                }
            }

            showGeneralError(message) {
                this.generalErrorText.textContent = message;
                this.generalError.classList.remove('hidden');
                this.generalError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            hideGeneralError() {
                this.generalError.classList.add('hidden');
            }

            showFieldError(field, message) {
                const errorElement = document.getElementById(field + 'Error');
                const inputElement = document.getElementById(field);

                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                }

                if (inputElement) {
                    inputElement.classList.add('border', 'border-red-500');
                    inputElement.focus();
                }
            }

            hideFieldError(field) {
                const errorElement = document.getElementById(field + 'Error');
                const inputElement = document.getElementById(field);

                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.classList.add('hidden');
                }

                if (inputElement) {
                    inputElement.classList.remove('border', 'border-red-500');
                }
            }

            showSuccessMessage(message) {
                // Create temporary success message
                const successDiv = document.createElement('div');
                successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4';
                successDiv.innerHTML = `
            <strong class="font-bold">Sukses! </strong>
            <span class="block sm:inline">${message}</span>
        `;

                this.loginForm.parentNode.insertBefore(successDiv, this.loginForm);

                // Remove success message after 3 seconds
                setTimeout(() => {
                    successDiv.remove();
                }, 3000);
            }

            isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
        }

        // Initialize Auth Manager when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            new AuthManager();
        });

        // Export for global access (optional)
        window.AuthManager = AuthManager;
    </script>
@endsection
