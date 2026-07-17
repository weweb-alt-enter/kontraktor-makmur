<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with('jenisLayanan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $konsultasi = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.konsultasi.index', compact('konsultasi'));
    }

    public function show(Konsultasi $konsultasi)
    {
        $konsultasi->load('jenisLayanan');
        return view('admin.konsultasi.show', compact('konsultasi'));
    }

    public function updateStatus(Request $request, Konsultasi $konsultasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,dihubungi,selesai',
        ]);

        $konsultasi->update($validated);

        return redirect()->route('admin.konsultasi.index')
            ->with('success', 'Status konsultasi berhasil diupdate');
    }

    public function destroy(Konsultasi $konsultasi)
    {
        $konsultasi->delete();

        return redirect()->route('admin.konsultasi.index')
            ->with('success', 'Konsultasi berhasil dihapus');
    }
}