<?php

namespace App\Observers;

use App\Models\StatusPermohonan;
use App\Models\PermohonanPinjaman;

class StatusPermohonanObserver
{
    public function updated(StatusPermohonan $statusPermohonan)
    {
        // Temukan permohonan pinjaman terkait
        $permohonanPinjaman = PermohonanPinjaman::find($statusPermohonan->permohonan_pinjaman_id);

        // Pastikan permohonan pinjaman ditemukan dan status pengembaliannya 0 (menunggu)
        if ($statusPermohonan->status == 1 && $permohonanPinjaman && $permohonanPinjaman->status_pengembalian == 0) {
            // Update status pengembalian pada PermohonanPinjaman
            $permohonanPinjaman->update(['status_pengembalian' => 1]); // Set status_pengembalian ke 'belum dikembalikan'
        }
    }
}
