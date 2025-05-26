<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Absensi') }}
        </h2>
    </x-slot>

    <form action="{{ route('admin.absensi_update', $absensi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-6">
                            <label for="siswa_nama"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Siswa</label>
                            <input type="text" id="siswa_nama" disabled
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-300"
                                value="{{ $absensi->siswa->nama ?? '' }}">
                            <input type="hidden" name="siswa_id" value="{{ $absensi->siswa_id }}">
                        </div>

                        <div class="mb-6">
                            <label for="kelas_nama"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kelas</label>
                            <input type="text" id="kelas_nama" disabled
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-300"
                                value="{{ $absensi->kelas->nama ?? '' }}">
                            <input type="hidden" name="kelas_id" value="{{ $absensi->kelas_id }}">
                        </div>

                        <div class="mb-6">
                            <label for="tanggal"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="{{ old('tanggal', $absensi->tanggal) }}">
                            @error('tanggal')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="waktu_masuk"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Waktu Masuk</label>
                            <input type="time" name="waktu_masuk" id="waktu_masuk"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="{{ old('waktu_masuk', \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i')) }}">
                            @error('waktu_masuk')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="waktu_keluar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Waktu Keluar</label>
                            <input type="time" name="waktu_keluar" id="waktu_keluar"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                value="{{ old('waktu_keluar', $absensi->waktu_keluar ? \Carbon\Carbon::parse($absensi->waktu_keluar)->format('H:i') : '') }}">
                            @error('waktu_keluar')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md focus:outline-none">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
