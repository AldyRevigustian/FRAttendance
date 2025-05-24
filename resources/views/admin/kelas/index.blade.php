<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('admin.kelas_create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-black text-sm font-semibold rounded-md focus:outline-none mb-4">
                        Tambah Kelas
                    </a>

                    @if (session('success'))
                        <div
                            class="mb-4
                        p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                            <strong class="font-medium">Success!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <table id="kelasTable" class="stripe w-full">
                        <thead>
                            <tr>
                                <th class="w-2">No</th>
                                <th class="w-1/12">Nama Kelas</th>
                                <th>Wali Kelas</th>
                                <th class="w-1/12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $key => $kelasItem)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $kelasItem->nama }}</td>
                                    <td>{{ $kelasItem->guru->nama }}</td>
                                    <td class="flex space-x-2">
                                        <a href="{{ route('admin.kelas_edit', $kelasItem->id) }}"
                                            class="inline-flex items-center justify-center p-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-colors duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.kelas_destroy', $kelasItem->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center p-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-150"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <span class="sr-only">Hapus Kelas</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                $('#kelasTable').DataTable({
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
