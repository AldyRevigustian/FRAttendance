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

        .input-group input, .input-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-group input:focus, .input-group select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .input-group .flex {
            display: flex;
            gap: 10px;
        }

        .input-group select {
            flex: 1;
            cursor: pointer;
        }

        .refresh-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
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
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </div>
            <h2>Portal Guru</h2>
            <p>Akses semua perangkat dan sumber daya mengajar Anda di satu tempat.</p>
        </div>
        <div class="login-form-container">
            <h1>Login Guru</h1>
            <p class="welcome-text">Silakan masuk untuk melanjutkan.</p>

            <x-auth-session-status class="success-message" :status="session('status')" />

            <form method="POST" action="{{ route('guru.login.auth') }}">
                @csrf
                <div class="input-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="input-group">
                    <label for="kelas_id">{{ __('Pilih Kelas') }}</label>
                    <div class="flex">
                        <select name="kelas_id" id="kelas_id">
                            <option value="" disabled selected style="color: #929292;">-- Refresh untuk memuat kelas --
                            </option>
                        </select>
                        <button type="button" id="refresh-kelas" class="refresh-btn">
                            <svg fill="currentColor" viewBox="-1.5 -2.5 24 24" xmlns="http://www.w3.org/2000/svg"
                                preserveAspectRatio="xMinYMin" class="w-5 h-5">
                                <path
                                    d="M17.83 4.194l.42-1.377a1 1 0 1 1 1.913.585l-1.17 3.825a1 1 0 0 1-1.248.664l-3.825-1.17a1 1 0 1 1 .585-1.912l1.672.511A7.381 7.381 0 0 0 3.185 6.584l-.26.633a1 1 0 1 1-1.85-.758l.26-.633A9.381 9.381 0 0 1 17.83 4.194zM2.308 14.807l-.327 1.311a1 1 0 1 1-1.94-.484l.967-3.88a1 1 0 0 1 1.265-.716l3.828.954a1 1 0 0 1-.484 1.941l-1.786-.445a7.384 7.384 0 0 0 13.216-1.792 1 1 0 1 1 1.906.608 9.381 9.381 0 0 1-5.38 5.831 9.386 9.386 0 0 1-11.265-3.328z" />
                            </svg>
                            Refresh
                        </button>
                    </div>
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

    <script>
        document.getElementById('refresh-kelas').addEventListener('click', function() {
            const email = document.getElementById('email').value;
            const select = document.getElementById('kelas_id');

            if (!email) {
                alert('Silakan isi email terlebih dahulu!');
                return;
            }

            fetch(`/api/kelas-by-email?email=${encodeURIComponent(email)}`)
                .then(response => response.json())
                .then(data => {
                    select.innerHTML = '';

                    if (data.length === 0) {
                        select.innerHTML = '<option value="" selected disabled>Tidak ada kelas ditemukan</option>';
                        return;
                    }

                    select.innerHTML = '<option value="" selected disabled>-- Pilih Kelas --</option>';
                    data.forEach(kelas => {
                        const option = document.createElement('option');
                        option.value = kelas.id;
                        option.textContent = kelas.nama;
                        select.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal mengambil data kelas.');
                });
        });
    </script>
</x-guest-layout>
