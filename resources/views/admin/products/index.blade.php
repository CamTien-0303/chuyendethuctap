@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')
@section('page-title', 'Quản lý Sản phẩm')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Quản lý Sản phẩm</h1>
            <p class="text-gray-600 dark:text-gray-400">Xem, tìm kiếm và quản lý tất cả các sản phẩm.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tạo sản phẩm mới
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tìm kiếm</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                    placeholder="Tên, SKU, mô tả..."
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Danh mục</label>
                <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                    <option value="">Tất cả danh mục</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trạng thái</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                    <option value="">Tất cả</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="flex items-end gap-2 justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Tìm kiếm
                </button>
                @if(request('search') || request('category') || request('status'))
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Xóa
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Alert messages -->
    @if(session('success'))
        <div
            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div
            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if(isset($products) && $products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                            <th class="py-3 px-4 text-left">
                                Hình ảnh
                            </th>
                            <th class="py-3 px-4 text-left">
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                    Thông tin sản phẩm
                                    @if(request('sort') == 'name')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 opacity-40"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="py-3 px-4 text-left">
                                Danh mục/Thương hiệu
                            </th>
                            <th class="py-3 px-4 text-left">
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'price', 'direction' => request('sort') == 'price' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                    Giá
                                    @if(request('sort') == 'price')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 opacity-40"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="py-3 px-4 text-left">
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'stock', 'direction' => request('sort') == 'stock' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                    Tồn kho
                                    @if(request('sort') == 'stock')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 opacity-40"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="py-3 px-4 text-left">
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => request('sort') == 'is_active' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                    Trạng thái
                                    @if(request('sort') == 'is_active')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 opacity-40"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="py-3 px-4 text-center">
                                Hành động
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 text-sm font-light">
                        @foreach($products as $product)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                <td class="py-3 px-4 text-left">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="h-16 w-16 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-left">
                                    <div class="font-medium">{{ $product->name ?? 'N/A' }}</div>
                                    <div class="text-gray-500 dark:text-gray-400 mt-1">
                                        SKU: {{ $product->sku ?? 'N/A' }}
                                    </div>
                                    @if(isset($product->description))
                                        <div class="text-gray-500 dark:text-gray-400 mt-1">
                                            {{ Str::limit($product->description, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-left">
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $product->category->name ?? 'Không có danh mục' }}
                                        </span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            {{ $product->brand->name ?? 'Không có thương hiệu' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-left">
                                    <div class="font-semibold">
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </div>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <div class="text-red-500 dark:text-red-400 font-medium">
                                            {{ number_format($product->sale_price, 0, ',', '.') }}₫
                                        </div>
                                        <div class="text-gray-500 dark:text-gray-400 line-through text-xs">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-left">
                                    <div>
                                        {{ $product->stock }}
                                    </div>
                                    @if($product->stock <= 10)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Sắp hết
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-left">
                                    <span class="px-2 py-1 rounded-full text-xs
                                    @if($product->is_active) bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                    @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                                    @endif">
                                        @if($product->is_active)
                                            Hiển thị
                                        @else
                                            Ẩn
                                        @endif
                                    </span>
                                    @if($product->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 mt-1">
                                            <i class="fas fa-star mr-1"></i>
                                            Nổi bật
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex item-center justify-center space-x-3">
                                        <a href="{{ route('admin.products.show', $product) }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition-transform duration-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-700 transform hover:scale-110 transition-transform duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form class="inline-block" action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transform hover:scale-110 transition-transform duration-200">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <i class="fas fa-box-open text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Không có sản phẩm nào được tìm thấy</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Bắt đầu bằng cách thêm sản phẩm đầu tiên vào hệ thống.
                </p>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Thêm sản phẩm đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
