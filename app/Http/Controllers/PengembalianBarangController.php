<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\StatusPermohonan;
use App\Models\PermohonanPinjaman;
use Illuminate\Support\Facades\Auth;

class PengembalianBarangController extends Controller
{
    public function index()
    {
        // Update status pengembalian jika diperlukan
        $this->updateStatusPengembalian();

        // Ambil permohonan pinjaman dengan status_pengembalian = 1 dan status permohonan = 1
        $userId = Auth::id();
        $permohonanPinjaman = PermohonanPinjaman::where('user_id', $userId)
            ->where('status_pengembalian', 1)
            ->whereHas('statusPermohonan', function($query) {
                $query->where('status', 1);
            })
            ->get();

        return view('pengembalian_barang.index', compact('permohonanPinjaman'));
    }

    public function store(Request $request)
{
    // Validasi
    $request->validate([
        'permohonan_pinjaman_id' => 'required|exists:permohonan_pinjaman,id',
    ]);

    // Temukan permohonan pinjaman
    $permohonanPinjaman = PermohonanPinjaman::findOrFail($request->permohonan_pinjaman_id);

    // Debugging: Cek data permohonan pinjaman yang ditemukan
    // dd($permohonanPinjaman);

    // Periksa apakah permohonan telah diizinkan
    $statusPermohonan = StatusPermohonan::where('permohonan_pinjaman_id', $permohonanPinjaman->id)->first();
    if (!$statusPermohonan || $statusPermohonan->status != 1) {
        return redirect()->back()->with('error', 'Barang hanya bisa dikembalikan jika permohonan telah diizinkan.');
    }

    // Periksa apakah tanggal pengembalian sudah lewat      
    $statusPengembalian = 2; // Default ke 'sudah dikembalikan'
    if (Carbon::now()->gt(Carbon::parse($permohonanPinjaman->tanggal_dikembalikan))) {
        $statusPengembalian = 3; // Status 'dikembalikan terlambat'
    }
    // Tambah stok barang
    $barang = Barang::findOrFail($permohonanPinjaman->barang_id);
    $barang->jumlah_barang += $permohonanPinjaman->jumlah_barang;
    $barang->save();


    // Debugging: Tampilkan data yang akan diupdate
    $dataToUpdate = [
        'status_pengembalian' => $statusPengembalian,
        'tanggal_pengembalian' => Carbon::now(),
    ];
    // dd($dataToUpdate);

    // Update data
    $permohonanPinjaman->update($dataToUpdate);

    // Debugging: Cek apakah update berhasil
    // dd($permohonanPinjaman);

    return redirect()->route('pengembalian.index')->with('success', 'Barang telah berhasil dikembalikan.');
}



    private function updateStatusPengembalian()
    {
        $permohonanPinjamans = PermohonanPinjaman::whereHas('statusPermohonan', function ($query) {
            $query->where('status', 1); // Diizinkan
        })
        ->where('status_pengembalian', 0) // Belum dikembalikan
        ->get();

        foreach ($permohonanPinjamans as $permohonanPinjaman) {
            $permohonanPinjaman->update([
                'status_pengembalian' => 1 // Set status_pengembalian ke 'belum dikembalikan'
            ]);
        }
    }
}
