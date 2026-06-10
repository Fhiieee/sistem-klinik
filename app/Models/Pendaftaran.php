<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'pasien_id',
        'jadwal_id',
        'tanggal_daftar',
        'nomor_antrean',
        'status',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function pemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class);
    }
}
