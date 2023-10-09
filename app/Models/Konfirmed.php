<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfirmed extends Model
{
    use HasFactory;
    protected $table = 'konfirmed';
    protected $fillable = ['status', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
