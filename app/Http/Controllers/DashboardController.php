<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PermohonanPinjaman;
use App\Models\PengembalianBarang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Menghitung total barang
        $totalBarang = Barang::count();

        // Menghitung riwayat peminjaman saya
        $riwayatPeminjamanSaya = PermohonanPinjaman::where('user_id', $userId)->count();

        // Menghitung riwayat peminjaman semua
        $riwayatPeminjamanSemua = PermohonanPinjaman::count();

        // Menghitung pengembalian barang
        $pengembalianBarang = PengembalianBarang::count();

        return view('home', [
            'totalBarang' => $totalBarang,
            'riwayatPeminjamanSaya' => $riwayatPeminjamanSaya,
            'riwayatPeminjamanSemua' => $riwayatPeminjamanSemua,
            'pengembalianBarang' => $pengembalianBarang,
        ]);
    }
}
