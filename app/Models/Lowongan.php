<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    protected $table = 'job_magang';
    protected $fillable = ['name', 'desc', 'benefit', 'kualifikasi', 'gambar', 'carrer_id'];
    public function user()
    {
        return $this->hasMany(User::class, 'job_magang_id', 'id');
    }
}
