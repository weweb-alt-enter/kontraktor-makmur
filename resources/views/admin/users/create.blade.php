@extends('layouts.admin-layout')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar user
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Tambah User Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk mengakses dashboard</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-gray-400 mr-1.5"></i> Nama Lengkap *
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Masukkan nama lengkap">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-gray-400 mr-1.5"></i> Email *
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="email@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-gray-400 mr-1.5"></i> Password *
                    </label>
                    <div class="relative">
                        <input type="password" name="password" required id="passwordInput"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 pr-10 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                               placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye text-sm" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-tag text-gray-400 mr-1.5"></i> Role *
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('role', 'content') == 'content' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="role" value="content" {{ old('role', 'content') == 'content' ? 'checked' : '' }} class="sr-only">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pen text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Content</span>
                        </label>
                        
                        <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('role') == 'admin' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} class="sr-only">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Admin</span>
                        </label>
                    </div>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            {{-- HANYA TOMBOL SIMPAN (CREATE) --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
@endsection