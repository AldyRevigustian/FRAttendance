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
            {{ __('Tambah Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.kelas_store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="nama"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama
                                Kelas</label>
                            <input type="text" name="nama" id="nama"
                            placeholder="Masukkan Nama Kelas"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                        </div>

                        <div class="mb-6">
                            <label for="guru_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Wali Kelas</label>
                            <select name="guru_id" id="guru_id"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required>
                                <option value="" disabled selected>-- Pilih Guru --</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" id="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-300 text-white text-sm font-semibold rounded-md focus:outline-none">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const kelasSelect = document.getElementById('guru_id');
                if (kelasSelect) {
                    const choices = new Choices(kelasSelect, {
                        searchEnabled: true,
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
