<x-guest-layout>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap");

        :root {
            --primary-color: #4f46e5; /* Indigo */
            --secondary-color: #f8f9fa;
            --accent-color: #6366f1;
            --text-color: #212529;
            --input-border-color: #ced4da;
            --card-bg-color: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Nunito", sans-serif;
            background-color: var(--secondary-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-color);
            padding: 20px;
            background-image: url("data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23dddddd' fill-opacity='0.4'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .login-wrapper {
            display: flex;
            background-color: var(--card-bg-color);
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            max-width: 800px;
            width: 100%;
        }

        .login-info {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 50px 40px;
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-info h2 {
            font-family: "Poppins", sans-serif;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .login-info p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .login-info .icon {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
        }

        .login-info .icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        .login-form-container {
            padding: 50px 40px;
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-container h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            font-family: "Poppins", sans-serif;
        }

        .login-form-container .welcome-text {
            margin-bottom: 30px;
            color: #555;
            font-size: 16px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-color);
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .options .remember-me {
            display: flex;
            align-items: center;
        }

        .options .remember-me label {
            font-weight: normal;
            margin-left: 5px;
        }

        .options a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .options a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .login-button:active {
            transform: scale(0.98);
        }

        .footer-text {
            margin-top: 30px;
            font-size: 13px;
            color: #777;
            text-align: center;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .success-message {
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 450px;
            }
            .login-info,
            .login-form-container {
                width: 100%;
            }
            .login-info {
                padding: 40px 30px;
                border-radius: 15px 15px 0 0;
            }
            .login-info h2 {
                font-size: 22px;
            }
            .login-info p {
                font-size: 15px;
            }
            .login-form-container {
                padding: 40px 30px;
                border-radius: 0 0 15px 15px;
            }
            .login-form-container h1 {
                font-size: 24px;
            }
        }
    </style>

    <div class="login-wrapper">
        <div class="login-info">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                </svg>
            </div>
            <h2>Portal Admin</h2>
            <p>Kelola sistem absensi face recognition, data siswa, guru, dan kelas dalam satu platform terpadu.</p>
        </div>
        <div class="login-form-container">
            <h1>Login Admin</h1>
            <p class="welcome-text">Selamat datang, silakan masuk ke panel admin.</p>

            <x-auth-session-status class="success-message" :status="session('status')" />

            <form method="POST" action="{{ route('admin.login.auth') }}">
                @csrf
                <div class="input-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="input-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>

                <div class="options">
                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">{{ __('Remember me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-button">
                    {{ __('Masuk') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
