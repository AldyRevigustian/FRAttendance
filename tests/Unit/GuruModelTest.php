<?php

namespace Tests\Unit;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuruModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_guru_with_valid_data()
    {
        $guruData = [
            'kode' => 'GR001',
            'nama' => 'Pak Budi Santoso',
            'email' => 'budi@school.com',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 0 // 0 = Laki-laki
        ];

        $guru = Guru::create($guruData);

        $this->assertInstanceOf(Guru::class, $guru);
        $this->assertEquals('GR001', $guru->kode);
        $this->assertEquals('Pak Budi Santoso', $guru->nama);
        $this->assertEquals('budi@school.com', $guru->email);
        $this->assertEquals(0, $guru->jenis_kelamin);
        $this->assertTrue(Hash::check('password123', $guru->password));
    }

    /** @test */
    public function it_has_many_kelas()
    {
        $guru = Guru::factory()->create();

        // Create multiple classes for this teacher
        Kelas::factory()->count(3)->create(['guru_id' => $guru->id]);

        $this->assertCount(3, $guru->kelas);
        $this->assertInstanceOf(Kelas::class, $guru->kelas->first());
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $guru = new Guru();
        $fillable = $guru->getFillable();

        $expectedFillable = ['kode', 'nama', 'email', 'password', 'jenis_kelamin'];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /** @test */
    public function it_uses_correct_table_name()
    {
        $guru = new Guru();

        $this->assertEquals('gurus', $guru->getTable());
    }

    /** @test */
    public function it_can_authenticate_with_password()
    {
        $guru = Guru::factory()->create([
            'password' => Hash::make('secret123')
        ]);

        $this->assertTrue(Hash::check('secret123', $guru->getAuthPassword()));
        $this->assertFalse(Hash::check('wrongpassword', $guru->getAuthPassword()));
    }
}
