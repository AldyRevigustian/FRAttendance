<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'nama' => 'Kelas ' . $this->faker->randomElement(['10', '11', '12']) . $this->faker->randomElement(['A', 'B', 'C']),
            'guru_id' => Guru::factory()
        ];
    }
}
