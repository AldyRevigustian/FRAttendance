<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg mb-6 border-t-4 border-indigo-600">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter Data
                    </h3>
                    <form id="dashboard-filter" action="{{ route('admin.dashboard') }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="group">
                            <label for="start_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">Tanggal
                                Mulai</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" id="start_date" name="start_date"
                                    value="{{ isset($startDate) ? $startDate->format('Y-m-d') : Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}"
                                    class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                            </div>
                        </div>
                        <div class="group">
                            <label for="end_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">Tanggal
                                Akhir</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" id="end_date" name="end_date"
                                    value="{{ isset($endDate) ? $endDate->format('Y-m-d') : Carbon\Carbon::now()->format('Y-m-d') }}"
                                    class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                            </div>
                        </div>
                        <div class="flex items-end space-x-2 justify-end">
                            <button type="submit"
                                class="flex items-center justify-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700 transition duration-150 ease-in-out">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                            <button type="button" id="refresh-data"
                                class="flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-700 transition duration-150 ease-in-out">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh
                            </button>
                            <a href="{{ route('admin.dashboard.export') }}?start_date={{ isset($startDate) ? $startDate->format('Y-m-d') : '' }}&end_date={{ isset($endDate) ? $endDate->format('Y-m-d') : '' }}&kelas_id={{ $selectedKelasId ?? '' }}"
                                class="flex items-center justify-center px-4 py-3 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-200 active:bg-yellow-700 transition duration-150 ease-in-out">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg sm:rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 border-l-4 border-indigo-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-500 bg-opacity-85 shadow-md">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-siswa"
                                    class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                    {{ $totalSiswa }}</div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Siswa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg sm:rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-85 shadow-md">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-guru"
                                    class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                    {{ $totalGuru }}</div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Guru</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg sm:rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-85 shadow-md">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-kelas"
                                    class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                    {{ $totalKelas }}</div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kelas</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg sm:rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-500 bg-opacity-85 shadow-md">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-absensi-hari-ini"
                                    class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                    {{ $totalAbsensiHariIni }}</div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Absensi Hari Ini
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-all duration-300 sm:rounded-lg overflow-hidden">
                    <div class="p-6 pb-20 border-t-4 border-indigo-500">
                        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4">
                            <h3
                                class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-2 lg:mb-0 flex items-center">
                                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                                Trend Absensi
                            </h3>
                            <div class="relative w-full lg:w-64">
                                <div class="flex items-center">
                                    <div class="relative flex-grow">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select id="trend_kelas_filter"
                                            class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                                            <option value="">Semua Kelas</option>
                                            @foreach ($allKelas as $kelas)
                                                <option value="{{ $kelas->id }}"
                                                    {{ isset($trendKelasId) && $trendKelasId == $kelas->id ? 'selected' : '' }}>
                                                    {{ $kelas->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" id="apply-trend-filter"
                                        class="ml-2 px-3 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200 transition-all duration-200">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="attendance-trend-chart" class="h-80 transition-opacity duration-300"></div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-all duration-300 sm:rounded-lg overflow-hidden">
                    <div class="p-6 border-t-4 border-yellow-500">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-0 flex items-center">
                            <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Absensi per Kelas
                        </h3>
                        <div id="attendance-by-class-chart" class="h-[400px]"></div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 sm:rounded-lg mb-6 border-t-4 border-green-500">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Absensi Terbaru
                    </h3>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table id="recent-attendance-table"
                            class="min-w-full bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Siswa</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="recent-attendance-body">
                                @foreach ($recentAbsensi as $absensi)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                        <td
                                            class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($absensi->updated_at)->format('d M Y H:i') }}
                                        </td>
                                        <td
                                            class="py-3 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                            {{ $absensi->siswa->nama }}
                                        </td>
                                        <td
                                            class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100 rounded-full">
                                                {{ $absensi->kelas->nama }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($recentAbsensi) == 0)
                                    <tr>
                                        <td colspan="3"
                                            class="py-6 px-4 text-sm text-gray-500 dark:text-gray-300 text-center">
                                            <svg class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            Tidak ada data absensi terbaru
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.absensi') }}"
                            class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium text-sm transition-colors duration-150">
                            Lihat Semua
                            <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @php
        function stringToColor($string)
        {
            $code = substr(md5($string), 0, 6);
            return '#' . strtoupper($code);
        }

        $barColors = $absensiByKelas->pluck('nama')->map(fn($nama) => stringToColor($nama));
    @endphp

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let attendanceTrendChart, attendanceByClassChart;
                initializeCharts();

                const refreshInterval = 30000;
                let refreshTimer = setInterval(refreshData, refreshInterval);
                document.getElementById('refresh-data').addEventListener('click', function() {
                    this.classList.add('animate-pulse', 'bg-green-700');
                    const refreshIcon = this.querySelector('svg');
                    refreshIcon.classList.add('animate-spin');

                    refreshData();

                    setTimeout(() => {
                        this.classList.remove('animate-pulse', 'bg-green-700');
                        refreshIcon.classList.remove('animate-spin');
                    }, 1000);
                });

                document.getElementById('apply-trend-filter').addEventListener('click', function() {
                    const kelasId = document.getElementById('trend_kelas_filter').value;
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    this.classList.add('animate-pulse', 'bg-indigo-700');

                    let kelasName = 'Semua Kelas';
                    if (kelasId) {
                        const selectedOption = document.querySelector(
                            `#trend_kelas_filter option[value="${kelasId}"]`);
                        if (selectedOption) {
                            kelasName = selectedOption.textContent.trim();
                        }
                    }

                    fetch(`{{ route('admin.dashboard') }}?start_date=${startDate}&end_date=${endDate}&trend_kelas_id=${kelasId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            attendanceTrendChart.updateSeries([{
                                name: 'Kehadiran',
                                data: data.absensiTrend.map(item => item.count)
                            }]);
                            attendanceTrendChart.updateOptions({
                                xaxis: {
                                    categories: data.absensiTrend.map(item => item.label),
                                    labels: {
                                        style: {
                                            fontSize: '12px',
                                            fontWeight: 500
                                        }
                                    }
                                },
                            });

                            const chartEl = document.getElementById('attendance-trend-chart');
                            chartEl.classList.add('opacity-80');
                            setTimeout(() => {
                                chartEl.classList.remove('opacity-80');
                            }, 300);
                        })
                        .catch(error => {
                            console.error('Error refreshing trend data:', error);
                        })
                        .finally(() => {
                            setTimeout(() => {
                                this.classList.remove('animate-pulse', 'bg-indigo-700');
                            }, 500);
                        });
                });


                document.getElementById('dashboard-filter').addEventListener('submit', function(e) {
                    e.preventDefault();
                    refreshData();


                    const formData = new FormData(this);
                    const queryString = new URLSearchParams(formData).toString();
                    history.pushState(null, null, `${window.location.pathname}?${queryString}`);
                });

                function initializeCharts() {
                    const attendanceTrendOptions = {
                        chart: {
                            type: 'area',
                            height: '100%',
                            toolbar: {
                                show: false
                            },
                            fontFamily: 'Inter, sans-serif',
                            dropShadow: {
                                enabled: true,
                                top: 3,
                                left: 2,
                                blur: 4,
                                opacity: 0.1
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                animateGradually: {
                                    enabled: true,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            }
                        },
                        series: [{
                            name: 'Kehadiran',
                            data: @json(array_map(function ($item) {
                                    return $item['count'];
                                }, $absensiTrend))
                        }],
                        xaxis: {
                            categories: @json(array_map(function ($item) {
                                    return $item['label'];
                                }, $absensiTrend)),
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontWeight: 500
                                }
                            }
                        },
                        colors: ['#6366F1'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                type: 'vertical',
                                shadeIntensity: 0.3,
                                gradientToColors: ['#A5B4FC'],
                                inverseColors: false,
                                opacityFrom: 0.8,
                                opacityTo: 0.2,
                                stops: [0, 100]
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        markers: {
                            size: 5,
                            strokeWidth: 0,
                            hover: {
                                size: 7
                            }
                        },
                        grid: {
                            borderColor: '#e0e0e0',
                            strokeDashArray: 5,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            padding: {
                                top: 0,
                                right: 0,
                                bottom: 0,
                                left: 10
                            }
                        },
                        tooltip: {
                            theme: 'dark',
                            y: {
                                formatter: function(value) {
                                    return value + ' siswa';
                                }
                            },
                            x: {
                                show: true
                            },
                            marker: {
                                show: true
                            },
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        }
                    };
                    attendanceTrendChart = new ApexCharts(document.querySelector("#attendance-trend-chart"),
                        attendanceTrendOptions);
                    attendanceTrendChart.render();

                    const attendanceByClassOptions = {
                        chart: {
                            type: 'bar',
                            height: '100%',
                            toolbar: {
                                show: false,
                            },
                            offsetY: -15,
                            fontFamily: 'Inter, sans-serif',
                            dropShadow: {
                                enabled: true,
                                top: 3,
                                left: 2,
                                blur: 4,
                                opacity: 0.1
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                animateGradually: {
                                    enabled: true,
                                    delay: 150
                                },
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            },
                            grid: {
                                padding: {
                                    top: 0
                                }
                            }
                        },
                        series: [{
                            name: 'Absensi',
                            data: @json($absensiByKelas->pluck('absensies_count')->toArray()),

                        }],
                        xaxis: {
                            categories: @json($absensiByKelas->pluck('nama')->toArray()),
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontWeight: 500
                                }
                            },
                            stepSize: 1
                        },
                        colors: @json($barColors),

                        plotOptions: {
                            bar: {
                                horizontal: true,
                                distributed: true,
                                columnWidth: '100%',
                                barHeight: '100%',
                                dataLabels: {
                                    position: 'top'
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: false
                        },
                        fill: {
                            type: 'solid',
                        },
                        tooltip: {
                            theme: 'dark',
                            y: {
                                formatter: function(value) {
                                    return value + ' kehadiran';
                                }
                            },
                            marker: {
                                show: true
                            },
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        }
                    };
                    attendanceByClassChart = new ApexCharts(document.querySelector("#attendance-by-class-chart"),
                        attendanceByClassOptions);
                    attendanceByClassChart.render();
                }

                function refreshData() {
                    const refreshButton = document.getElementById('refresh-data');
                    refreshButton.disabled = true;

                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    const kelasId = '';

                    const exportLink = document.querySelector('a[href*="admin.dashboard.export"]');
                    if (exportLink) {
                        exportLink.href =
                            `{{ route('admin.dashboard.export') }}?start_date=${startDate}&end_date=${endDate}&kelas_id=${kelasId}`;
                    } else {
                        console.warn('Export link not found in the document');
                    }

                    fetch(`{{ route('admin.dashboard') }}?start_date=${startDate}&end_date=${endDate}&kelas_id=${kelasId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('total-siswa').textContent = data.totalSiswa;
                            document.getElementById('total-guru').textContent = data.totalGuru;
                            document.getElementById('total-kelas').textContent = data.totalKelas;
                            document.getElementById('total-absensi-hari-ini').textContent = data
                                .totalAbsensiHariIni;


                            attendanceTrendChart.updateSeries([{
                                name: 'Kehadiran',
                                data: data.absensiTrend.map(item => item.count)
                            }]);
                            attendanceTrendChart.updateOptions({
                                xaxis: {
                                    categories: data.absensiTrend.map(item => item.label)
                                }
                            });

                            const trendKelasFilter = document.getElementById('trend_kelas_filter');
                            if (trendKelasFilter && !trendKelasFilter.value) {

                                attendanceTrendChart.updateSeries([{
                                    name: 'Kehadiran',
                                    data: data.absensiTrend.map(item => item.count)
                                }]);
                                attendanceTrendChart.updateOptions({
                                    xaxis: {
                                        categories: data.absensiTrend.map(item => item.label)
                                    }
                                });
                            }


                            attendanceByClassChart.updateSeries([{
                                name: 'Absensi',
                                data: data.absensiByKelas.map(item => item.count)
                            }]);
                            attendanceByClassChart.updateOptions({
                                xaxis: {
                                    categories: data.absensiByKelas.map(item => item.nama)
                                }
                            });


                            const tableBody = document.getElementById('recent-attendance-body');
                            tableBody.innerHTML = '';

                            if (data.recentAbsensi.length > 0) {
                                data.recentAbsensi.forEach(absensi => {
                                    tableBody.innerHTML += `
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300">
                                        ${absensi.tanggal}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300">
                                        ${absensi.siswa}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300">
                                        ${absensi.kelas}
                                    </td>
                                </tr>
                            `;
                                });
                            } else {
                                tableBody.innerHTML = `
                            <tr>
                                <td colspan="3" class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300 text-center">
                                    Tidak ada data absensi terbaru
                                </td>
                            </tr>
                        `;
                            }


                            const statsElements = document.querySelectorAll('.text-3xl.font-bold');
                            statsElements.forEach(el => {
                                el.classList.add('text-indigo-600', 'dark:text-indigo-400', 'scale-110',
                                    'transform');
                                setTimeout(() => {
                                    el.classList.remove('text-indigo-600', 'dark:text-indigo-400',
                                        'scale-110', 'transform');
                                }, 1000);
                            });


                            const tableRows = document.querySelectorAll('#recent-attendance-body tr');
                            tableRows.forEach((row, index) => {
                                row.style.opacity = '0';
                                row.style.transform = 'translateY(10px)';
                                setTimeout(() => {
                                    row.style.transition = 'all 0.3s ease';
                                    row.style.opacity = '1';
                                    row.style.transform = 'translateY(0)';
                                }, 100 * index);
                            });
                        })
                        .catch(error => {
                            console.error('Error refreshing dashboard data:', error);
                        })
                        .finally(() => {
                            refreshButton.disabled = false;
                        });
                }
            });
        </script>
    @endpush
</x-app-layout>
