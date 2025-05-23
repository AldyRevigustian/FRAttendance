<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'aldybudiasih@gmail.com',
        //     'password' => "Akunbaru123*"
        // ]);

        Admin::create([
            'nama' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make("admin"),
        ]);

        Dosen::create([
            'kode' => 'DS001',
            'nama' => 'Dosen',
            'email' => 'dosen@dosen.com',
            'password' => Hash::make("dosen"),
        ]);

        Kelas::create(['nama' => 'LA01']);
        Kelas::create(['nama' => 'LB01']);
        Kelas::create(['nama' => 'LC01']);
        Kelas::create(['nama' => 'LD01']);
        Kelas::create(['nama' => 'LE01']);
        Kelas::create(['nama' => 'LF01']);
        Kelas::create(['nama' => 'LG01']);
        Kelas::create(['nama' => 'LH01']);
        Kelas::create(['nama' => 'LI01']);
        Kelas::create(['nama' => 'LJ01']);
        Kelas::create(['nama' => 'LK01']);

        Siswa::create([
            'id' => 2702303633,
            'nama' => 'Shem Josh Lowell',
            'kelas_id' => 1,
            'is_trained' => 0
        ]);
    }
}
