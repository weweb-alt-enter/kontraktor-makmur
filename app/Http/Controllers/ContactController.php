<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\JenisLayanan;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $jenisLayanan = JenisLayanan::all();
        return view('frontend.contact', compact('jenisLayanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string|min:10',
        ]);

        Contact::create($validated + ['status' => 'unread']);

        return redirect()->back()->with('success', 
            'Pesan Anda telah terkirim. Kami akan merespon dalam 1x24 jam.');
    }

    public function storeKonsultasi(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'deskripsi' => 'required|string|min:10',
            'source_type' => 'nullable|string',
            'source_slug' => 'nullable|string',
            'source_judul' => 'nullable|string',
        ]);

        Konsultasi::create($validated + ['status' => 'pending']);

        \Log::info('Konsultasi baru dari halaman kontak', $validated);

        return redirect()->back()->with('success', 
            'Terima kasih, tim kami akan menghubungi Anda dalam 1x24 jam');
    }
}