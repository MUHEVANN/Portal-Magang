<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrer extends Model
{
    use HasFactory;
    protected $table = 'carrers';
    protected $fillable = ['batch'];
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'carrer_id', 'id');
    }
}