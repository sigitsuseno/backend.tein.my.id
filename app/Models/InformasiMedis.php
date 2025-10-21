<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiMedis extends Model
{
    protected $fillable = [
        'user_id',
        'golongan_darah',
        'riwayat_penyakit',
        'alergi',
        'konsumsi_obat',
        'kondisi_medis_sekarang',
        'tensi_darah',
        'vaksin_id',
        'resep_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
