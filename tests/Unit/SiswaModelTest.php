<?php

namespace Tests\Unit;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_siswa_with_valid_data()
    {
        $kelas = Kelas::factory()->create();

        $siswaData = [
            'nama' => 'John Doe',
            'kelas_id' => $kelas->id,
            'is_trained' => false,
            'jenis_kelamin' => 0 // 0 = Laki-laki
        ];

        $siswa = Siswa::create($siswaData);

        $this->assertInstanceOf(Siswa::class, $siswa);
        $this->assertEquals('John Doe', $siswa->nama);
        $this->assertEquals($kelas->id, $siswa->kelas_id);
        $this->assertFalse($siswa->is_trained);
        $this->assertEquals(0, $siswa->jenis_kelamin);
    }

    /** @test */
    public function it_belongs_to_a_kelas()
    {
        $kelas = Kelas::factory()->create(['nama' => 'Kelas 10A']);
        $siswa = Siswa::factory()->create(['kelas_id' => $kelas->id]);

        $this->assertInstanceOf(Kelas::class, $siswa->kelas);
        $this->assertEquals('Kelas 10A', $siswa->kelas->nama);
    }

    /** @test */
    public function it_has_many_absensies()
    {
        $siswa = Siswa::factory()->create();

        // Create multiple attendance records
        Absensi::factory()->count(3)->create(['siswa_id' => $siswa->id]);

        $this->assertCount(3, $siswa->absensies);
        $this->assertInstanceOf(Absensi::class, $siswa->absensies->first());
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $siswa = new Siswa();
        $fillable = $siswa->getFillable();

        $expectedFillable = ['id', 'nama', 'kelas_id', 'is_trained', 'jenis_kelamin'];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /** @test */
    public function it_can_update_training_status()
    {
        $siswa = Siswa::factory()->create(['is_trained' => false]);

        $siswa->update(['is_trained' => true]);

        $this->assertEquals(1, $siswa->fresh()->is_trained);
    }
}
