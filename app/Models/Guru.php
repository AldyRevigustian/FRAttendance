<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Guru extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory; // Use the trait
    protected $table = 'gurus';
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

