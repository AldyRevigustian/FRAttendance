<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        $tanggal = $this->faker->dateTimeBetween('-30 days', 'now');
        $waktuMasuk = $this->faker->time('H:i', '08:00');
        $waktuKeluar = $this->faker->optional(0.8)->time('H:i', '15:00');

        return [
            'siswa_id' => Siswa::factory(),
            'kelas_id' => Kelas::factory(),
            'tanggal' => $tanggal->format('Y-m-d'),
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => $waktuKeluar
        ];
    }
}
