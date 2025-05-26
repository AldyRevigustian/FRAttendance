<?php

namespace Tests\Unit;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class AbsensiModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_absensi_with_valid_data()
    {
        $siswa = Siswa::factory()->create();
        $kelas = Kelas::factory()->create();

        $absensiData = [
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
            'tanggal' => '2024-01-15',
            'waktu_masuk' => '07:30',
            'waktu_keluar' => '14:00'
        ];

        $absensi = Absensi::create($absensiData);

        $this->assertInstanceOf(Absensi::class, $absensi);
        $this->assertEquals($siswa->id, $absensi->siswa_id);
        $this->assertEquals($kelas->id, $absensi->kelas_id);
        $this->assertEquals('2024-01-15', $absensi->tanggal);
        $this->assertEquals('07:30', $absensi->waktu_masuk);
        $this->assertEquals('14:00', $absensi->waktu_keluar);
    }

    /** @test */
    public function it_belongs_to_a_siswa()
    {
        $siswa = Siswa::factory()->create(['nama' => 'John Doe']);
        $absensi = Absensi::factory()->create(['siswa_id' => $siswa->id]);

        $this->assertInstanceOf(Siswa::class, $absensi->siswa);
        $this->assertEquals('John Doe', $absensi->siswa->nama);
    }

    /** @test */
    public function it_belongs_to_a_kelas()
    {
        $kelas = Kelas::factory()->create(['nama' => 'Kelas 10A']);
        $absensi = Absensi::factory()->create(['kelas_id' => $kelas->id]);

        $this->assertInstanceOf(Kelas::class, $absensi->kelas);
        $this->assertEquals('Kelas 10A', $absensi->kelas->nama);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $absensi = new Absensi();
        $fillable = $absensi->getFillable();

        $expectedFillable = ['id', 'siswa_id', 'kelas_id', 'tanggal', 'waktu_masuk', 'waktu_keluar'];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /** @test */
    public function it_can_record_attendance_without_exit_time()
    {
        $siswa = Siswa::factory()->create();
        $kelas = Kelas::factory()->create();

        $absensi = Absensi::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
            'tanggal' => Carbon::today()->toDateString(),
            'waktu_masuk' => '07:30',
            'waktu_keluar' => null
        ]);

        $this->assertEquals('07:30', $absensi->waktu_masuk);
        $this->assertNull($absensi->waktu_keluar);
    }
}
