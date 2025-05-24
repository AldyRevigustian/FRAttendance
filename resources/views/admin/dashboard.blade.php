<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Controls -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form id="dashboard-filter" action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" value="{{ isset($startDate) ? $startDate->format('Y-m-d') : Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}" 
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" value="{{ isset($endDate) ? $endDate->format('Y-m-d') : Carbon\Carbon::now()->format('Y-m-d') }}" 
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="kelas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                            <select id="kelas_id" name="kelas_id" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Semua Kelas</option>
                                @foreach($allKelas as $kelas)
                                    <option value="{{ $kelas->id }}" {{ isset($selectedKelasId) && $selectedKelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700 transition mr-2">
                                Filter
                            </button>
                            <button type="button" id="refresh-data" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-700 transition mr-2">
                                <svg class="h-4 w-4 text-white inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh
                            </button>
                            <a href="{{ route('admin.dashboard.export') }}?start_date={{ isset($startDate) ? $startDate->format('Y-m-d') : '' }}&end_date={{ isset($endDate) ? $endDate->format('Y-m-d') : '' }}&kelas_id={{ $selectedKelasId ?? '' }}" class="px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-200 active:bg-yellow-700 transition">
                                <svg class="h-4 w-4 text-white inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Students Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-500 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-siswa" class="text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalSiswa }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Teachers Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-guru" class="text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalGuru }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Guru</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Classes Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-kelas" class="text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalKelas }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Kelas</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Attendance Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <div id="total-absensi-hari-ini" class="text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalAbsensiHariIni }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Absensi Hari Ini</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Attendance Trend Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Trend Absensi</h3>
                        <div id="attendance-trend-chart" class="h-64"></div>
                    </div>
                </div>

                <!-- Face Recognition Training Status -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Status Pelatihan Pengenalan Wajah</h3>
                        <div id="training-status-chart" class="h-64"></div>
                        <div class="mt-2 text-center">
                            <div class="inline-block">
                                <div class="flex items-center">
                                    <div id="training-progress-bar" class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                                        <div id="training-progress" class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($trainedSiswa / ($trainedSiswa + $untrainedSiswa) * 100) }}%"></div>
                                    </div>
                                    <span id="training-percentage" class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ round(($trainedSiswa / ($trainedSiswa + $untrainedSiswa) * 100), 1) }}%</span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Progress Pelatihan Keseluruhan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Row of Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Attendance by Class -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Absensi per Kelas</h3>
                        <div id="attendance-by-class-chart" class="h-64"></div>
                    </div>
                </div>

                <!-- Gender Distribution -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Distribusi Jenis Kelamin</h3>
                        <div id="gender-distribution-chart" class="h-64"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Absensi Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table id="recent-attendance-table" class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Siswa</th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600" id="recent-attendance-body">
                                @foreach($recentAbsensi as $absensi)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ $absensi->siswa->nama }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ $absensi->kelas->nama }}
                                    </td>
                                </tr>
                                @endforeach
                                @if(count($recentAbsensi) == 0)
                                <tr>
                                    <td colspan="3" class="py-3 px-4 text-sm text-gray-500 dark:text-gray-300 text-center">
                                        Tidak ada data absensi terbaru
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.absensi') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua</a>
                    </div>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <a href="{{ route('admin.siswa') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <div class="text-center">
                        <div class="p-3 rounded-full bg-indigo-500 bg-opacity-75 mx-auto mb-3 inline-block">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="text-gray-700 dark:text-gray-200 font-medium">Kelola Siswa</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.kelas') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <div class="text-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-75 mx-auto mb-3 inline-block">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="text-gray-700 dark:text-gray-200 font-medium">Kelola Kelas</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.absensi') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <div class="text-center">
                        <div class="p-3 rounded-full bg-red-500 bg-opacity-75 mx-auto mb-3 inline-block">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-gray-700 dark:text-gray-200 font-medium">Kelola Absensi</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Charts initialization
            let attendanceTrendChart, trainingStatusChart, attendanceByClassChart, genderDistributionChart;
            
            // Initialize all charts
            initializeCharts();
            
            // Refresh data periodically
            const refreshInterval = 30000; // 30 seconds
            let refreshTimer = setInterval(refreshData, refreshInterval);
            
            // Manual refresh button
            document.getElementById('refresh-data').addEventListener('click', function() {
                this.classList.add('animate-pulse');
                refreshData();
                setTimeout(() => {
                    this.classList.remove('animate-pulse');
                }, 1000);
            });
            
            // Animate training progress
            animateTrainingProgress();
            
            // Attach filter form submit event for AJAX filtering
            document.getElementById('dashboard-filter').addEventListener('submit', function(e) {
                e.preventDefault();
                refreshData();
                
                // Update URL with filter parameters for better UX
                const formData = new FormData(this);
                const queryString = new URLSearchParams(formData).toString();
                history.pushState(null, null, `${window.location.pathname}?${queryString}`);
            });
            
            /**
             * Initialize all charts
             */
            function initializeCharts() {
                // Attendance Trend Chart
                const attendanceTrendOptions = {
                    chart: {
                        type: 'line',
                        height: '100%',
                        toolbar: {
                            show: false
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
                        data: @json(array_map(function($item) { return $item['count']; }, $absensiTrend))
                    }],
                    xaxis: {
                        categories: @json(array_map(function($item) { return $item['label']; }, $absensiTrend))
                    },
                    colors: ['#4F46E5'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    markers: {
                        size: 5
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
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(value) {
                                return value + ' siswa';
                            }
                        }
                    }
                };
                attendanceTrendChart = new ApexCharts(document.querySelector("#attendance-trend-chart"), attendanceTrendOptions);
                attendanceTrendChart.render();

                // Training Status Chart
                const trainingStatusOptions = {
                    chart: {
                        type: 'donut',
                        height: '100%',
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
                    series: [{{ $trainedSiswa }}, {{ $untrainedSiswa }}],
                    labels: ['Terlatih', 'Belum Terlatih'],
                    colors: ['#10B981', '#EF4444'],
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '50%'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return opts.w.config.series[opts.seriesIndex];
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(value) {
                                return value + ' siswa';
                            }
                        }
                    }
                };
                trainingStatusChart = new ApexCharts(document.querySelector("#training-status-chart"), trainingStatusOptions);
                trainingStatusChart.render();

                // Attendance by Class Chart
                const attendanceByClassOptions = {
                    chart: {
                        type: 'bar',
                        height: '100%',
                        toolbar: {
                            show: false
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
                        name: 'Absensi',
                        data: @json($absensiByKelas->pluck('absensies_count')->toArray())
                    }],
                    xaxis: {
                        categories: @json($absensiByKelas->pluck('nama')->toArray())
                    },
                    colors: ['#F59E0B'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(value) {
                                return value + ' kehadiran';
                            }
                        }
                    }
                };
                attendanceByClassChart = new ApexCharts(document.querySelector("#attendance-by-class-chart"), attendanceByClassOptions);
                attendanceByClassChart.render();

                // Gender Distribution Chart
                const genderDistributionOptions = {
                    chart: {
                        type: 'pie',
                        height: '100%',
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
                    series: [{{ $genderDistribution['laki-laki'] }}, {{ $genderDistribution['perempuan'] }}],
                    labels: ['Laki-laki', 'Perempuan'],
                    colors: ['#3B82F6', '#EC4899'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return opts.w.config.series[opts.seriesIndex];
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(value) {
                                return value + ' siswa';
                            }
                        }
                    }
                };
                genderDistributionChart = new ApexCharts(document.querySelector("#gender-distribution-chart"), genderDistributionOptions);
                genderDistributionChart.render();
            }
            
            /**
             * Refresh dashboard data via AJAX
             */
            function refreshData() {
                // Show loading spinner on refresh button
                const refreshButton = document.getElementById('refresh-data');
                refreshButton.disabled = true;
                
                // Get filter values
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const kelasId = document.getElementById('kelas_id').value;
                
                // Update export link
                const exportLink = document.querySelector('a[href*="admin.dashboard.export"]');
                exportLink.href = `{{ route('admin.dashboard.export') }}?start_date=${startDate}&end_date=${endDate}&kelas_id=${kelasId}`;
                
                // Fetch updated data
                fetch(`{{ route('admin.dashboard') }}?start_date=${startDate}&end_date=${endDate}&kelas_id=${kelasId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update stats
                    document.getElementById('total-siswa').textContent = data.totalSiswa;
                    document.getElementById('total-guru').textContent = data.totalGuru;
                    document.getElementById('total-kelas').textContent = data.totalKelas;
                    document.getElementById('total-absensi-hari-ini').textContent = data.totalAbsensiHariIni;
                    
                    // Update training progress
                    const totalStudents = data.trainedSiswa + data.untrainedSiswa;
                    const percentage = totalStudents > 0 ? (data.trainedSiswa / totalStudents * 100).toFixed(1) : 0;
                    document.getElementById('training-progress').style.width = `${percentage}%`;
                    document.getElementById('training-percentage').textContent = `${percentage}%`;
                    
                    // Update charts
                    attendanceTrendChart.updateSeries([{
                        name: 'Kehadiran',
                        data: data.absensiTrend.map(item => item.count)
                    }]);
                    attendanceTrendChart.updateOptions({
                        xaxis: {
                            categories: data.absensiTrend.map(item => item.label)
                        }
                    });
                    
                    trainingStatusChart.updateSeries([data.trainedSiswa, data.untrainedSiswa]);
                    
                    attendanceByClassChart.updateSeries([{
                        name: 'Absensi',
                        data: data.absensiByKelas.map(item => item.count)
                    }]);
                    attendanceByClassChart.updateOptions({
                        xaxis: {
                            categories: data.absensiByKelas.map(item => item.nama)
                        }
                    });
                    
                    // Update recent attendance table
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
                    
                    // Animate elements to show data is refreshed
                    const statsElements = document.querySelectorAll('.text-3xl.font-semibold');
                    statsElements.forEach(el => {
                        el.classList.add('text-indigo-600', 'dark:text-indigo-400');
                        setTimeout(() => {
                            el.classList.remove('text-indigo-600', 'dark:text-indigo-400');
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
            
            /**
             * Animate training progress bar
             */
            function animateTrainingProgress() {
                const progressBar = document.getElementById('training-progress');
                const currentWidth = parseFloat(progressBar.style.width);
                
                // Add pulse animation
                setInterval(() => {
                    progressBar.classList.add('animate-pulse');
                    setTimeout(() => {
                        progressBar.classList.remove('animate-pulse');
                    }, 1000);
                }, 5000);
            }
        });
    </script>
    @endpush
</x-app-layout>
