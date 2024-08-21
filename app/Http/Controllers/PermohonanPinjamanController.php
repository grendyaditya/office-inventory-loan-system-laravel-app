<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\StatusPermohonan;
use App\Models\PermohonanPinjaman;
use Illuminate\Support\Facades\Auth;

class PermohonanPinjamanController extends Controller
{
    public function index()
    {
        $permohonanPinjaman = PermohonanPinjaman::where('user_id', Auth::id())->get();

        foreach ($permohonanPinjaman as $permohonan) {
            $statusPermohonan = $permohonan->statusPermohonan;
            $permohonan->tanggal_pengembalian = $permohonan->tanggal_pengembalian ?? 'Kosong';
            $permohonan->disetujui_oleh = $this->getApprovedUsers($statusPermohonan->izin_user_ids ?? '');
    
            if ($statusPermohonan) {
                $permohonan->disetujui_oleh = $this->getApprovedUsers($statusPermohonan->izin_user_ids ?? '');
    
                if ($statusPermohonan->status == 2) { // Jika status permohonan ditolak
                    $permohonan->status_pengembalian = 'Ditolak';
                } else {
                    $permohonan->status_pengembalian = $this->getStatusDescription($permohonan->status_pengembalian);
                }
            } else {
                $permohonan->disetujui_oleh = 'Tidak ada persetujuan';
                $permohonan->status_pengembalian = $this->getStatusDescription($permohonan->status_pengembalian);
            }
        
        }

        return view('permohonan_pinjaman.index', compact('permohonanPinjaman'));
    }

    private function getApprovedUsers($izinUserIds)
    {
        if (is_string($izinUserIds) && !empty($izinUserIds)) {
            $userIds = explode(',', $izinUserIds);
        } elseif (is_array($izinUserIds) && !empty($izinUserIds)) {
            $userIds = $izinUserIds;
        } else {
            return 'Tidak ada persetujuan';
        }

        if (count($userIds) < 3) {
            return 'Tidak ada persetujuan';
        }

        $users = User::whereIn('id', $userIds)->pluck('name')->toArray();
        if (!empty($users)) {
            return implode(', ', $users);
        }

        return 'Tidak ada persetujuan';
    }
    

    public function show(){
        $allPermohonans = PermohonanPinjaman::all();

        foreach ($allPermohonans as $permohonan) {
            $statusPermohonan = $permohonan->statusPermohonan;
            $permohonan->tanggal_pengembalian = $permohonan->tanggal_pengembalian ?? 'Kosong';
            $permohonan->disetujui_oleh = $this->getApprovedUsers($statusPermohonan->izin_user_ids ?? '');
    
            if ($statusPermohonan) {
                $permohonan->disetujui_oleh = $this->getApprovedUsers($statusPermohonan->izin_user_ids ?? '');
    
                if ($statusPermohonan->status == 2) { // Jika status permohonan ditolak
                    $permohonan->status_pengembalian = 'Ditolak';
                } else {
                    $permohonan->status_pengembalian = $this->getStatusDescription($permohonan->status_pengembalian);
                }
            } else {
                $permohonan->disetujui_oleh = 'Tidak ada persetujuan';
                $permohonan->status_pengembalian = $this->getStatusDescription($permohonan->status_pengembalian);
            }
        
        }

        return view('permohonan_pinjaman.riwayat', compact('allPermohonans'));
    }
    private function getStatusDescription($status)
    {
        switch ($status) {
            case 0:
                return 'Menunggu';
            case 1:
                return 'Belum Dikembalikan';
            case 2:
                return 'Sudah Dikembalikan';
            case 3:
                return 'Dikembalikan Terlambat';
            default:
                return 'Status Tidak Diketahui';
        }
    }



    public function create()
    {
        // Ambil semua data barang untuk ditampilkan di form
        $barangs = Barang::all();
        return view('permohonan_pinjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        // Validasi data permohonan pinjaman
        $request->validate([
            'nama' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'barang_id' => 'required|exists:barang,id',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_dikembalikan' => 'required|date|after_or_equal:tanggal_pinjam', // Memperbaiki aturan validasi
            'alasan' => 'nullable|string',
        ]);

        // Periksa stok barang yang tersedia
        $barang = Barang::findOrFail($request->barang_id);
        if ($request->jumlah_barang > $barang->jumlah_barang) {
            return redirect()->back()->withErrors(['jumlah_barang' => 'Jumlah barang yang diminta melebihi stok yang tersedia.'])->withInput();
        }
    
        // Kurangi stok barang
        $barang->jumlah_barang -= $request->jumlah_barang;
        $barang->save();
        // Simpan permohonan pinjaman baru
        $permohonan = PermohonanPinjaman::create([
            'user_id' => Auth::id(), // Set user_id dari pengguna yang sedang login
            'nama' => $request->nama,
            'divisi' => $request->divisi,
            'barang_id' => $request->barang_id,
            'jumlah_barang' => $request->jumlah_barang,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_dikembalikan' => $request->tanggal_dikembalikan,
            'alasan' => $request->alasan,
            'status_pengembalian' => 0, // Set status pengembalian ke 'menunggu'
        ]);

        // Simpan status permohonan baru dengan status 0 (menunggu)
        StatusPermohonan::create([
            'permohonan_pinjaman_id' => $permohonan->id,
            'status' => 0, // Menunggu
            'izin_user_ids' => [], // Kosongkan array untuk izin
            'tolak_user_ids' => [] // Kosongkan array untuk tolak
        ]);

        return redirect()->route('permohonan.index')->with('success', 'Permohonan pinjaman berhasil dibuat.');
    }
}
