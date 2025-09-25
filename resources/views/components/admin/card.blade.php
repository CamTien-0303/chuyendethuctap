@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'padding' => 'p-6',
    'shadow' => 'shadow-sm',
    'hover' => false
])

@php
$cardClass = 'bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 transition-all duration-200 ' . $shadow . ' ' . $padding;

if ($hover) {
    $cardClass .= ' hover:shadow-lg hover:scale-105 cursor-pointer';
}
@endphp

<div {{ $attributes->merge(['class' => $cardClass]) }}>
    @if($title || $subtitle || $icon)
        <div class="mb-6">
            @if($title)
                <div class="flex items-center mb-2">
                    @if($icon)
                        <i class="{{ $icon }} text-pink-500 mr-2"></i>
                    @endif
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                </div>
            @endif
            
            @if($subtitle)
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    
    {{ $slot }}
</div>
