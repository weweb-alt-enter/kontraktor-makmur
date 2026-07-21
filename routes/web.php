<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;

// ============================================
// DEBUG ROUTES - TARUH DI PALING ATAS!
// ============================================

Route::get('/ping', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Server is running!',
        'time' => now()->toIso8601String(),
    ]);
});

Route::get('/env-test', function () {
    return response()->json([
        'app_env' => env('APP_ENV'),
        'app_debug' => env('APP_DEBUG'),
        'db_connection' => env('DB_CONNECTION'),
        'db_host' => env('DB_HOST'),
        'db_port' => env('DB_PORT'),
        'db_database' => env('DB_DATABASE'),
        'db_username' => env('DB_USERNAME'),
        'db_password_exists' => !empty(env('DB_PASSWORD')),
        'app_key_exists' => !empty(env('APP_KEY')),
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
    ]);
});

Route::get('/db-test', function () {
    try {
        $connection = DB::connection()->getPdo();
        $database = DB::connection()->getDatabaseName();
        
        // Coba get tables
        $tables = [];
        try {
            $tables = DB::select('SHOW TABLES');
            $tables = array_map('current', $tables);
        } catch (\Exception $e) {
            $tables = ['error' => $e->getMessage()];
        }
        
        return response()->json([
            'status' => 'connected',
            'database' => $database,
            'tables' => $tables,
            'connection_info' => [
                'host' => config('database.connections.mysql.host'),
                'port' => config('database.connections.mysql.port'),
                'database' => config('database.connections.mysql.database'),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
});

Route::get('/test-view', function () {
    return view('welcome');
});

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'healthy',
            'app' => config('app.name'),
            'env' => config('app.env'),
            'database' => 'connected',
            'timestamp' => now()->toIso8601String(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'unhealthy',
            'error' => $e->getMessage(),
        ], 500);
    }
});

// ============================================
// HOME ROUTE SEMENTARA UNTUK DEBUG
// ============================================
Route::get('/home-test', function () {
    return "<h1 style='color:green;'>✅ Laravel is working!</h1>
            <p>If you see this, the application is running correctly.</p>
            <p>Current time: " . now() . "</p>
            <hr>
            <h3>Debug Links:</h3>
            <ul>
                <li><a href='/ping'>/ping</a></li>
                <li><a href='/env-test'>/env-test</a></li>
                <li><a href='/db-test'>/db-test</a></li>
                <li><a href='/test-view'>/test-view</a></li>
                <li><a href='/health'>/health</a></li>
            </ul>";
});

// ============================================
// FRONTEND ROUTES
// ============================================

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

// ============================================
// AUTHENTICATION ROUTES
// ============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================
// ADMIN ROUTES (Middleware: auth & role:admin)
// ============================================

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

// ============================================
// CONTENT ROUTES (Middleware: auth & role:content)
// ============================================

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

    // Inspirasi Management
    Route::resource('inspirasi', App\Http\Controllers\Content\InspirasiController::class);
    Route::delete('/inspirasi-gallery/{gallery}', [App\Http\Controllers\Content\InspirasiController::class, 'deleteGallery'])->name('inspirasi.gallery.delete');
});