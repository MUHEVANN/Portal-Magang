<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    use HasFactory;
    protected $table = 'apply';
    protected $fillable = ['carrer_id', 'status', 'user_id', 'cv_user', 'tgl_mulai', 'tgl_selesai', 'tipe_magang', 'job_magang_id', 'kelompok_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function carrer()
    {
        return $this->hasOne(Carrer::class, 'id', 'carrer_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'job_magang_id', 'id');
    }
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }
}
