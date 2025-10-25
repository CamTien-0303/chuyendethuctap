@extends('layouts.admin')

@section('title', ' - Thêm sản phẩm mới')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Thêm sản phẩm mới</h1>
                <p class="text-gray-600 dark:text-gray-400">Tạo sản phẩm mới cho cửa hàng hoa của bạn</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tạo sản phẩm mới</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Nhập thông tin chi tiết cho sản phẩm mới</p>
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

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Thông tin cơ bản
                        </h3>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Tên sản phẩm -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tên sản phẩm <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('name') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="name" 
                                    name="name"
                                    value="{{ old('name') }}" 
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Danh mục & Thương hiệu -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Danh mục <span class="text-red-500">*</span>
                                    </label>
                                    <select class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('category_id') !border-red-500 dark:!border-red-500 @enderror" 
                                        id="category_id" name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Thương hiệu
                                    </label>
                                    <select class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('brand_id') !border-red-500 dark:!border-red-500 @enderror" 
                                        id="brand_id" name="brand_id">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @if(isset($brands))
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('brand_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mô tả -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mô tả <span class="text-red-500">*</span>
                                </label>
                                <textarea class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('description') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-dollar-sign mr-2 text-green-500"></i>
                            Giá & Tồn kho
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Giá -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Giá <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400">₫</span>
                                    </div>
                                    <input type="number" step="0.01" 
                                        class="w-full pl-8 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('price') !border-red-500 dark:!border-red-500 @enderror"
                                        id="price" name="price" value="{{ old('price') }}" required>
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Giá khuyến mãi -->
                            <div>
                                <label for="sale_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Giá khuyến mãi
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400">₫</span>
                                    </div>
                                    <input type="number" step="0.01"
                                        class="w-full pl-8 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('sale_price') !border-red-500 dark:!border-red-500 @enderror"
                                        id="sale_price" name="sale_price" value="{{ old('sale_price') }}">
                                </div>
                                @error('sale_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Tồn kho -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tồn kho <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('stock') !border-red-500 dark:!border-red-500 @enderror"
                                    id="stock" name="stock" value="{{ old('stock') }}" required>
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-image mr-2 text-purple-500"></i>
                            Ảnh sản phẩm
                        </h3>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Chọn ảnh sản phẩm
                            </label>
                            <input type="file" 
                                class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('image') !border-red-500 dark:!border-red-500 @enderror"
                                id="image" name="image" accept="image/*">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG, PNG, GIF (Tối đa 2MB)</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status Settings -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-toggle-on mr-2 text-blue-500"></i>
                            Trạng thái
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Hiển thị sản phẩm
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Cho phép hiển thị sản phẩm trong cửa hàng</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 dark:peer-focus:ring-pink-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-pink-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label for="is_featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Sản phẩm nổi bật
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Hiển thị trong danh sách sản phẩm nổi bật</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="is_featured" name="is_featured" value="1" 
                                        {{ old('is_featured') ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 dark:peer-focus:ring-pink-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-pink-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>
                            Tạo sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i>
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
                        @endsection

@section('scripts')
<script>
    // Auto slug generation
    document.getElementById('name').addEventListener('input', function () {
        const slug = this.value
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/--+/g, '-');
        const slugField = document.getElementById('slug');
        if (slugField) {
            slugField.value = slug;
        }
    });

    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create image preview
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'image-preview';
                    preview.className = 'mt-4';
                    document.getElementById('image').parentNode.appendChild(preview);
                }
                
                preview.innerHTML = `
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Xem trước:</p>
                    <div class="relative group">
                        <img src="${e.target.result}" alt="Preview" 
                            class="w-full h-48 object-cover rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                        <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <span class="text-white text-sm">Ảnh mới</span>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation enhancement
    document.querySelector('form').addEventListener('submit', function(e) {
        const price = parseFloat(document.getElementById('price').value);
        const salePrice = parseFloat(document.getElementById('sale_price').value);
        
        if (salePrice && salePrice >= price) {
            e.preventDefault();
            alert('Giá khuyến mãi phải nhỏ hơn giá gốc!');
            return false;
        }
    });

    // Add loading state to submit button
    document.querySelector('button[type="submit"]').addEventListener('click', function() {
        const btn = this;
        const originalHTML = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang tạo...';
        
        // Re-enable after 5 seconds to prevent permanent lock
        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }, 5000);
    });
</script>
@endsection
