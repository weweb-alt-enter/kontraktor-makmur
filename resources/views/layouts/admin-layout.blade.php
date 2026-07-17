<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - Sekawan Makmur</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .sidebar-link {
            position: relative;
            transition: all 0.2s ease;
        }
        
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 1.5rem;
        }
        
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 3px solid #FBBF24;
            font-weight: 600;
        }
        
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: #FBBF24;
            border-radius: 0 3px 3px 0;
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(-5deg);
        }
        
        .stat-icon {
            transition: all 0.3s ease;
        }
        
        .mobile-sidebar {
            transition: transform 0.3s ease;
        }
        
        .mobile-sidebar.open {
            transform: translateX(0);
        }
        
        .mobile-sidebar.closed {
            transform: translateX(-100%);
        }
        
        .badge-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden" onclick="closeSidebar()"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-primary-900 via-primary-900 to-primary-800 text-white 
                                  transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-between px-6 h-16 border-b border-white/10 flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hard-hat text-accent-500"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-heading font-bold leading-tight">Sekawan Makmur</h2>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Admin Panel</p>
                    </div>
                </a>
                <button onclick="closeSidebar()" class="lg:hidden text-gray-400 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                          {{ request()->routeIs('admin.dashboard') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-accent-500' : '' }}"></i>
                    <span>Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                    <i class="fas fa-chevron-right text-[10px] ml-auto text-accent-500"></i>
                    @endif
                </a>
                
                <!-- Divider -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Management</p>
                </div>
                
                <!-- Users -->
                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                          {{ request()->routeIs('admin.users.*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-users w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-accent-500' : '' }}"></i>
                    <span>Users</span>
                    @if(request()->routeIs('admin.users.*'))
                    <i class="fas fa-chevron-right text-[10px] ml-auto text-accent-500"></i>
                    @endif
                </a>
                
                <!-- Jenis Layanan -->
                <a href="{{ route('admin.jenis-layanan.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                          {{ request()->routeIs('admin.jenis-layanan.*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-tools w-5 text-center {{ request()->routeIs('admin.jenis-layanan.*') ? 'text-accent-500' : '' }}"></i>
                    <span>Jenis Layanan</span>
                </a>
                
                <!-- Jenis Bangunan -->
                <a href="{{ route('admin.jenis-bangunan.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                          {{ request()->routeIs('admin.jenis-bangunan.*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-building w-5 text-center {{ request()->routeIs('admin.jenis-bangunan.*') ? 'text-accent-500' : '' }}"></i>
                    <span>Jenis Bangunan</span>
                </a>

                <!-- Kategori Inspirasi -->
                <a href="{{ route('admin.kategori-inspirasi.index') }}" 
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                        {{ request()->routeIs('admin.kategori-inspirasi.*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-folder w-5 text-center {{ request()->routeIs('admin.kategori-inspirasi.*') ? 'text-accent-500' : '' }}"></i>
                    <span>Kategori Inspirasi</span>
                </a>

                <!-- Konsep Inspirasi -->
                <a href="{{ route('admin.konsep-inspirasi.index') }}" 
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                        {{ request()->routeIs('admin.konsep-inspirasi.*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-palette w-5 text-center {{ request()->routeIs('admin.konsep-inspirasi.*') ? 'text-accent-500' : '' }}"></i>
                    <span>Konsep Inspirasi</span>
                </a>
                
                <!-- Konsultasi -->
                <a href="{{ route('admin.konsultasi.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                          {{ request()->routeIs('admin.konsultasi.*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-comments w-5 text-center {{ request()->routeIs('admin.konsultasi.*') ? 'text-accent-500' : '' }}"></i>
                    <span>Konsultasi</span>
                    @php $pendingKonsultasi = \App\Models\Konsultasi::where('status', 'pending')->count(); @endphp
                    @if($pendingKonsultasi > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full badge-pulse">
                        {{ $pendingKonsultasi }}
                    </span>
                    @endif
                </a>
                
                <!-- Divider -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Konten</p>
                </div>
                
                <!-- Portofolio -->
                <a href="{{ route('admin.manage-konten.portofolio') }}" 
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                        {{ request()->routeIs('admin.manage-konten.portofolio*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-briefcase w-5 text-center {{ request()->routeIs('admin.manage-konten.portofolio*') ? 'text-accent-500' : '' }}"></i>
                    <span>Portofolio</span>
                </a>

                <!-- Inspirasi Desain -->
                <a href="{{ route('admin.manage-konten.inspirasi') }}" 
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                        {{ request()->routeIs('admin.manage-konten.inspirasi*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-paint-brush w-5 text-center {{ request()->routeIs('admin.manage-konten.inspirasi*') ? 'text-accent-500' : '' }}"></i>
                    <span>Inspirasi Desain</span>
                </a>

                <!-- Blog -->
                <a href="{{ route('admin.manage-konten.blog') }}" 
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                        {{ request()->routeIs('admin.manage-konten.blog*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-newspaper w-5 text-center {{ request()->routeIs('admin.manage-konten.blog*') ? 'text-accent-500' : '' }}"></i>
                    <span>Blog</span>
                </a>

                <!-- Testimoni -->
                <a href="{{ route('admin.manage-konten.testimoni') }}" 
                class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                        {{ request()->routeIs('admin.manage-konten.testimoni*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-star w-5 text-center {{ request()->routeIs('admin.manage-konten.testimoni*') ? 'text-accent-500' : '' }}"></i>
                    <span>Testimoni</span>
                </a>
                
                <!-- Contacts -->
                <a href="{{ route('admin.manage-konten.contacts') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all
                          {{ request()->routeIs('admin.manage-konten.contacts*') ? 'active bg-white/10 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-envelope w-5 text-center {{ request()->routeIs('admin.manage-konten.contacts*') ? 'text-accent-500' : '' }}"></i>
                    <span>Pesan Masuk</span>
                    @php $unreadContacts = \App\Models\Contact::where('status', 'unread')->count(); @endphp
                    @if($unreadContacts > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full badge-pulse">
                        {{ $unreadContacts }}
                    </span>
                    @endif
                </a>
                
                <!-- Divider -->
                <div class="pt-4 pb-2">
                    <p class="px-4 text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Tools</p>
                </div>
                
                <!-- Sitemap -->
                <a href="{{ route('admin.generate-sitemap') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all text-gray-300">
                    <i class="fas fa-sitemap w-5 text-center"></i>
                    <span>Generate Sitemap</span>
                </a>
                
                <!-- View Website -->
                <a href="{{ route('home') }}" target="_blank"
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all text-gray-300">
                    <i class="fas fa-external-link-alt w-5 text-center"></i>
                    <span>Lihat Website</span>
                </a>
            </nav>
            
            <!-- User Footer -->
            <div class="border-t border-white/10 p-4 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-400">Administrator</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors p-1" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto bg-gray-50">
            <!-- Top Header -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 lg:px-8 h-16">
                    <!-- Mobile menu button -->
                    <button onclick="openSidebar()" class="lg:hidden text-gray-600 hover:text-primary-900 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Breadcrumb / Page Title -->
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-heading font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                    </div>
                    
                    <!-- Right actions -->
                    <div class="flex items-center gap-4">
                        <!-- Notifikasi -->
                        <a href="{{ route('admin.konsultasi.index') }}" class="relative text-gray-500 hover:text-primary-900 transition">
                            <i class="fas fa-bell text-lg"></i>
                            @if($pendingKonsultasi > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                {{ $pendingKonsultasi }}
                            </span>
                            @endif
                        </a>
                        
                        <!-- User dropdown -->
                        <div class="relative group hidden sm:block">
                            <button class="flex items-center gap-2 text-sm text-gray-700 hover:text-primary-900 transition">
                                <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary-900 text-xs"></i>
                                </div>
                                <span class="hidden md:inline font-medium">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                            </button>
                            
                            <div class="absolute right-0 top-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 min-w-[200px] 
                                        opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-external-link-alt w-5 text-gray-400"></i> Lihat Website
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt w-5"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 lg:p-8">
                <x-alert />
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }
        
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>