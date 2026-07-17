<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortofolioProyek;
use App\Models\Blog;
use App\Models\Testimoni;
use App\Models\InspirasiDesain;
use App\Models\Contact;
use Illuminate\Http\Request;

class ManageKontenController extends Controller
{
    // === PORTOFOLIO ===
    public function portofolio()
    {
        $portofolios = PortofolioProyek::with(['jenisLayanan', 'jenisBangunan', 'creator'])
            ->latest()
            ->paginate(10);
        
        return view('admin.manage-konten.portofolio', compact('portofolios'));
    }

    public function togglePortofolioFeatured(PortofolioProyek $portofolio)
    {
        $portofolio->update([
            'is_featured' => !$portofolio->is_featured
        ]);

        $status = $portofolio->is_featured ? 'diunggulkan' : 'dihapus dari unggulan';
        return redirect()->back()->with('success', "Portofolio '{$portofolio->nama_proyek}' berhasil {$status}");
    }

    public function unpublishPortofolio(PortofolioProyek $portofolio)
    {
        $newStatus = $portofolio->status_proyek == 'selesai' ? 'direncanakan' : 'selesai';
        
        $portofolio->update([
            'status_proyek' => $newStatus
        ]);

        $statusText = $newStatus == 'selesai' ? 'dipublish' : 'diunpublish';
        return redirect()->back()->with('success', "Portofolio '{$portofolio->nama_proyek}' berhasil {$statusText}");
    }

    // === BLOG ===
    public function blog()
    {
        $blogs = Blog::with('creator')
            ->latest()
            ->paginate(10);
        
        return view('admin.manage-konten.blog', compact('blogs'));
    }

    public function toggleBlog(Blog $blog)
    {
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => $blog->is_published ? null : now(),
        ]);

        $status = $blog->is_published ? 'dipublish' : 'diunpublish';
        return redirect()->back()->with('success', "Artikel '{$blog->judul}' berhasil {$status}");
    }

    // === TESTIMONI ===
    public function testimoni()
    {
        $testimonis = Testimoni::with('portofolio')
            ->latest()
            ->paginate(12);
        
        return view('admin.manage-konten.testimoni', compact('testimonis'));
    }

    public function toggleTestimoni(Testimoni $testimoni)
    {
        $testimoni->update([
            'is_published' => !$testimoni->is_published
        ]);

        $status = $testimoni->is_published ? 'dipublish' : 'diunpublish';
        return redirect()->back()->with('success', "Testimoni dari '{$testimoni->nama_client}' berhasil {$status}");
    }

    // === INSPIRASI DESAIN ===
    public function inspirasi()
    {
        $inspirasi = InspirasiDesain::with('creator')
            ->latest()
            ->paginate(12);
        
        return view('admin.manage-konten.inspirasi', compact('inspirasi'));
    }

    public function toggleInspirasi(InspirasiDesain $inspirasi)
    {
        $inspirasi->update([
            'is_published' => !$inspirasi->is_published,
            'published_at' => $inspirasi->is_published ? null : now(),
        ]);

        $status = $inspirasi->is_published ? 'dipublish' : 'diunpublish';
        return redirect()->back()->with('success', "Inspirasi '{$inspirasi->judul}' berhasil {$status}");
    }

    // === CONTACTS ===
    public function contacts()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.manage-konten.contacts', compact('contacts'));
    }

    public function markContact(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $contact->update($validated);

        return redirect()->back()->with('success', 'Status pesan berhasil diubah');
    }
}