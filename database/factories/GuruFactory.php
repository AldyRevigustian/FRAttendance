<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */

class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); // Nama khas Indonesia
        $name = $faker->name;

        // Ambil maksimal 2 kata pertama dari nama
        $nameParts = explode(' ', $name);
        $shortName = implode('.', array_slice($nameParts, 0, 2));
        $emailName = Str::slug($shortName, '.'); // jadi lowercase dan titik

        return [
            'kode' => $faker->unique()->bothify('GR###'),
            'nama' => $name,
            'email' => $emailName . '@edui.id',
            'password' => Hash::make('password'),
        ];
    }
}
