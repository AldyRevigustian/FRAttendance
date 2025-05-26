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
        $faker = \Faker\Factory::create('id_ID');

        $gender = $faker->randomElement(['male', 'female']);

        if ($gender === 'male') {
            $name = $faker->name('male');
            $jenisKelamin = 0; // laki-laki
        } else {
            $name = $faker->name('female');
            $jenisKelamin = 1; // perempuan
        }

        $nameParts = explode(' ', $name);
        $shortName = implode('.', array_slice($nameParts, 0, 2));
        $emailName = Str::slug($shortName, '.');

        return [
            'kode' => $faker->unique()->bothify('GR###'),
            'nama' => $name,
            'email' => $emailName . '@edu.id',
            'password' => Hash::make('password'),
            'jenis_kelamin' => $jenisKelamin,
        ];
    }
}
