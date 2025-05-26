@extends('layouts.guru')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard Guru') }} - {{ $selectedKelas->nama ?? 'Pilih Kelas' }}
    </h2>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/guru-dashboard.css') }}">
    <script src="{{ asset('js/guru-dashboard.js') }}" defer></script>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($selectedKelas)
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg mb-6 border-t-4 border-blue-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 flex items-center">
                                    <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Kelas: {{ $selectedKelas->nama }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Guru: {{ auth()->guard('guru')->user()->nama }} |
                                    Total Siswa: {{ $selectedKelas->siswas->count() }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('guru.dashboard.export', ['kelas_terpilih' => $selectedKelas->id]) }}?start_date={{ request('start_date', now()->subDays(30)->format('Y-m-d')) }}&end_date={{ request('end_date', now()->format('Y-m-d')) }}"
                                    class="flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-700 transition duration-150 ease-in-out">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Export Data
                                </a>
                                <button type="button" id="refresh-data"
                                    class="flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 transition duration-150 ease-in-out">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg mb-6 border-t-4 border-indigo-600">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                            <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter Periode Data
                        </h3>
                        <form id="dashboard-filter"
                            action="{{ route('guru.dashboard', ['kelas_terpilih' => $selectedKelas->id]) }}" method="GET"
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
                                        value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
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
                                        value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                                        class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                                </div>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700 transition duration-150 ease-in-out">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg sm:rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6 border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-500 bg-opacity-85 shadow-md">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <div id="total-siswa"
                                        class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                        {{ $totalSiswa }}
                                    </div>
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
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <div id="total-absensi"
                                        class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                        {{ $totalAbsensiBulanIni }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Absensi Bulan
                                        Ini</div>
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
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <div id="rata-rata-kehadiran"
                                        class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                        {{ number_format($rataRataKehadiran, 1) }}%
                                    </div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Rata-rata Kehadiran
                                    </div>
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
                                    <div id="absensi-hari-ini"
                                        class="text-3xl font-bold text-gray-700 dark:text-gray-200 transition-all duration-300">
                                        {{ $absensiHariIni }}
                                    </div>
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
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                                Trend Absensi Harian
                            </h3>
                            <div class="h-80 transition-opacity duration-300">
                                <canvas id="attendance-trend-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-all duration-300 sm:rounded-lg overflow-hidden">
                        <div class="p-6 border-t-4 border-purple-500">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Distribusi Mingguan
                            </h3>
                            <div class="h-[400px]">
                                <canvas id="weekly-distribution-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 sm:rounded-lg border-t-4 border-green-500">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7 12a5 5 0 1010 0 5 5 0 00-10 0z" />
                                </svg>
                                Siswa Terajin
                            </h3>
                            <div class="space-y-3" id="top-students-list">
                                @foreach ($topStudents as $index => $student)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $student->nama }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $student->absensies_count }} kali hadir</p>
                                            </div>
                                        </div>
                                        <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                                            {{ number_format(($student->absensies_count / max($totalAbsensiBulanIni, 1)) * 100, 1) }}%
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 sm:rounded-lg border-t-4 border-blue-500">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Absensi Terbaru
                            </h3>
                            <div class="overflow-y-auto max-h-80" id="recent-attendance-list">
                                @foreach ($recentAbsensi as $absensi)
                                    <div
                                        class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $absensi->siswa->nama }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($absensi->updated_at)->format('d M Y, H:i') }}</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            Hadir
                                        </span>
                                    </div>
                                @endforeach
                                @if (count($recentAbsensi) == 0)
                                    <div class="text-center py-8">
                                        <svg class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada data absensi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border-t-4 border-yellow-500">
                    <div class="p-6 text-center">
                        <svg class="h-16 w-16 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">Tidak Ada Kelas Terpilih</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Silakan pilih kelas untuk melihat dashboard.</p>
                        <a href="{{ route('guru.kelas.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 transition duration-150 ease-in-out">
                            Pilih Kelas
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($selectedKelas)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                let attendanceTrendChart;
                let weeklyDistributionChart;

                document.addEventListener('DOMContentLoaded', function() {
                    try {
                        attendanceTrendChart = initializeAttendanceTrendChart();
                        weeklyDistributionChart = initializeWeeklyDistributionChart();
                        document.getElementById('refresh-data').addEventListener('click', refreshDashboard);
                    } catch (error) {
                        console.error('Error initializing dashboard:', error);
                    }
                });

                function initializeAttendanceTrendChart() {
                    try {
                        const ctx = document.getElementById('attendance-trend-chart');
                        if (!ctx) {
                            console.error('Attendance trend chart canvas not found');
                            return null;
                        }

                        const trendData = @json($attendanceTrend);
                        console.log('Attendance trend data:', trendData);

                        return new Chart(ctx.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: trendData.map(item => item.label || item.date),
                                datasets: [{
                                    label: 'Jumlah Kehadiran',
                                    data: trendData.map(item => item.count),
                                    borderColor: 'rgb(59, 130, 246)',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    tension: 0.1,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error initializing attendance trend chart:', error);
                        return null;
                    }
                }

                function initializeWeeklyDistributionChart() {
                    try {
                        const ctx = document.getElementById('weekly-distribution-chart');
                        if (!ctx) {
                            console.error('Weekly distribution chart canvas not found');
                            return null;
                        }

                        const weeklyData = @json($weeklyDistribution);
                        console.log('Weekly distribution data:', weeklyData);

                        return new Chart(ctx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: weeklyData.map(item => item.label || item.week),
                                datasets: [{
                                    label: 'Jumlah Kehadiran',
                                    data: weeklyData.map(item => item.count),
                                    backgroundColor: [
                                        'rgba(59, 130, 246, 0.8)',
                                        'rgba(34, 197, 94, 0.8)',
                                        'rgba(245, 158, 11, 0.8)',
                                        'rgba(147, 51, 234, 0.8)'
                                    ],
                                    borderColor: [
                                        'rgb(59, 130, 246)',
                                        'rgb(34, 197, 94)',
                                        'rgb(245, 158, 11)',
                                        'rgb(147, 51, 234)'
                                    ],
                                    borderWidth: 2,
                                    borderRadius: 6,
                                    borderSkipped: false,
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.parsed.x + ' kehadiran';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        }
                                    },
                                    y: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                animation: {
                                    duration: 1000,
                                    easing: 'easeInOutQuart'
                                }
                            }
                        });
                    } catch (error) {
                        console.error('Error initializing weekly distribution chart:', error);
                        return null;
                    }
                }

                function refreshDashboard() {
                    const refreshButton = document.getElementById('refresh-data');
                    refreshButton.disabled = true;

                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const kelasId = {{ $selectedKelas->id }};

                    fetch(`{{ route('guru.dashboard.refresh', ['kelas_terpilih' => $selectedKelas->id]) }}?start_date=${startDate}&end_date=${endDate}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {

                            document.getElementById('total-siswa').textContent = data.totalSiswa;
                            document.getElementById('total-absensi').textContent = data.totalAbsensiBulanIni;
                            document.getElementById('rata-rata-kehadiran').textContent = data.rataRataKehadiran + '%';
                            document.getElementById('absensi-hari-ini').textContent = data.absensiHariIni;


                            if (attendanceTrendChart && data.attendanceTrend) {
                                attendanceTrendChart.data.labels = data.attendanceTrend.map(item => item.label || item.date);
                                attendanceTrendChart.data.datasets[0].data = data.attendanceTrend.map(item => item.count);
                                attendanceTrendChart.update();
                            }


                            if (weeklyDistributionChart && data.weeklyDistribution) {
                                weeklyDistributionChart.data.labels = data.weeklyDistribution.map(item => item.label || item
                                    .week);
                                weeklyDistributionChart.data.datasets[0].data = data.weeklyDistribution.map(item => item.count);
                                weeklyDistributionChart.update();
                            }


                            const topStudentsList = document.getElementById('top-students-list');
                            topStudentsList.innerHTML = '';
                            data.topStudents.forEach((student, index) => {
                                const percentage = data.totalAbsensiBulanIni > 0 ? ((student.absensi_count / data
                                    .totalAbsensiBulanIni) * 100).toFixed(1) : 0;
                                topStudentsList.innerHTML += `
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        ${index + 1}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${student.nama}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">${student.absensi_count} kali hadir</p>
                                    </div>
                                </div>
                                <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                                    ${percentage}%
                                </div>
                            </div>
                        `;
                            });


                            const recentAttendanceList = document.getElementById('recent-attendance-list');
                            recentAttendanceList.innerHTML = '';
                            if (data.recentAbsensi.length > 0) {
                                data.recentAbsensi.forEach(absensi => {
                                    recentAttendanceList.innerHTML += `
                                <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${absensi.siswa}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">${absensi.tanggal}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        Hadir
                                    </span>
                                </div>
                            `;
                                });
                            } else {
                                recentAttendanceList.innerHTML = `
                            <div class="text-center py-8">
                                <svg class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada data absensi</p>
                            </div>
                        `;
                            }


                            const statsElements = document.querySelectorAll('.text-3xl.font-bold');
                            statsElements.forEach(el => {
                                el.classList.add('text-blue-600', 'dark:text-blue-400', 'scale-110', 'transform');
                                setTimeout(() => {
                                    el.classList.remove('text-blue-600', 'dark:text-blue-400', 'scale-110',
                                        'transform');
                                }, 1000);
                            });
                        })
                        .catch(error => {
                            console.error('Error refreshing dashboard data:', error);
                        })
                        .finally(() => {
                            refreshButton.disabled = false;
                        });
                }
            </script>
        @endpush
    @endif
@endsection
