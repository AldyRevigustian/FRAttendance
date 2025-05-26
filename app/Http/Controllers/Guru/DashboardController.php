<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request, $kelas_terpilih)
    {
        $kelas = Kelas::findOrFail($kelas_terpilih);

        // Verify that the logged-in teacher is the homeroom teacher for this class
        $guru = Auth::guard('guru')->user();
        if ($kelas->guru_id !== $guru->id) {
            abort(403, 'Unauthorized access to this class dashboard.');
        }

        // Date filters
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(7);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        // Statistics for the selected class
        $totalSiswa = Siswa::where('kelas_id', $kelas_terpilih)->count();
        $totalAbsensiPeriode = Absensi::where('kelas_id', $kelas_terpilih)
            ->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->count();

        // Total absensi untuk bulan ini (dari tanggal 1 sampai hari ini)
        $totalAbsensiBulanIni = Absensi::where('kelas_id', $kelas_terpilih)
            ->whereBetween('tanggal', [
                Carbon::now()->startOfMonth()->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->count();

        $totalAbsensiHariIni = Absensi::where('kelas_id', $kelas_terpilih)
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Siswa with most attendance in the period
        $siswaAbsensiTerbanyak = Siswa::where('kelas_id', $kelas_terpilih)
            ->withCount(['absensies' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()]);
            }])
            ->orderByDesc('absensies_count')
            ->first();

        // Recent attendance for the class
        $recentAbsensi = Absensi::with('siswa')
            ->where('kelas_id', $kelas_terpilih)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Attendance trend for the last 14 days (or date range)
        $absensiTrend = [];
        $dateRange = min($endDate->diffInDays($startDate) + 1, 30);

        for ($i = $dateRange - 1; $i >= 0; $i--) {
            $date = clone $endDate;
            $date = $date->subDays($i);

            $count = Absensi::where('kelas_id', $kelas_terpilih)
                ->whereDate('tanggal', $date)
                ->count();

            $absensiTrend[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M'),
                'count' => $count
            ];
        }

        // Student attendance distribution (students ranked by their attendance frequency)
        $siswaAbsensiData = Siswa::where('kelas_id', $kelas_terpilih)
            ->withCount(['absensies' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()]);
            }])
            ->orderByDesc('absensies_count')
            ->take(10)
            ->get();

        // Weekly attendance distribution for current month
        $weeklyAttendance = [];
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        for ($week = 0; $week < 4; $week++) {
            $weekStart = $startOfMonth->copy()->addWeeks($week);
            $weekEnd = $weekStart->copy()->addDays(6);

            if ($weekEnd->gt($endOfMonth)) {
                $weekEnd = $endOfMonth;
            }

            $count = Absensi::where('kelas_id', $kelas_terpilih)
                ->whereBetween('tanggal', [$weekStart, $weekEnd])
                ->count();

            $weeklyAttendance[] = [
                'label' => 'Minggu ' . ($week + 1),
                'week' => 'Week ' . ($week + 1),
                'count' => $count
            ];
        }

        // Average daily attendance calculation
        $avgDailyAttendance = $dateRange > 0 ? round($totalAbsensiPeriode / $dateRange, 1) : 0;

        if ($request->ajax()) {
            return response()->json([
                'totalSiswa' => $totalSiswa,
                'totalAbsensiPeriode' => $totalAbsensiPeriode,
                'totalAbsensiBulanIni' => $totalAbsensiBulanIni,
                'totalAbsensiHariIni' => $totalAbsensiHariIni,
                'avgDailyAttendance' => $avgDailyAttendance,
                'absensiTrend' => $absensiTrend,
                'siswaAbsensiData' => $siswaAbsensiData->map(function ($siswa) {
                    return [
                        'nama' => $siswa->nama,
                        'count' => $siswa->absensies_count
                    ];
                }),
                'weeklyAttendance' => $weeklyAttendance,
                'recentAbsensi' => $recentAbsensi->map(function ($absensi) {
                    return [
                        'tanggal' => Carbon::parse($absensi->updated_at)->format('d M Y H:i'),
                        'siswa' => $absensi->siswa->nama,
                        'waktu_masuk' => $absensi->waktu_masuk,
                        'waktu_keluar' => $absensi->waktu_keluar
                    ];
                }),
            ]);
        }

        return view('guru.dashboard', compact(
            'kelas',
            'totalSiswa',
            'totalAbsensiPeriode',
            'totalAbsensiBulanIni',
            'totalAbsensiHariIni',
            'avgDailyAttendance',
            'siswaAbsensiTerbanyak',
            'recentAbsensi',
            'absensiTrend',
            'siswaAbsensiData',
            'weeklyAttendance',
            'startDate',
            'endDate'
        ), [
            'selectedKelas' => $kelas,
            'totalAbsensi' => $totalAbsensiBulanIni,
            'rataRataKehadiran' => $avgDailyAttendance,
            'absensiHariIni' => $totalAbsensiHariIni,
            'topStudents' => $siswaAbsensiData,
            'attendanceTrend' => $absensiTrend,
            'weeklyDistribution' => $weeklyAttendance
        ]);
    }

    public function exportAbsensi(Request $request, $kelas_terpilih)
    {
        $kelas = Kelas::findOrFail($kelas_terpilih);

        // Verify that the logged-in teacher is the homeroom teacher for this class
        $guru = Auth::guard('guru')->user();
        if ($kelas->guru_id !== $guru->id) {
            abort(403, 'Unauthorized access to this class data.');
        }

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        $absensi = Absensi::with('siswa')
            ->where('kelas_id', $kelas_terpilih)
            ->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $filename = "absensi_{$kelas->nama}_{$startDate->format('Y-m-d')}_{$endDate->format('Y-m-d')}.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Tanggal', 'Siswa', 'Waktu Masuk', 'Waktu Keluar'];

        $callback = function () use ($absensi, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($absensi as $record) {
                fputcsv($file, [
                    Carbon::parse($record->tanggal)->format('Y-m-d'),
                    $record->siswa->nama,
                    $record->waktu_masuk ?? 'N/A',
                    $record->waktu_keluar ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function export(Request $request, $kelas_terpilih)
    {
        return $this->exportAbsensi($request, $kelas_terpilih);
    }

    public function refresh(Request $request, $kelas_terpilih)
    {
        // Get selected class
        $kelas = Kelas::findOrFail($kelas_terpilih);

        // Verify that the logged-in teacher is the homeroom teacher for this class
        $guru = Auth::guard('guru')->user();
        if ($kelas->guru_id !== $guru->id) {
            abort(403, 'Unauthorized access to this class dashboard.');
        }

        // Date filters
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(7);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        // Statistics for the selected class
        $totalSiswa = Siswa::where('kelas_id', $kelas_terpilih)->count();
        $totalAbsensiPeriode = Absensi::where('kelas_id', $kelas_terpilih)
            ->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->count();

        // Total absensi untuk bulan ini (dari tanggal 1 sampai hari ini)
        $totalAbsensiBulanIni = Absensi::where('kelas_id', $kelas_terpilih)
            ->whereBetween('tanggal', [
                Carbon::now()->startOfMonth()->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->count();

        $totalAbsensiHariIni = Absensi::where('kelas_id', $kelas_terpilih)
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Siswa with most attendance in the period
        $siswaAbsensiData = Siswa::where('kelas_id', $kelas_terpilih)
            ->withCount(['absensies' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate->startOfDay(), $endDate->endOfDay()]);
            }])
            ->orderByDesc('absensies_count')
            ->take(10)
            ->get();

        // Recent attendance for the class
        $recentAbsensi = Absensi::with('siswa')
            ->where('kelas_id', $kelas_terpilih)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Attendance trend for the date range
        $absensiTrend = [];
        $dateRange = min($endDate->diffInDays($startDate) + 1, 30);

        for ($i = $dateRange - 1; $i >= 0; $i--) {
            $date = clone $endDate;
            $date = $date->subDays($i);

            $count = Absensi::where('kelas_id', $kelas_terpilih)
                ->whereDate('tanggal', $date)
                ->count();

            $absensiTrend[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M'),
                'count' => $count
            ];
        }

        // Weekly attendance distribution for current month
        $weeklyAttendance = [];
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        for ($week = 0; $week < 4; $week++) {
            $weekStart = $startOfMonth->copy()->addWeeks($week);
            $weekEnd = $weekStart->copy()->addDays(6);

            if ($weekEnd->gt($endOfMonth)) {
                $weekEnd = $endOfMonth;
            }

            $count = Absensi::where('kelas_id', $kelas_terpilih)
                ->whereBetween('tanggal', [$weekStart, $weekEnd])
                ->count();

            $weeklyAttendance[] = [
                'label' => 'Minggu ' . ($week + 1),
                'week' => 'Week ' . ($week + 1),
                'count' => $count
            ];
        }

        // Average daily attendance calculation
        $avgDailyAttendance = $dateRange > 0 ? round($totalAbsensiPeriode / $dateRange, 1) : 0;

        return response()->json([
            'totalSiswa' => $totalSiswa,
            'totalAbsensi' => $totalAbsensiPeriode,
            'totalAbsensiBulanIni' => $totalAbsensiBulanIni,
            'rataRataKehadiran' => $avgDailyAttendance,
            'absensiHariIni' => $totalAbsensiHariIni,
            'topStudents' => $siswaAbsensiData->map(function ($siswa) {
                return [
                    'nama' => $siswa->nama,
                    'absensi_count' => $siswa->absensies_count
                ];
            }),
            'recentAbsensi' => $recentAbsensi->map(function ($absensi) {
                return [
                    'tanggal' => Carbon::parse($absensi->updated_at)->format('d M Y, H:i'),
                    'siswa' => $absensi->siswa->nama,
                ];
            }),
            'attendanceTrend' => $absensiTrend,
            'weeklyDistribution' => $weeklyAttendance,
        ]);
    }
}
