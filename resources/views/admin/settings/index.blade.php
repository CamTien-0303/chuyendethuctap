@extends('layouts.admin')

@section('title', ' - Cài đặt hệ thống')
@section('page-title', 'Cài đặt hệ thống')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Cài đặt hệ thống</h1>
                <p class="text-gray-600 dark:text-gray-400">Quản lý cấu hình và tùy chọn hệ thống</p>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('admin.settings.reset') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
                        onclick="return confirm('Bạn có chắc chắn muốn khôi phục về cài đặt mặc định?')">
                        <i class="fas fa-redo-alt mr-2"></i>
                        Khôi phục mặc định
                    </button>
                </form>
                <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors duration-200"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa cache?')">
                        <i class="fas fa-trash mr-2"></i>
                        Xóa Cache
                    </button>
                </form>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Cấu hình hệ thống</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tùy chỉnh các thiết lập cho website</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <h3 class="text-red-800 dark:text-red-200 font-medium">Có lỗi xảy ra:</h3>
                        </div>
                        <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- General Settings Tab -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-globe mr-2 text-blue-500"></i>
                            Thông tin chung
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($generalSettings as $setting)
                                <div class="{{ $setting->type == 'textarea' ? 'md:col-span-2' : '' }}">
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $setting->label }} 
                                        @if($setting->key == 'site_name' || $setting->key == 'items_per_page')
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    
                                    @if($setting->type == 'text' || $setting->type == 'email' || $setting->type == 'number')
                                        <input type="{{ $setting->type }}" 
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                            id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                            {{ $setting->key == 'site_name' || $setting->key == 'items_per_page' ? 'required' : '' }}>
                                    @elseif($setting->type == 'textarea')
                                        <textarea 
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                            id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                    @elseif($setting->type == 'boolean')
                                        <div class="flex items-center">
                                            <label class="toggle-switch">
                                                <input type="checkbox" id="{{ $setting->key }}" name="{{ $setting->key }}" 
                                                    {{ $setting->value == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $setting->value == '1' ? 'Đang bật' : 'Đang tắt' }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @error($setting->key)
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-phone mr-2 text-green-500"></i>
                            Thông tin liên hệ
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($contactSettings as $setting)
                                <div class="{{ $setting->type == 'textarea' ? 'md:col-span-2' : '' }}">
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $setting->label }}
                                        @if($setting->key == 'contact_email')
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>
                                    
                                    @if($setting->type == 'text' || $setting->type == 'email')
                                        <input type="{{ $setting->type }}" 
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                            id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                            {{ $setting->key == 'contact_email' ? 'required' : '' }}>
                                    @elseif($setting->type == 'textarea')
                                        <textarea 
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                            id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                    @endif
                                    
                                    @error($setting->key)
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                    </div>

                    <!-- Social Media -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-share-alt mr-2 text-purple-500"></i>
                            Mạng xã hội
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($socialSettings as $setting)
                                <div>
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $setting->label }}
                                    </label>
                                    
                                    <input type="url" 
                                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                        id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}">
                                    
                                    @error($setting->key)
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Appearance Settings -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-paint-brush mr-2 text-indigo-500"></i>
                            Giao diện
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($appearanceSettings as $setting)
                                @if($setting->type == 'boolean')
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div>
                                            <label for="{{ $setting->key }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $setting->label }}
                                            </label>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $setting->key == 'dark_mode_default' ? 'Mặc định chế độ tối khi truy cập' : '' }}
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <label class="toggle-switch">
                                                <input type="checkbox" id="{{ $setting->key }}" name="{{ $setting->key }}" 
                                                    {{ $setting->value == '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $setting->value == '1' ? 'Đang bật' : 'Đang tắt' }}
                                            </span>
                                        </div>
                                    </div>
                                @elseif($setting->type == 'color')
                                    <div>
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            {{ $setting->label }}
                                        </label>
                                        <div class="flex items-center">
                                            <input type="color" 
                                                class="w-12 h-10 border border-gray-300 dark:border-gray-600 rounded mr-2" 
                                                id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}">
                                            <input type="text" 
                                                class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                                value="{{ old($setting->key, $setting->value) }}" id="{{ $setting->key }}_text">
                                        </div>
                                        
                                        @error($setting->key)
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Store Settings -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-store mr-2 text-orange-500"></i>
                            Cài đặt cửa hàng
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($storeSettings as $setting)
                                <div>
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $setting->label }} <span class="text-red-500">*</span>
                                    </label>
                                    
                                    @if($setting->type == 'select')
                                        <select 
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                            id="{{ $setting->key }}" name="{{ $setting->key }}" required>
                                            @if($setting->options)
                                                @foreach(json_decode($setting->options, true) as $value => $label)
                                                    <option value="{{ $value }}" {{ old($setting->key, $setting->value) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    @elseif($setting->type == 'number')
                                        <input type="number" min="5" max="100"
                                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200" 
                                            id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" required>
                                    @endif
                                    
                                    @error($setting->key)
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>
                            Lưu cài đặt
                        </button>
                        <button type="reset" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-undo mr-2"></i>
                            Đặt lại
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Add loading state to submit button
    document.querySelector('button[type="submit"]').addEventListener('click', function() {
        const btn = this;
        const originalHTML = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
        
        // Re-enable after 5 seconds to prevent permanent lock
        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }, 5000);
    });

    // Sync color inputs
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        const textInput = document.getElementById(colorInput.id + '_text');
        if (textInput) {
            colorInput.addEventListener('input', () => {
                textInput.value = colorInput.value;
            });
            textInput.addEventListener('input', () => {
                colorInput.value = textInput.value;
            });
        }
    });
    
    // Validate URLs for social settings
    const urlInputs = document.querySelectorAll('input[type="url"]');
    urlInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !this.value.startsWith('http')) {
                this.value = 'https://' + this.value;
            }
        });
    });
    
    // Toggle switch label updates
    document.querySelectorAll('.toggle-switch input[type="checkbox"]').forEach(checkbox => {
        const statusText = checkbox.parentElement.nextElementSibling;
        if (statusText) {
            checkbox.addEventListener('change', function() {
                statusText.textContent = this.checked ? 'Đang bật' : 'Đang tắt';
            });
        }
    });
</script>
@endsection
