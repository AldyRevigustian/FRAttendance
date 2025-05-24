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
                    <a href="{{ route('admin.absensi_create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-black text-sm font-semibold rounded-md focus:outline-none mb-4">
                        Hidupkan Mesin
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
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
                                <th class="w-1/12 text-center">Masuk</th>
                                <th class="w-1/12 text-center">Keluar</th>
                                <th class="w-[180px]">Tanggal</th>
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
                                    <td class="text-center align-middle ">
                                        <label class="inline-flex items-center space-x-2 cursor-pointer mr-[20px]">
                                            <input type="checkbox" disabled checked
                                                class="w-5 h-5 text-green-600 bg-green-100 border-green-400 rounded focus:ring-green-500 cursor-not-allowed" />
                                        </label>
                                    </td>
                                    <td class="text-center align-middle">
                                        <label class="inline-flex items-center space-x-2 cursor-pointer mr-[20px]">
                                            <input type="checkbox" disabled {{ 0 ? 'checked' : '' }}
                                                class="@if (0) w-5 h-5 text-red-600 bg-red-100 border-red-400 focus:ring-red-500 @else w-5 h-5 bg-red-50 border-red-200 cursor-not-allowed opacity-50 @endif rounded" />
                                        </label>
                                    </td>
                                    <td>{{ $absensi->tanggal }}</td>

                                    {{-- <td class="flex space-x-2">
                                        <form action="{{ route('admin.absensi_destroy', $absensi->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Hapus
                                            </button>
                                        </form>
                                    </td> --}}

                                    <td class="flex space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.kelas_edit', $absensi->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs font-semibold rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.absensi_destroy', $absensi->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Hapus
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
