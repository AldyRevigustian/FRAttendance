<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    protected $table = 'dosens';
    protected $fillable = [
        'kode',
        'nama',
        'email',
        'password',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}

