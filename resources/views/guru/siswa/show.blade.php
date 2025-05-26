@extends('layouts.guru')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Show Siswa') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <label for="nis" class="block text-sm font-medium text-gray-700 dark:text-gray-200">NIS</label>
                        <input type="text" name="nis" id="nis" readonly
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            value="{{ $siswa->id }}">
                    </div>

                    <div class="mb-6">
                        <label for="nama"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                        <input type="text" name="nama" id="nama" readonly
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            value="{{ $siswa->nama }}">
                    </div>

                    <div class="mb-6">
                        <label for="jenis_kelamin"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jenis_kelamin</label>
                        <input type="text" name="jenis_kelamin" id="jenis_kelamin" readonly
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            value="{{ $siswa->jenis_kelamin == 0 ? 'Laki-laki' : 'Perempuan' }}">
                    </div>

                    <div class="mb-6">
                        <label for="kelas"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kelas</label>
                        <input type="text" id="kelas" disabled
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            value="{{ $siswa->kelas->nama }}">
                    </div>

                    <div id="photo-container" class="grid grid-cols-5 gap-2 mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const photoContainer = document.getElementById('photo-container');
        const deleteAllBtn = document.getElementById('delete-all-btn');
        const idSiswa = "{{ $siswa->id }}";
        const basePath = `/images/${idSiswa}/`;
        const files = ['0.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg'];

        let hasImages = false;

        files.forEach(file => {
            const imgPath = `${basePath}${file}`;

            const img = document.createElement('img');
            img.src = imgPath;
            img.alt = file;
            img.className = 'w-full h-auto rounded-md shadow';

            img.onload = () => {
                hasImages = true;
                deleteAllBtn.classList.remove('hidden');
            };

            img.onerror = () => {
                img.style.display = 'none';
            };

            photoContainer.appendChild(img);
        });
    </script>
@endsection
