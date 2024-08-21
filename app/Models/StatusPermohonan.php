<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPermohonan extends Model
{
    protected $table = 'status_permohonan';
    protected $fillable = [
        'permohonan_pinjaman_id', 'status', 'izin_user_ids', 'tolak_user_ids'
    ];

    protected $casts = [
        'izin_user_ids' => 'array', // Konversi kolom menjadi array
        'tolak_user_ids' => 'array', // Konversi kolom menjadi array
    ];

    public function permohonanPinjaman()
    {
    return $this->belongsTo(PermohonanPinjaman::class, 'permohonan_pinjaman_id', 'id');
    }

}
