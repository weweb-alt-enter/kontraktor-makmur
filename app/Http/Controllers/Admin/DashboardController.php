<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortofolioProyek;
use App\Models\Blog;
use App\Models\Testimoni;
use App\Models\Konsultasi;
use App\Models\Contact;
use App\Models\InspirasiDesain;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_portofolio' => PortofolioProyek::count(),
            'total_blog' => Blog::count(),
            'total_testimoni' => Testimoni::count(),
            'total_inspirasi' => InspirasiDesain::count(), // Tambahkan
            'total_konsultasi_pending' => Konsultasi::where('status', 'pending')->count(),
            'total_contacts_unread' => Contact::where('status', 'unread')->count(),
            'total_users' => \App\Models\User::count(),
        ];

        $recentKonsultasi = Konsultasi::with('jenisLayanan')
            ->latest()
            ->take(5)
            ->get();

        $recentContacts = Contact::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentKonsultasi', 'recentContacts'));
    }
}