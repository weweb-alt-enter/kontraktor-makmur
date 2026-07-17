@extends('layouts.admin-layout')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar user
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit User</h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui informasi pengguna</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <!-- User Info Card -->
        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-6">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center font-bold text-lg
                        {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        {{-- FORM UPDATE --}}
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="passwordInput"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 pr-10 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                               placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye text-sm" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('role', $user->role) == 'content' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="role" value="content" {{ old('role', $user->role) == 'content' ? 'checked' : '' }} class="sr-only">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pen text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Content</span>
                        </label>

                        <label class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('role', $user->role) == 'admin' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="role" value="admin" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }} class="sr-only">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Admin</span>
                        </label>
                    </div>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- TOMBOL UPDATE --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Update User
                </button>
            </div>
        </form>

        {{-- FORM DELETE DIPISAH --}}
        @if($user->id !== auth()->id())
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="mt-4 pt-4 border-t border-gray-100"
              onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}? Semua konten yang dibuat oleh user ini akan tetap ada.')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
                <i class="fas fa-trash"></i> Hapus User
            </button>
        </form>
        @else
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <p class="text-sm text-yellow-700 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    Anda tidak dapat menghapus akun sendiri. Minta admin lain untuk menghapusnya.
                </p>
            </div>
        </div>
        @endif
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