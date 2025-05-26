<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make("admin"),
        ]);

        Guru::create([
            'kode' => 'GR001',
            'nama' => 'Guru Test',
            'email' => 'guru@edu.id',
            'jenis_kelamin' => 0,
            'password' => Hash::make("guru"),
        ]);

        Guru::factory()->count(14)->create();

        $tingkatan = [10, 11, 12];
        $huruf = range('A', 'F');

        $ct = 0;
        foreach ($tingkatan as $tingkat) {
            foreach ($huruf as $h) {
                $guruId = $ct < 15 ? $ct + 1 : null;
                Kelas::create([
                    'nama' => "$tingkat $h",
                    'guru_id' => $guruId,
                ]);
                $ct++;
            }
        }

        Siswa::create([
            'id' => 2702303719,
            'nama' => 'Shem Josh Lowell',
            'jenis_kelamin' => 0,
            'kelas_id' => 1,
            'is_trained' => 0
        ]);

        Absensi::create([
            'siswa_id' => 2702303719,
            'kelas_id' => 1,
            'tanggal' => now()->subDays(2)->toDateString(),   // format yyyy-mm-dd
            'waktu_masuk' => now()->subDays(2)->setTime(7, 30),
            'waktu_keluar' => now()->subDays(2)->setTime(14, 30),
        ]);
        Absensi::create([
            'siswa_id' => 2702303719,
            'kelas_id' => 1,
            'tanggal' => now()->subDays(1)->toDateString(),
            'waktu_masuk' => now()->subDays(1)->setTime(7, 30),
            'waktu_keluar' => now()->subDays(1)->setTime(14, 30),
        ]);
        Absensi::create([
            'siswa_id' => 2702303719,
            'kelas_id' => 1,
            'tanggal' => now()->toDateString(),
            'waktu_masuk' => now()->setTime(7, 30),
            'waktu_keluar' => now()->setTime(14, 30),
        ]);
    }
}
