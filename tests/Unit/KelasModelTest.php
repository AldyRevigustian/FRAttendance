<?php

namespace Tests\Unit;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelasModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_kelas_with_valid_data()
    {
        $guru = Guru::factory()->create();

        $kelasData = [
            'nama' => 'Kelas 10A',
            'guru_id' => $guru->id
        ];

        $kelas = Kelas::create($kelasData);

        $this->assertInstanceOf(Kelas::class, $kelas);
        $this->assertEquals('Kelas 10A', $kelas->nama);
        $this->assertEquals($guru->id, $kelas->guru_id);
    }

    /** @test */
    public function it_belongs_to_a_guru()
    {
        $guru = Guru::factory()->create(['nama' => 'Pak Budi']);
        $kelas = Kelas::factory()->create(['guru_id' => $guru->id]);

        $this->assertInstanceOf(Guru::class, $kelas->guru);
        $this->assertEquals('Pak Budi', $kelas->guru->nama);
    }

    /** @test */
    public function it_has_many_siswas()
    {
        $kelas = Kelas::factory()->create();

        // Create multiple students for this class
        Siswa::factory()->count(5)->create(['kelas_id' => $kelas->id]);

        $this->assertCount(5, $kelas->siswas);
        $this->assertInstanceOf(Siswa::class, $kelas->siswas->first());
    }

    /** @test */
    public function it_has_many_absensies()
    {
        $kelas = Kelas::factory()->create();

        // Create multiple attendance records for this class
        Absensi::factory()->count(4)->create(['kelas_id' => $kelas->id]);

        $this->assertCount(4, $kelas->absensies);
        $this->assertInstanceOf(Absensi::class, $kelas->absensies->first());
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $kelas = new Kelas();
        $fillable = $kelas->getFillable();

        $expectedFillable = ['id', 'guru_id', 'nama'];

        $this->assertEquals($expectedFillable, $fillable);
    }
}
