<?php

namespace App\Http\Controllers;

use App\Models\StatusPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusPermohonanController extends Controller
{
    public function index()
    {
        $permohonanPinjaman = StatusPermohonan::with('permohonanPinjaman')
            ->where('status', 0)
            ->get();

        return view('status_permohonan.index', compact('permohonanPinjaman'));
    }

    public function izin(Request $request, $id)
    {
        $statusPermohonan = StatusPermohonan::findOrFail($id);
        $userId = Auth::id();

        if (!in_array($userId, $statusPermohonan->izin_user_ids ?? [])) {
            $izinUserIds = array_merge($statusPermohonan->izin_user_ids ?? [], [$userId]);
            $statusPermohonan->izin_user_ids = $izinUserIds;

            if (count($izinUserIds) >= 3) {
                $statusPermohonan->status = 1; // Diizinkan
            }
            $statusPermohonan->save();
        }

        return redirect()->route('status_permohonan.index')->with('success', 'Permohonan telah diizinkan.');
    }

    public function tolak(Request $request, $id)
    {
        $statusPermohonan = StatusPermohonan::findOrFail($id);
        $userId = Auth::id();

        if (!in_array($userId, $statusPermohonan->tolak_user_ids ?? [])) {
            $tolakUserIds = array_merge($statusPermohonan->tolak_user_ids ?? [], [$userId]);
            $statusPermohonan->tolak_user_ids = $tolakUserIds;

            if (count($tolakUserIds) >= 3) {
                $statusPermohonan->status = 2; // Ditolak
            }
            $statusPermohonan->save();
        }

        return redirect()->route('status_permohonan.index')->with('success', 'Permohonan telah ditolak.');
    }
}
