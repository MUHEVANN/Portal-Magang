<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    use HasFactory;
    protected $table = 'apply';
    protected $fillable = ['carrer_id', 'user_id', 'lowongan_id', 'status', 'kelompok_id'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function lowongan()
    {
        return $this->hasOne(Lowongan::class, 'id', 'lowongan_id');
    }
    public function carrer()
    {
        return $this->hasOne(Carrer::class, 'id', 'carrer_id');
    }
    public function kelompok()
    {
        return $this->hasOne(Kelompok::class, 'id', 'kelompok_id');
    }
}
