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
        // Admin Seeder
        Admin::create([
            'nama' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make("admin"),
        ]);

        // Guru Seeder
        Guru::create([
            'kode' => 'GR001',
            'nama' => 'Guru Test',
            'email' => 'guru.test@guru.com',
            'password' => Hash::make("guru"),
        ]);

        Guru::factory()->count(14)->create();

        //  Kelas Seeder
        $tingkatan = [10, 11, 12];
        $huruf = range('A', 'I');

        $kelasKe = 0;

        // Buat kelas untuk tiap guru 1-20 dulu
        foreach (range(1, 15) as $guruId) {
            $t = intdiv($kelasKe, count($huruf));
            $h = $kelasKe % count($huruf);
            if (!isset($tingkatan[$t])) break;
            Kelas::create([
                'nama' => "{$tingkatan[$t]} {$huruf[$h]}",
                'guru_id' => $guruId,
            ]);
            $kelasKe++;
        }

        // Buat sisa kelas dengan guru random
        $totalKelas = count($tingkatan) * count($huruf);
        for (; $kelasKe < $totalKelas; $kelasKe++) {
            $t = intdiv($kelasKe, count($huruf));
            $h = $kelasKe % count($huruf);
            if (!isset($tingkatan[$t])) break;
            Kelas::create([
                'nama' => "{$tingkatan[$t]} {$huruf[$h]}",
                'guru_id' => rand(1, 15),
            ]);
        }

        // Siswa Seeder
        Siswa::create([
            'id' => 2702303633,
            'nama' => 'Shem Josh Lowell',
            'jenis_kelamin' => 0, // 0 = Laki-laki, 1 = Perempuan
            'kelas_id' => 1,
            'is_trained' => 0
        ]);
    }
}
