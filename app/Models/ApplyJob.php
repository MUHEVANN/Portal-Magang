<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyJob extends Model
{
    use HasFactory;
    protected $table = 'apply_jobs';
    protected $fillable = ['user_id', 'lowongan_id', 'cv', 'start', 'end', 'alamat', 'pendidikan', 'sekolah', 'portofolio_url', 'linkedin_url', 'ig_url', 'gender', 'alasan', 'konfirmasi'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function lowongan()
    {
        return $this->hasOne(Lowongan::class, 'id', 'lowongan_id');
    }
}
