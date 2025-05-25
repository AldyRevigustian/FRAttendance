<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show Guru') }}
        </h2>
    </x-slot>

    <form action="{{ route('admin.guru_update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-6">
                            <label for="kode"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kode</label>
                            <input type="text" name="kode" id="kode" readonly
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="{{ old('kode', $guru->kode) }}" required>
                        </div>

                        <div class="mb-6">
                            <label for="nama"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="{{ old('nama', $guru->nama) }}" required>
                        </div>
                        <div class="mb-6">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="{{ old('email', $guru->email) }}" required>
                        </div>

                        <div class="mb-6">
                            <label for="jenis_kelamin"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                                <option value="0"
                                    {{ old('jenis_kelamin', $guru->jenis_kelamin) == '0' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="1"
                                    {{ old('jenis_kelamin', $guru->jenis_kelamin) == '1' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                            <input type="pasword" name="password" id="password"
                                placeholder="Kosongkan jika tidak ingin mengubah password"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="">
                        </div>

                        <div id="photo-container" class="grid grid-cols-5 gap-2 mt-4">
                        </div>

                        <button type="submit" id="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md focus:outline-none">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
