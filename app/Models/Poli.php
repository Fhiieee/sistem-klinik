<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
        'nama_poli',
        'deskripsi',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
