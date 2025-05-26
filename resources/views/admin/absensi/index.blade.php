<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <a href="{{ route('admin.absensi_create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md focus:outline-none">
                            Tambah Absensi
                        </a>

                        <!-- Date and Class Filter Form -->
                        <form method="GET" action="{{ route('admin.absensi') }}" class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <label for="start_date"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">Dari:</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ request('start_date', $startDate) }}"
                                    class="px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            </div>
                            <div class="flex items-center space-x-2">
                                <label for="end_date"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">Sampai:</label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ request('end_date', $endDate) }}"
                                    class="px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            </div>
                            <div class="flex items-center space-x-2">
                                <label for="kelas_id"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">Kelas:</label>
                                <select name="kelas_id" id="kelas_id"
                                    class="px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($allKelas as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                                </svg>
                                Filter
                            </button>
                            @if (request('start_date') || request('end_date') || request('kelas_id'))
                                <a href="{{ route('admin.absensi') }}"
                                    class="inline-flex items-center px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 mt-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                            <strong class="font-medium">Success!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Absensi Table -->
                    <table id="absensiTable" class="stripe w-full">
                        <thead>
                            <tr>
                                <th class="w-2">No</th>
                                <th class="w-2">NIS</th>
                                <th>Nama Siswa</th>
                                <th class="w-1/12">Kelas</th>
                                <th class="w-[120px] text-center">Tanggal</th>
                                <th class="w-1/12 text-center">Masuk</th>
                                <th class="w-1/12 text-center">Keluar</th>
                                <th class="w-1/12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensis as $key => $absensi)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $absensi->siswa->id }}</td>
                                    <td>{{ $absensi->siswa->nama }}</td>
                                    <td>{{ $absensi->kelas->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</td>
                                    <td class="text-start align-start">
                                        <label class="inline-flex items-start space-x-2 cursor-default">
                                            <input type="checkbox" disabled
                                                {{ $absensi->waktu_masuk ? 'checked' : '' }}
                                                class="w-5 h-5 text-green-600 bg-green-100 border-green-400 rounded focus:ring-green-500 cursor-not-allowed" />
                                            <span class="text-sm text-gray-700">
                                                {{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i') : '-' }}
                                            </span>
                                        </label>
                                    </td>
                                    <td class="text-start align-start">
                                        <label class="inline-flex items-start space-x-2 cursor-default">
                                            <input type="checkbox" disabled
                                                {{ $absensi->waktu_keluar ? 'checked' : '' }}
                                                class="w-5 h-5 text-red-600 bg-red-100 border-red-400 rounded focus:ring-red-500 cursor-not-allowed" />
                                            <span class="text-sm text-gray-700">
                                                {{ $absensi->waktu_keluar ? \Carbon\Carbon::parse($absensi->waktu_keluar)->format('H:i') : '-' }}
                                            </span>
                                        </label>
                                    </td>
                                    <td class="flex space-x-2">
                                        <a href="{{ route('admin.absensi_edit', $absensi->id) }}"
                                            class="inline-flex items-center justify-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-colors duration-150">
                                            <span class="sr-only">Edit Anggota</span> <svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.absensi_destroy', $absensi->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-150"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <span class="sr-only">Hapus Anggota</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#absensiTable').DataTable({
                    "processing": true,
                    "serverSide": false,
                    "paging": true,
                    "searching": true,
                    "ordering": true
                });
            });
        </script>
    @endpush
</x-app-layout>
