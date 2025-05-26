<x-guest-layout>
    <style>
        select:invalid {
            color: #929292;
            /* warna saat opsi default yg disabled dipilih */
        }

        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(240, 248, 255, 0.8));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.05);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .refresh-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.875rem 1rem;
            border-radius: 12px;
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
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .remember-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .remember-checkbox input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 6px;
            border: 2px solid #d1d5db;
            cursor: pointer;
        }

        .remember-checkbox input[type="checkbox"]:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .error-message {
            color: #ef4444;
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
    </style>

    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Login Guru</h1>
            <p class="login-subtitle">Silakan masuk ke akun guru Anda</p>

            <x-auth-session-status class="success-message" :status="session('status')" />

            <form method="POST" action="{{ route('guru.login.auth') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required
                        autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <div class="form-group">
                    <label for="kelas_id" class="form-label">{{ __('Pilih Kelas') }}</label>
                    <div class="flex gap-3">
                        <select name="kelas_id" id="kelas_id" class="form-select" style="flex: 1;">
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

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" class="form-input" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>

                <div class="remember-checkbox">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me" class="text-sm text-gray-600">{{ __('Remember me') }}</label>
                </div>

                <button type="submit" class="login-btn">
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
