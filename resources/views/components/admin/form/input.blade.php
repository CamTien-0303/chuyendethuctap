@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'required' => false,
    'placeholder' => null,
    'helpText' => null,
    'icon' => null,
    'value' => null
])

@php
$inputId = $name ?? uniqid('input_');
$hasError = $errors->has($name);
$inputValue = $value ?? old($name);

$inputClass = 'w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:text-white transition-colors duration-200';

if ($hasError) {
    $inputClass .= ' border-red-500 dark:border-red-500';
} else {
    $inputClass .= ' border-gray-300 dark:border-gray-600';
}

if ($icon) {
    $inputClass .= ' pl-10';
}
@endphp

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif

        @if($type === 'textarea')
            <textarea 
                id="{{ $inputId }}"
                name="{{ $name }}"
                class="{{ $inputClass }}"
                placeholder="{{ $placeholder }}"
                @if($required) required @endif
                {{ $attributes->except(['class', 'label', 'name', 'type', 'required', 'placeholder', 'helpText', 'icon', 'value']) }}
            >{{ $inputValue }}</textarea>
        @elseif($type === 'select')
            <select 
                id="{{ $inputId }}"
                name="{{ $name }}"
                class="{{ $inputClass }}"
                @if($required) required @endif
                {{ $attributes->except(['class', 'label', 'name', 'type', 'required', 'placeholder', 'helpText', 'icon', 'value']) }}
            >
                {{ $slot }}
            </select>
        @else
            <input 
                type="{{ $type }}"
                id="{{ $inputId }}"
                name="{{ $name }}"
                value="{{ $inputValue }}"
                class="{{ $inputClass }}"
                placeholder="{{ $placeholder }}"
                @if($required) required @endif
                {{ $attributes->except(['class', 'label', 'name', 'type', 'required', 'placeholder', 'helpText', 'icon', 'value']) }}
            />
        @endif
    </div>

    @if($helpText && !$hasError)
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @error($name)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
