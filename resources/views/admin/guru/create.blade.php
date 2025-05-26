<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.guru_store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="kode"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kode</label>
                            <input type="text" name="kode" id="kode"
                            placeholder="Masukkan Kode"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                            @error('kode')
                                <span class="text-red-500 text-sm" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="nama"

                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                            <input type="text" name="nama" id="nama"
                            placeholder="Masukkan Nama"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                            @error('nama')
                                <span class="text-red-500 text-sm" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email"
                            placeholder="Masukkan Email"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                            @error('email')
                                <span class="text-red-500 text-sm" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                            <input type="password" name="password" id="password"
                            placeholder="Masukkan Password"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                            @error('password')
                                <span class="text-red-500 text-sm" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="jenis_kelamin"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                                <option value="" selected disabled>-- Jenis Kelamin --</option>
                                <option value="0">Laki-laki
                                </option>
                                <option value="1">Perempuan
                                </option>
                            </select>
                        </div>

                        <button type="submit" id="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md focus:outline-none">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
