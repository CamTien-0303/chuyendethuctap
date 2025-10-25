@extends('layouts.admin')

@section('title', ' - Chỉnh sửa Banner')
@section('page-title', 'Chỉnh sửa Banner')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chỉnh sửa Banner</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                                <i class="fas fa-home mr-2"></i>
                                Bảng điều khiển
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2"></i>
                                <a href="{{ route('admin.banners.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                                    Banner
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2"></i>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $banner->title }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.banners.index') }}"
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
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Chỉnh sửa Banner</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Cập nhật thông tin banner</p>
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

                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Thông tin cơ bản
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tiêu đề Banner <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('title') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Thứ tự sắp xếp
                                </label>
                                <input type="number" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('sort_order') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mô tả
                            </label>
                            <textarea 
                                class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('description') !border-red-500 dark:!border-red-500 @enderror" 
                                id="description" name="description" rows="4">{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Banner Image & Link -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-image mr-2 text-purple-500"></i>
                            Hình ảnh & Liên kết
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Hình ảnh Banner
                                </label>
                                <input type="file" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('image') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="image" name="image" accept="image/*">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kích thước khuyến nghị: 1920x800px. Dung lượng tối đa: 2MB. Để trống để giữ hình ảnh hiện tại.</p>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                
                                @if($banner->image)
                                <div class="mt-4 relative group">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" 
                                        class="w-full h-48 object-contain rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm group-hover:shadow-lg transition-shadow duration-200"
                                        onerror="this.onerror=null; this.src='{{ asset('storage/banners/default.png') }}'; this.classList.add('img-error')">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg transition-all duration-200 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $banner->image }}</p>
                                @endif
                            </div>
                            
                            <div>
                                <label for="link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Đường dẫn URL
                                </label>
                                <input type="url" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('link') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="link" name="link" value="{{ old('link', $banner->link) }}" placeholder="https://example.com">
                                @error('link')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-toggle-on mr-2 text-green-500"></i>
                            Trạng thái
                        </h3>

                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kích hoạt Banner
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Banner sẽ hiển thị trên trang web khi được kích hoạt</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="is_active" name="is_active" value="1" 
                                    {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 dark:peer-focus:ring-pink-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-pink-600"></div>
                            </label>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>
                            Cập nhật Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}" 
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
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                const existingPreview = document.getElementById('newImagePreview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Create preview
                const previewContainer = document.createElement('div');
                previewContainer.id = 'newImagePreview';
                previewContainer.className = 'mt-2';
                
                const label = document.createElement('label');
                label.className = 'form-label';
                label.textContent = 'Xem trước hình ảnh mới:';
                
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'img-thumbnail d-block';
                preview.style.maxWidth = '300px';
                preview.style.maxHeight = '150px';
                
                previewContainer.appendChild(label);
                previewContainer.appendChild(preview);
                
                // Insert preview after the file input
                document.getElementById('image').parentNode.appendChild(previewContainer);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
