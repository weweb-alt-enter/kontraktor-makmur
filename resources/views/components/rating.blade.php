@props(['rating' => 0, 'size' => 'sm'])

@php
$sizes = [
    'sm' => 'text-sm',
    'md' => 'text-lg',
    'lg' => 'text-2xl',
];
$sizeClass = $sizes[$size] ?? 'text-sm';
@endphp

<div class="flex items-center {{ $sizeClass }} text-accent-500">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
        <i class="fas fa-star"></i>
        @elseif($i - 0.5 <= $rating)
        <i class="fas fa-star-half-alt"></i>
        @else
        <i class="far fa-star"></i>
        @endif
    @endfor
    <span class="ml-2 text-gray-600 text-sm">({{ $rating }}/5)</span>
</div>