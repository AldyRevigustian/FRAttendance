@extends('layouts.guru')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Daftar Absensi') }} {{ $kelas->nama }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 mt-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                            <strong class="font-medium">Success!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <table id="siswaTable" class="stripe w-full">
                        <thead>
                            <tr>
                                <th class="w-2">No.</th>
                                <th class="w-3">NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th class="w-1/12">Kelas</th>
                                <th class="w-[120px]">Status</th>
                                <th class="w-1/12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $key => $siswa)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $siswa->id }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->jenis_kelamin == 0 ? 'Laki - laki' : 'Perempuan' }}</td>
                                    <td>{{ $siswa->kelas->nama }}</td>
                                    <td class="space-x-2">
                                        @if ($siswa->is_trained == 0)
                                            <span
                                                class="inline-block px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded-full">Not
                                                Trained</span>
                                        @else
                                            <span
                                                class="inline-block px-3 py-1 text-sm font-semibold text-white bg-green-600 rounded-full">Trained</span>
                                        @endif
                                    </td>
                                    <td class="flex space-x-2">
                                        <a href="{{ route('guru.siswa_show', ['kelas_terpilih' => session('kelas_aktif'), 'id' => $siswa->id]) }}"
                                            class="inline-flex items-center justify-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-colors duration-150">
                                            <span class="sr-only">Edit Anggota</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#siswaTable').DataTable({
                "processing": true,
                "serverSide": false,
                "paging": true,
                "searching": true,
                "ordering": true
            });
        });
    </script>
@endpush
