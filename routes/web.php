<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
Route::get('/proyek/{slug}', [PortofolioController::class, 'detail'])->name('portofolio.detail');
Route::post('/konsultasi', [PortofolioController::class, 'storeKonsultasi'])->name('konsultasi.store');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/contact/konsultasi', [ContactController::class, 'storeKonsultasi'])->name('contact.konsultasi');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::delete('/favorites/remove', [FavoriteController::class, 'remove'])->name('favorites.remove');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/inspirasi', [App\Http\Controllers\InspirasiController::class, 'index'])->name('inspirasi.index');
Route::get('/inspirasi/{slug}', [App\Http\Controllers\InspirasiController::class, 'show'])->name('inspirasi.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // Jenis Layanan Management
    Route::resource('jenis-layanan', App\Http\Controllers\Admin\JenisLayananController::class);
    
    // Jenis Bangunan Management
    Route::resource('jenis-bangunan', App\Http\Controllers\Admin\JenisBangunanController::class);
    
    // Konsultasi Management
    Route::get('/konsultasi', [App\Http\Controllers\Admin\KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('/konsultasi/{konsultasi}', [App\Http\Controllers\Admin\KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::patch('/konsultasi/{konsultasi}/status', [App\Http\Controllers\Admin\KonsultasiController::class, 'updateStatus'])->name('konsultasi.update-status');
    Route::delete('/konsultasi/{konsultasi}', [App\Http\Controllers\Admin\KonsultasiController::class, 'destroy'])->name('konsultasi.destroy');
    
     // Kategori Inspirasi
    Route::resource('kategori-inspirasi', App\Http\Controllers\Admin\KategoriInspirasiController::class);
    
    // Konsep Inspirasi
    Route::resource('konsep-inspirasi', App\Http\Controllers\Admin\KonsepInspirasiController::class);
    
    // Manage Konten
    // Manage Konten
    Route::prefix('manage-konten')->name('manage-konten.')->group(function () {
        
        // Portofolio
        Route::get('/portofolio', [App\Http\Controllers\Admin\ManageKontenController::class, 'portofolio'])
            ->name('portofolio');
        Route::patch('/portofolio/{portofolio}/toggle-featured', [App\Http\Controllers\Admin\ManageKontenController::class, 'togglePortofolioFeatured'])
            ->name('portofolio.toggle-featured');
        Route::patch('/portofolio/{portofolio}/unpublish', [App\Http\Controllers\Admin\ManageKontenController::class, 'unpublishPortofolio'])
            ->name('portofolio.unpublish');

        // Inspirasi Desain
        Route::get('/inspirasi', [App\Http\Controllers\Admin\ManageKontenController::class, 'inspirasi'])->name('inspirasi');
        Route::patch('/inspirasi/{inspirasi}/toggle', [App\Http\Controllers\Admin\ManageKontenController::class, 'toggleInspirasi'])->name('inspirasi.toggle');
        
        // Blog
        Route::get('/blog', [App\Http\Controllers\Admin\ManageKontenController::class, 'blog'])
            ->name('blog');
        Route::patch('/blog/{blog}/toggle', [App\Http\Controllers\Admin\ManageKontenController::class, 'toggleBlog'])
            ->name('blog.toggle');
        
        // Testimoni
        Route::get('/testimoni', [App\Http\Controllers\Admin\ManageKontenController::class, 'testimoni'])
            ->name('testimoni');
        Route::patch('/testimoni/{testimoni}/toggle', [App\Http\Controllers\Admin\ManageKontenController::class, 'toggleTestimoni'])
            ->name('testimoni.toggle');
        
        // Contacts
        Route::get('/contacts', [App\Http\Controllers\Admin\ManageKontenController::class, 'contacts'])
            ->name('contacts');
        Route::patch('/contacts/{contact}', [App\Http\Controllers\Admin\ManageKontenController::class, 'markContact'])
            ->name('contacts.mark');
    });

    // Generate Sitemap
    Route::get('/generate-sitemap', [App\Http\Controllers\Admin\SitemapController::class, 'generate'])->name('generate-sitemap');
});

// Content Routes
Route::middleware(['auth', 'role:content'])->prefix('content')->name('content.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Content\DashboardController::class, 'index'])->name('dashboard');
    
    // Portofolio Management
    Route::resource('portofolio', App\Http\Controllers\Content\PortofolioController::class);
    Route::delete('/gallery/{gallery}', [App\Http\Controllers\Content\PortofolioController::class, 'deleteGallery'])->name('gallery.delete');
    Route::post('/gallery/reorder', [App\Http\Controllers\Content\PortofolioController::class, 'updateGalleryOrder'])->name('gallery.reorder');
    
    // Blog Management
    Route::resource('blog', App\Http\Controllers\Content\BlogController::class);
    
    // Testimoni Management
    Route::resource('testimoni', App\Http\Controllers\Content\TestimoniController::class);

    Route::resource('inspirasi', App\Http\Controllers\Content\InspirasiController::class);
    Route::delete('/inspirasi-gallery/{gallery}', [App\Http\Controllers\Content\InspirasiController::class, 'deleteGallery'])->name('inspirasi.gallery.delete');
});