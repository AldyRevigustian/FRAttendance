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

        Guru::create([
            'kode' => 'GR001',
            'nama' => 'Guru1',
            'email' => 'guru1@guru.com',
            'password' => Hash::make("guru"),
        ]);

        Guru::create([
            'kode' => 'GR002',
            'nama' => 'Guru2',
            'email' => 'guru2@guru.com',
            'password' => Hash::make("guru"),
        ]);

        Kelas::create(['nama' => '11-A', 'guru_id' => 1]);
        Kelas::create(['nama' => '11-B', 'guru_id' => 2]);

        Siswa::create([
            'id' => 2702303633,
            'nama' => 'Shem Josh Lowell',
            'kelas_id' => 1,
            'is_trained' => 0
        ]);
    }
}
