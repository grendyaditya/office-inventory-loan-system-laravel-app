<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanPinjaman extends Model
{
    protected $table = 'permohonan_pinjaman';
    protected $fillable = [
        'nama',
        'divisi',
        'barang_id',
        'jumlah_barang',
        'tanggal_pinjam',
        'tanggal_dikembalikan',
        'alasan',
        'user_id',
        'status_pengembalian',
        'tanggal_pengembalian'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function statusPermohonan()
    {
        return $this->hasOne(StatusPermohonan::class, 'permohonan_pinjaman_id', 'id');
    }
    
}


