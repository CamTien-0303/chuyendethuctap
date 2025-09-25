@props([
    'type' => 'info',
    'dismissible' => true,
    'icon' => null
])

@php
$typeClasses = [
    'success' => 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-700 dark:text-green-200',
    'error' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-700 dark:text-red-200',
    'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-700 dark:text-yellow-200',
    'info' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-200'
];

$iconClasses = [
    'success' => 'fas fa-check-circle',
    'error' => 'fas fa-exclamation-circle',
    'warning' => 'fas fa-exclamation-triangle',
    'info' => 'fas fa-info-circle'
];

$alertClass = $typeClasses[$type] ?? $typeClasses['info'];
$iconClass = $icon ?? ($iconClasses[$type] ?? $iconClasses['info']);
@endphp

<div {{ $attributes->merge(['class' => "border rounded-lg px-4 py-3 shadow-sm {$alertClass}"]) }}
     x-data="{ show: true }" 
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="{{ $iconClass }}"></i>
        </div>
        <div class="ml-3 flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
        <div class="flex-shrink-0 ml-4">
            <button @click="show = false" class="inline-flex text-current hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-current rounded">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
    </div>
</div>
