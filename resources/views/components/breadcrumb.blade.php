@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<nav class="bg-gray-100 py-3 mb-6">
    <div class="container mx-auto px-4">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li>
                <a href="{{ route('home') }}" class="hover:text-primary-900 transition">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            @foreach($breadcrumbs as $breadcrumb)
            <li>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            </li>
            <li>
                @if(isset($breadcrumb['url']))
                <a href="{{ $breadcrumb['url'] }}" class="hover:text-primary-900 transition">
                    {{ $breadcrumb['title'] }}
                </a>
                @else
                <span class="text-gray-800 font-medium">{{ $breadcrumb['title'] }}</span>
                @endif
            </li>
            @endforeach
        </ol>
    </div>
</nav>
@endif