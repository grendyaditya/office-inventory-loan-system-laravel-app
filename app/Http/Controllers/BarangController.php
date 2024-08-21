<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\PermohonanPinjaman;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        if ($search) {
            $barangs = Barang::where('nama_barang', 'like', "%{$search}%")->get();
        } else {
            $barangs = Barang::all();
        }
        foreach ($barangs as $barang) {
            $totalDipinjam = PermohonanPinjaman::where('barang_id', $barang->id)
                ->where('status_pengembalian', 0) // Belum dikembalikan
                ->sum('jumlah_barang');
                
            $barang->stok_asli = $barang->jumlah_barang + $totalDipinjam;
        }
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        Barang::create([
            'nama_barang' => $request->input('nama_barang'),
            'jumlah_barang' => $request->input('jumlah_barang'),
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        $barang->update([
            'nama_barang' => $request->input('nama_barang'),
            'jumlah_barang' => $request->input('jumlah_barang'),
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
