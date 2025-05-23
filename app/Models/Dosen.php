<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dosen extends Authenticatable
{
    use HasApiTokens, Notifiable; // Use the trait
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

