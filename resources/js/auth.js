const lagimaulogin = document.getElementById('lagimaulogin');
if (lagimaulogin) {
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
            // this.checkAuthenticationStatus();
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
    document.addEventListener('DOMContentLoaded', function () {
        new AuthManager();
    });

    // Export for global access (optional)
    window.AuthManager = AuthManager;
}

const lagimauregister = document.getElementById('lagimauregister');
if (lagimauregister) {
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
    document.addEventListener('DOMContentLoaded', function () {
        new RegisterManager();
    });

    // Export for global access (optional)
    window.RegisterManager = RegisterManager;
}