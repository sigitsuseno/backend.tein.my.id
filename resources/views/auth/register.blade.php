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
    <script>
        class RegisterManager {
            constructor() {
                this.registerForm = document.getElementById('registerForm');
                this.submitButton = document.getElementById('submitButton');
                this.buttonText = document.getElementById('buttonText');
                this.buttonSpinner = document.getElementById('buttonSpinner');
                this.generalError = document.getElementById('generalError');
                this.generalErrorText = document.getElementById('generalErrorText');

                this.debounceTimers = {};

                this.init();
            }

            init() {
                this.bindEvents();
                this.setupRealTimeValidation();
            }

            bindEvents() {
                // Form submission
                this.registerForm.addEventListener('submit', (e) => this.handleRegister(e));

                // Clear errors on input
                const inputs = this.registerForm.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        this.hideFieldError(input.name);
                        this.hideGeneralError();
                    });
                });

                // Real-time availability checks
                document.getElementById('email').addEventListener('blur', () => this.checkEmailAvailability());
                document.getElementById('username').addEventListener('blur', () => this.checkUsernameAvailability());
            }

            setupRealTimeValidation() {
                // Password strength indicator
                document.getElementById('password').addEventListener('input', (e) => {
                    this.updatePasswordStrength(e.target.value);
                });

                // Password confirmation match
                document.getElementById('password_confirmation').addEventListener('input', (e) => {
                    this.checkPasswordMatch();
                });
            }

            async handleRegister(e) {
                e.preventDefault();

                // Reset errors
                this.hideGeneralError();
                this.hideAllFieldErrors();

                // Validate form
                if (!this.validateForm()) {
                    return;
                }

                // Show loading state
                this.setLoadingState(true);

                try {
                    await this.submitRegistration();
                } catch (error) {
                    console.error('Registration error:', error);
                    this.showGeneralError('Terjadi kesalahan jaringan. Silakan coba lagi.');
                    this.setLoadingState(false);
                }
            }

            validateForm() {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                const agreeTerms = document.getElementById('agree_terms').checked;

                let isValid = true;

                // Validate name
                if (!name) {
                    this.showFieldError('name', 'Nama lengkap wajib diisi.');
                    isValid = false;
                } else if (name.length < 2) {
                    this.showFieldError('name', 'Nama terlalu pendek.');
                    isValid = false;
                }

                // Validate email
                if (!email) {
                    this.showFieldError('email', 'Alamat email wajib diisi.');
                    isValid = false;
                } else if (!this.isValidEmail(email)) {
                    this.showFieldError('email', 'Format email tidak valid.');
                    isValid = false;
                }

                // Validate password
                if (!password) {
                    this.showFieldError('password', 'Password wajib diisi.');
                    isValid = false;
                } else if (password.length < 8) {
                    this.showFieldError('password', 'Password minimal 8 karakter.');
                    isValid = false;
                }

                // Validate password confirmation
                if (!passwordConfirmation) {
                    this.showFieldError('password_confirmation', 'Konfirmasi password wajib diisi.');
                    isValid = false;
                } else if (password !== passwordConfirmation) {
                    this.showFieldError('password_confirmation', 'Konfirmasi password tidak cocok.');
                    isValid = false;
                }

                // Validate terms agreement
                if (!agreeTerms) {
                    this.showFieldError('agree_terms', 'Anda harus menyetujui syarat dan ketentuan.');
                    isValid = false;
                }

                return isValid;
            }

            async submitRegistration() {
                const formData = new FormData(this.registerForm);

                // Add AJAX indicator
                formData.append('_ajax', 'true');

                try {
                    const response = await fetch(this.registerForm.action, {
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

                    // Registration successful
                    this.handleRegistrationSuccess(data);

                } catch (error) {
                    this.handleRegistrationError(error);
                }
            }

            handleRegistrationSuccess(data) {
                // Show success message
                this.showSuccessMessage(data.message || 'Registrasi berhasil!');

                // Redirect after short delay
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                }, 2000);
            }

            handleRegistrationError(error) {
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
                    console.error('Registration error:', error);
                }
            }

            // Availability Checks
            async checkEmailAvailability() {
                const email = document.getElementById('email').value.trim();
                const availabilityDiv = document.getElementById('emailAvailability');

                if (!email || !this.isValidEmail(email)) {
                    availabilityDiv.innerHTML = '';
                    return;
                }

                // Debounce requests
                this.debounce('email', async () => {
                    try {
                        availabilityDiv.innerHTML =
                            '<span class="text-gray-500">Memeriksa ketersediaan...</span>';

                        const response = await fetch('/check-email', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                email: email
                            })
                        });

                        const data = await response.json();

                        if (data.available) {
                            availabilityDiv.innerHTML =
                                '<span class="text-green-600">✓ Email tersedia</span>';
                        } else {
                            availabilityDiv.innerHTML =
                                '<span class="text-red-600">✗ Email sudah terdaftar</span>';
                            this.showFieldError('email', 'Email sudah terdaftar.');
                        }
                    } catch (error) {
                        console.error('Email check error:', error);
                        availabilityDiv.innerHTML = '';
                    }
                }, 500);
            }

            async checkUsernameAvailability() {
                const username = document.getElementById('username').value.trim();
                const availabilityDiv = document.getElementById('usernameAvailability');

                if (!username) {
                    availabilityDiv.innerHTML = '';
                    return;
                }

                if (username.length < 3) {
                    availabilityDiv.innerHTML = '<span class="text-yellow-600">Username minimal 3 karakter</span>';
                    return;
                }

                // Debounce requests
                this.debounce('username', async () => {
                    try {
                        availabilityDiv.innerHTML =
                            '<span class="text-gray-500">Memeriksa ketersediaan...</span>';

                        const response = await fetch('/check-username', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                username: username
                            })
                        });

                        const data = await response.json();

                        if (data.available) {
                            availabilityDiv.innerHTML =
                                '<span class="text-green-600">✓ Username tersedia</span>';
                        } else {
                            availabilityDiv.innerHTML =
                                '<span class="text-red-600">✗ Username sudah digunakan</span>';
                            this.showFieldError('username', 'Username sudah digunakan.');
                        }
                    } catch (error) {
                        console.error('Username check error:', error);
                        availabilityDiv.innerHTML = '';
                    }
                }, 500);
            }

            updatePasswordStrength(password) {
                // Simple password strength indicator
                let strength = 0;
                let message = '';
                let color = 'text-red-600';

                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                switch (strength) {
                    case 0:
                    case 1:
                        message = 'Password lemah';
                        color = 'text-red-600';
                        break;
                    case 2:
                        message = 'Password cukup';
                        color = 'text-yellow-600';
                        break;
                    case 3:
                        message = 'Password kuat';
                        color = 'text-green-600';
                        break;
                    case 4:
                        message = 'Password sangat kuat';
                        color = 'text-green-700';
                        break;
                }

                // You can update a password strength indicator element here
                console.log('Password strength:', message);
            }

            checkPasswordMatch() {
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;

                if (passwordConfirmation && password !== passwordConfirmation) {
                    this.showFieldError('password_confirmation', 'Password tidak cocok.');
                } else if (passwordConfirmation) {
                    this.hideFieldError('password_confirmation');
                }
            }

            // Utility Methods
            debounce(key, func, delay) {
                clearTimeout(this.debounceTimers[key]);
                this.debounceTimers[key] = setTimeout(func, delay);
            }

            setLoadingState(loading) {
                if (loading) {
                    this.submitButton.disabled = true;
                    this.buttonText.textContent = 'Mendaftarkan...';
                    this.buttonSpinner.classList.remove('hidden');
                } else {
                    this.submitButton.disabled = false;
                    this.buttonText.textContent = 'Daftar';
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

            hideAllFieldErrors() {
                const fields = ['name', 'email', 'username', 'phone', 'password', 'password_confirmation',
                    'agree_terms'
                ];
                fields.forEach(field => this.hideFieldError(field));
            }

            showSuccessMessage(message) {
                // Create temporary success message
                const successDiv = document.createElement('div');
                successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4';
                successDiv.innerHTML = `
            <strong class="font-bold">Sukses! </strong>
            <span class="block sm:inline">${message}</span>
        `;

                this.registerForm.parentNode.insertBefore(successDiv, this.registerForm);

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

        // Initialize Register Manager when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            new RegisterManager();
        });

        // Export for global access (optional)
        window.RegisterManager = RegisterManager;
    </script>
@endsection
