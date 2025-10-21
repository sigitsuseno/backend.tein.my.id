<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakDarurat extends Model
{
    protected $fillable = ['user_id', 'nama', 'hubungan', 'no_telp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
