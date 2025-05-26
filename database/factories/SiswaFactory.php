<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'kelas_id' => Kelas::factory(),
            'is_trained' => false,
            'jenis_kelamin' => $this->faker->randomElement([0, 1]) // 0 = L, 1 = P
        ];
    }
}
