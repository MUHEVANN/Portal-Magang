<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    use HasFactory;
    protected $table = 'apply';
    protected $fillable = ['carrer_id', 'status', 'user_id', 'cv_user', 'tgl_mulai', 'tgl_selesai', 'tipe_magang'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function carrer()
    {
        return $this->hasOne(Carrer::class, 'id', 'carrer_id');
    }
}
