@extends('layouts.admin')

@section('title', ' - Chi tiết sản phẩm')
@section('page-title', 'Chi tiết sản phẩm')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chi tiết sản phẩm</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                                <i class="fas fa-home mr-2"></i>
                                Bảng điều khiển
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2"></i>
                                <a href="{{ route('admin.products.index') }}"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                                    Sản phẩm
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mr-2"></i>
                                <span
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $product->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.products.edit', $product) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh sửa
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Xóa
                    </button>
                </form>
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Product Details Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin sản phẩm</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Chi tiết đầy đủ về sản phẩm</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Product Image -->
                    <div class="lg:col-span-1">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hình ảnh sản phẩm</h3>
                            @if($product->image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-80 object-cover rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm group-hover:shadow-lg transition-shadow duration-200">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg transition-all duration-200 flex items-center justify-center">
                                        <i
                                            class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">{{ $product->image }}</p>
                            @else
                                <div
                                    class="w-full h-80 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center">
                                    <div class="text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-image text-6xl mb-4"></i>
                                        <p class="text-lg font-medium">Không có hình ảnh</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <!-- Basic Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Thông tin cơ bản</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Mã
                                            sản phẩm</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">#{{ $product->id }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tên
                                            sản phẩm</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Danh
                                            mục</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $product->category->name ?? 'Chưa phân loại' }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Thương
                                            hiệu</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $product->brand->name ?? 'Không có' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Mô tả sản phẩm</h3>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $product->description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Pricing & Stock -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Giá & Tồn kho</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div
                                        class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-green-600 dark:text-green-400 mb-1">Giá
                                            bán</label>
                                        <p class="text-2xl font-bold text-green-700 dark:text-green-300">
                                            {{ number_format($product->price, 0, ',', '.') }}₫</p>
                                    </div>
                                    @if($product->sale_price)
                                        <div
                                            class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 p-4 rounded-lg">
                                            <label
                                                class="block text-sm font-medium text-orange-600 dark:text-orange-400 mb-1">Giá
                                                khuyến mãi</label>
                                            <p class="text-2xl font-bold text-orange-700 dark:text-orange-300">
                                                {{ number_format($product->sale_price, 0, ',', '.') }}₫</p>
                                        </div>
                                    @endif
                                    <div
                                        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-blue-600 dark:text-blue-400 mb-1">Tồn
                                            kho</label>
                                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">
                                            {{ number_format($product->stock, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Trạng thái</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">Hiển thị</span>
                                        @if($product->is_active)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Đang hiển thị
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Đã ẩn
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">Nổi bật</span>
                                        @if($product->is_featured)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                                <i class="fas fa-star mr-1"></i>
                                                Nổi bật
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400">
                                                <i class="fas fa-star-o mr-1"></i>
                                                Thường
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Thông tin khác</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Ngày
                                            tạo</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $product->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Cập
                                            nhật lần cuối</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $product->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection