<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'guru_id',
        'nama'
    ];

    public function guru(){
        return $this->belongsTo(Guru::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function absensies()
    {
        return $this->hasMany(Absensi::class);
    }
}
