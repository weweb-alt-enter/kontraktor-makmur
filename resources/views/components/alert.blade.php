@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-start gap-3" role="alert">
    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-check-circle text-green-600"></i>
    </div>
    <div class="flex-1">
        <p class="text-sm font-medium text-green-800">Berhasil!</p>
        <p class="text-sm text-green-700 mt-0.5">{{ session('success') }}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-green-400 hover:text-green-600">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-start gap-3" role="alert">
    <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-exclamation-circle text-red-600"></i>
    </div>
    <div class="flex-1">
        <p class="text-sm font-medium text-red-800">Error!</p>
        <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-red-400 hover:text-red-600">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if($errors->any())
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6" role="alert">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-red-600"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium text-red-800">Mohon perbaiki kesalahan berikut:</p>
            <ul class="mt-2 space-y-1">
                @foreach($errors->all() as $error)
                <li class="flex items-center gap-2 text-sm text-red-700">
                    <i class="fas fa-circle text-[4px] text-red-400"></i>
                    {{ $error }}
                </li>
                @endforeach
            </ul>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-400 hover:text-red-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif