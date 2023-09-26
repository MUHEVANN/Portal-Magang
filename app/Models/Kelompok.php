<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    protected $table = 'kelompok';
    protected $fillable = ['name'];


    public function user()
    {
        return $this->hasMany(User::class, 'kelompok_id', 'id');
    }

    public function apply()
    {
        return $this->hasOne(Apply::class, 'kelompok_id', 'id');
    }
}
