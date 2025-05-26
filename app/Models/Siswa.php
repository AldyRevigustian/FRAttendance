<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nis',
        'nama',
        'kelas_id',
        'is_trained',
        'jenis_kelamin'
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensies()
    {
        return $this->hasMany(Absensi::class);
    }
}
