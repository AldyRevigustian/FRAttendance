<x-app-layout>
    @push('styles')
        <style>
            .choices__inner,
            .choices[data-type*="text"] .choices__inner {
                background-color: transparent;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.absensi_store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="siswa_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                Siswa</label>
                            <select name="siswa_id" id="siswa_id"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}" data-kelas-id="{{ $siswa->kelas_id }}"
                                        data-kelas-nama="{{ $siswa->kelas->nama ?? '' }}">
                                        {{ $siswa->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="kelas_nama"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kelas</label>
                            <input type="text" id="kelas_nama" disabled
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-300">
                        </div>

                        <input type="hidden" name="kelas_id" id="kelas_id">

                        <div class="mb-6">
                            <label for="tanggal"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                            @error('tanggal')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="waktu_masuk"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Waktu Masuk</label>
                            <input type="time" name="waktu_masuk" id="waktu_masuk"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            @error('waktu_masuk')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="waktu_keluar"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Waktu Keluar</label>
                            <input type="time" name="waktu_keluar" id="waktu_keluar"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            @error('waktu_keluar')
                                <span class="text-red-500 text-sm" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md focus:outline-none">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const pad = n => n.toString().padStart(2, '0');

            const jamMasuk = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
            const tanggalHariIni = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())}`;

            document.getElementById('siswa_id').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const kelasId = selectedOption.getAttribute('data-kelas-id');
                const kelasNama = selectedOption.getAttribute('data-kelas-nama');

                document.getElementById('kelas_id').value = kelasId;
                document.getElementById('kelas_nama').value = kelasNama;
            });

            document.getElementById('waktu_masuk').value = jamMasuk;
            document.getElementById('tanggal').value = tanggalHariIni;

            const kelasSelect = document.getElementById('siswa_id');
            if (kelasSelect) {
                const choices = new Choices(kelasSelect, {
                    // removeItemButton: true,
                    searchEnabled: true,
                });
            }
        });
    </script>


</x-app-layout>
