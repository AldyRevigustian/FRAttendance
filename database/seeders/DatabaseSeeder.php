<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
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

        MataKuliah::create(['nama' => 'Big Data Processing', 'kode' => 'COMP6579001']);
        MataKuliah::create(['nama' => 'Computational Biology', 'kode' => 'SCIE6062001']);
        MataKuliah::create(['nama' => 'Data Analytics', 'kode' => 'COMP6886001']);
        MataKuliah::create(['nama' => 'Database Design', 'kode' => 'COMP6841001']);
        MataKuliah::create(['nama' => 'Distributed Cloud Computing', 'kode' => 'COMP6710001']);
        MataKuliah::create(['nama' => 'Research Methodology in Computer Science', 'kode' => 'COMP6696001']);
        MataKuliah::create(['nama' => 'Software Engineering', 'kode' => 'COMP6100001']);
        MataKuliah::create(['nama' => 'Algorithm Design and Analysis', 'kode' => 'COMP6049001']);
        MataKuliah::create(['nama' => 'Artificial Intelligence', 'kode' => 'COMP6065001']);
        MataKuliah::create(['nama' => 'Character Building: Agama', 'kode' => 'CHAR6015001']);
        MataKuliah::create(['nama' => 'Computational Physics', 'kode' => 'SCIE6063001']);
        MataKuliah::create(['nama' => 'Computer Networks', 'kode' => 'CPEN6247001']);
        MataKuliah::create(['nama' => 'Database Technology', 'kode' => 'COMP6799001']);
        MataKuliah::create(['nama' => 'Object Oriented Programming', 'kode' => 'COMP6820001']);
        MataKuliah::create(['nama' => 'Calculus', 'kode' => 'MATH6031001']);
        MataKuliah::create(['nama' => 'Character Building: Kewarganegaraan', 'kode' => 'CHAR6014001']);
        MataKuliah::create(['nama' => 'Data Structures', 'kode' => 'COMP6048001']);
        MataKuliah::create(['nama' => 'EESE 2', 'kode' => 'EESE2']);
        MataKuliah::create(['nama' => 'Entrepreneurship: Ideation', 'kode' => 'ENTR6509001']);
        MataKuliah::create(['nama' => 'Human and Computer Interaction', 'kode' => 'COMP6800001']);
        MataKuliah::create(['nama' => 'Scientific Computing', 'kode' => 'MATH6183001']);
        MataKuliah::create(['nama' => 'Program Design Method', 'kode' => 'COMP6798001']);
        MataKuliah::create(['nama' => 'Indonesian', 'kode' => 'LANG6027001']);
        MataKuliah::create(['nama' => 'Linear Algebra', 'kode' => 'MATH6030001']);
        MataKuliah::create(['nama' => 'Algorithm and Programming', 'kode' => 'COMP6047001']);
        MataKuliah::create(['nama' => 'Basic Statistics', 'kode' => 'STAT6171001']);
        MataKuliah::create(['nama' => 'Character Building: Pancasila', 'kode' => 'CHAR6013001']);
        MataKuliah::create(['nama' => 'Discrete Mathematics', 'kode' => 'MATH6025001']);

        Mahasiswa::create([
            'id' => 2702303633,
            'nama' => 'Shem Josh Lowell',
            'kelas_id' => 1,
            'is_trained' => 0
        ]);
    }
}
