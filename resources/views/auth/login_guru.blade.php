<x-guest-layout>
    <style>
        select:invalid {
            color: #929292;
            /* warna saat opsi default yg disabled dipilih */
        }
    </style>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('guru.login.auth') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="kelas_id" :value="__('Pilih Kelas')" />
            <div class="flex gap-2">
                <select name="kelas_id" id="kelas_id" class="w-full border-gray-300 rounded-md">
                    <option value="" disabled selected style="color: #929292;">-- Refresh untuk memuat kelas --
                    </option>
                </select>
                <button type="button" id="refresh-kelas"
                    class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600 flex items-center gap-2">
                    <svg fill="#ffffff" viewBox="-1.5 -2.5 24 24" xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="xMinYMin" class="w-5 h-5">
                        <path
                            d="M17.83 4.194l.42-1.377a1 1 0 1 1 1.913.585l-1.17 3.825a1 1 0 0 1-1.248.664l-3.825-1.17a1 1 0 1 1 .585-1.912l1.672.511A7.381 7.381 0 0 0 3.185 6.584l-.26.633a1 1 0 1 1-1.85-.758l.26-.633A9.381 9.381 0 0 1 17.83 4.194zM2.308 14.807l-.327 1.311a1 1 0 1 1-1.94-.484l.967-3.88a1 1 0 0 1 1.265-.716l3.828.954a1 1 0 0 1-.484 1.941l-1.786-.445a7.384 7.384 0 0 0 13.216-1.792 1 1 0 1 1 1.906.608 9.381 9.381 0 0 1-5.38 5.831 9.386 9.386 0 0 1-11.265-3.328z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="w-full py-2 rounded-md bg-gray-200 hover:bg-gray-300">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

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
