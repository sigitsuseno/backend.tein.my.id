<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'foto',
        'nama_lengkap',
        'no_paspor',
        'no_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telp',
        'keterangan',
        'warganegara',
        'helper_1',
        'helper_2',
        'helper_3',
    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
