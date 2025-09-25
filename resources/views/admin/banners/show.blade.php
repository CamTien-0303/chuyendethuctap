@extends('layouts.admin')

@section('title', 'Chi tiết Banner')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chi tiết Banner</h1>
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
                <a href="{{ route('admin.banners.edit', $banner) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh sửa
                </a>
                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Xóa
                    </button>
                </form>
                <a href="{{ route('admin.banners.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Banner Details Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin Banner</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Chi tiết thông tin banner</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Banner Information -->
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $banner->id }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tiêu đề</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $banner->title }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Mô tả</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $banner->description ?: 'Không có mô tả' }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Đường dẫn URL</label>
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-lg font-semibold">{{ $banner->link }}</a>
                                @else
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">Không có đường dẫn</p>
                                @endif
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Thứ tự sắp xếp</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $banner->sort_order }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Trạng thái</label>
                                @if($banner->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        <i class="fas fa-check-circle mr-1"></i>Hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                        <i class="fas fa-times-circle mr-1"></i>Không hoạt động
                                    </span>
                                @endif
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Ngày tạo</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $banner->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Cập nhật lần cuối</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $banner->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Image -->
                    <div>
                        @if($banner->image)
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hình ảnh Banner</h3>
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                    class="w-full rounded-lg shadow-sm border border-gray-200 dark:border-gray-700" style="max-height: 400px; object-fit: cover;">
                            </div>
                        @else
                            <div class="text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded-lg p-8">
                                <i class="fas fa-image text-4xl mb-4"></i>
                                <p class="text-lg">Chưa tải lên hình ảnh</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Xem trước Banner</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Xem trước banner như trên trang web</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($banner->image)
                    <div class="relative h-80 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                            <div class="text-center px-4 max-w-4xl">
                                <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $banner->title }}</h1>
                                @if($banner->description)
                                    <p class="text-lg md:text-xl text-white mb-6">{{ $banner->description }}</p>
                                @endif
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" class="inline-flex items-center px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors duration-200">
                                        Xem thêm
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded-lg py-20">
                        <i class="fas fa-image text-6xl mb-4"></i>
                        <p class="text-xl">Không có hình ảnh để xem trước</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection