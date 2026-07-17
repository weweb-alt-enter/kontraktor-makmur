<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sekawan Makmur Kontraktor</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #0f1b4d 0%, #1E3A8A 30%, #1e40af 70%, #0f1b4d 100%);
            min-height: 100vh;
        }
        
        /* Animated background pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(251, 191, 36, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(251, 191, 36, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.03) 0%, transparent 80%);
            pointer-events: none;
        }
        
        /* Floating shapes */
        .shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: float 20s infinite ease-in-out;
        }
        
        .shape-1 {
            width: 400px;
            height: 400px;
            background: rgba(251, 191, 36, 0.08);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 300px;
            height: 300px;
            background: rgba(59, 130, 246, 0.08);
            bottom: -50px;
            left: -50px;
            animation-delay: -7s;
        }
        
        .shape-3 {
            width: 200px;
            height: 200px;
            background: rgba(251, 191, 36, 0.06);
            top: 50%;
            left: 50%;
            animation-delay: -14s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(50px, -50px) scale(1.1);
            }
            50% {
                transform: translate(-30px, 30px) scale(0.9);
            }
            75% {
                transform: translate(-60px, -20px) scale(1.05);
            }
        }
        
        /* Glass morphism card */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        }
        
        /* Input focus styles */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1), 0 0 0 1px rgba(30, 58, 138, 0.5);
            border-color: #1E3A8A;
        }
        
        /* Button hover effect */
        .btn-login {
            background: linear-gradient(135deg, #1E3A8A 0%, #1e40af 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="bg-pattern"></div>
    
    <!-- Login Card -->
    <div class="w-full max-w-md relative z-10">
        <div class="glass-card rounded-3xl p-8 md:p-10">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <!-- Logo -->
                <div class="inline-flex items-center justify-center mb-6">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-900 to-primary-800 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-900/20 transform -rotate-6 hover:rotate-0 transition-transform duration-300">
                            <i class="fas fa-hard-hat text-4xl text-accent-500"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-accent-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-primary-900 text-xs"></i>
                        </div>
                    </div>
                </div>
                
                <h1 class="text-2xl font-heading font-extrabold text-gray-900 mb-1">
                    Sekawan Makmur
                </h1>
                <p class="text-sm text-gray-500 font-medium">
                    Kontraktor Terpercaya
                </p>
                <div class="mt-4 inline-flex items-center space-x-2 text-xs text-gray-400">
                    <span class="w-8 h-px bg-gray-300"></span>
                    <span>DASHBOARD LOGIN</span>
                    <span class="w-8 h-px bg-gray-300"></span>
                </div>
            </div>

            <!-- Error Alert -->
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 animate-shake">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-red-800">Login Gagal</p>
                        <p class="text-xs text-red-600 mt-0.5">{{ $errors->first() }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-400 hover:text-red-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            @if(session('status'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-gray-400 mr-1.5"></i> Email
                    </label>
                    <div class="relative group">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="input-focus w-full pl-4 pr-4 py-3 rounded-xl border border-gray-300 bg-white/50 
                                      text-gray-900 placeholder-gray-400 transition-all duration-200
                                      group-hover:border-primary-400"
                               placeholder="admin@sekawanmakmur.com">
                    </div>
                </div>
                
                <!-- Password Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-gray-400 mr-1.5"></i> Password
                    </label>
                    <div class="relative group">
                        <input type="password" name="password" required id="passwordInput"
                               class="input-focus w-full pl-4 pr-12 py-3 rounded-xl border border-gray-300 bg-white/50 
                                      text-gray-900 placeholder-gray-400 transition-all duration-200
                                      group-hover:border-primary-400"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-eye text-lg" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" 
                               class="w-4 h-4 rounded border-gray-300 text-primary-900 focus:ring-primary-500 cursor-pointer">
                        <span class="ml-2.5 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya</span>
                    </label>
                    
                    {{-- Uncomment if you have password reset --}}
                    {{-- <a href="#" class="text-sm text-primary-700 hover:text-primary-900 font-medium transition-colors">
                        Lupa Password?
                    </a> --}}
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="btn-login w-full text-white py-3.5 px-6 rounded-xl font-semibold text-base
                               flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk Dashboard</span>
                </button>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white text-gray-500 font-medium">ATAU</span>
                    </div>
                </div>
                
                <!-- Back to Website -->
                <a href="{{ route('home') }}" 
                   class="w-full flex items-center justify-center space-x-2 py-3 px-6 rounded-xl 
                          border-2 border-gray-200 text-gray-700 font-medium
                          hover:border-primary-300 hover:text-primary-900 hover:bg-primary-50
                          transition-all duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Website</span>
                </a>
            </form>
        </div>
        
        <!-- Footer Text -->
        <div class="text-center mt-6">
            <p class="text-xs text-white/60">
                &copy; {{ date('Y') }} Sekawan Makmur Kontraktor. All rights reserved.
            </p>
            <p class="text-xs text-white/40 mt-1">
                Hanya untuk akses dashboard authorized personnel
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('passwordToggleIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Auto-hide error alert
        setTimeout(() => {
            const alerts = document.querySelectorAll('.animate-shake');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 8000);
    </script>
</body>
</html>