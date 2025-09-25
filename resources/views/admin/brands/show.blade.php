@extends('layouts.admin')

@section('title', ' - Xem thương hiệu')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white transition-colors duration-300">Chi tiết thương hiệu</h1>
            <div>
                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2 transition-colors duration-300">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.brands.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white transition-colors duration-300">Thông tin cơ bản</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">ID</p>
                            <p class="font-medium text-gray-900 dark:text-white transition-colors duration-300">{{ $brand->id }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">Tên thương hiệu</p>
                            <p class="font-medium text-gray-900 dark:text-white transition-colors duration-300">{{ $brand->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">Mô tả</p>
                            <p class="font-medium text-gray-900 dark:text-white transition-colors duration-300">{{ $brand->description ?: 'Chưa có thông tin' }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">Website</p>
                            @if($brand->website)
                                <p class="font-medium">
                                    <a href="{{ $brand->website }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline transition-colors duration-300">
                                        {{ $brand->website }}
                                    </a>
                                </p>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Chưa có thông tin</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">Trạng thái</p>
                            @if($brand->is_active)
                                <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 py-1 px-3 rounded-full text-xs transition-colors duration-300">Hoạt động</span>
                            @else
                                <span class="bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 py-1 px-3 rounded-full text-xs transition-colors duration-300">Không hoạt động</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">Ngày tạo</p>
                            <p class="font-medium text-gray-900 dark:text-white transition-colors duration-300">{{ $brand->created_at->format('F j, Y, g:i a') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm transition-colors duration-300">Cập nhật lần cuối</p>
                            <p class="font-medium text-gray-900 dark:text-white transition-colors duration-300">{{ $brand->updated_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white transition-colors duration-300">Hình ảnh</h3>

                        @if($brand->image)
                            <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                class="max-w-full h-auto rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                        @else
                            <div class="h-48 w-full rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center transition-colors duration-300">
                                <i class="fas fa-image text-gray-400 dark:text-gray-500 text-4xl transition-colors duration-300"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 mt-2 transition-colors duration-300">Chưa có hình ảnh</p>
                        @endif
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white transition-colors duration-300">Sản phẩm từ thương hiệu này</h3>

                    @if($brand->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800 transition-colors duration-300">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal transition-colors duration-300">
                                    <tr>
                                        <th class="py-3 px-6 text-left">ID</th>
                                        <th class="py-3 px-6 text-left">Hình ảnh</th>
                                        <th class="py-3 px-6 text-left">Tên sản phẩm</th>
                                        <th class="py-3 px-6 text-left">Giá</th>
                                        <th class="py-3 px-6 text-center">Trạng thái</th>
                                        <th class="py-3 px-6 text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 dark:text-gray-300 text-sm transition-colors duration-300">
                                    @foreach($brand->products as $product)
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                                            <td class="py-3 px-6">{{ $product->id }}</td>
                                            <td class="py-3 px-6">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                        class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center transition-colors duration-300">
                                                        <i class="fas fa-image text-gray-400 dark:text-gray-500 transition-colors duration-300"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6">{{ $product->name }}</td>
                                            <td class="py-3 px-6">${{ number_format($product->price, 2) }}</td>
                                            <td class="py-3 px-6 text-center">
                                                @if($product->is_active)
                                                    <span
                                                        class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Hoạt động</span>
                                                @else
                                                    <span class="bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 py-1 px-3 rounded-full text-xs transition-colors duration-300">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                        class="w-4 mr-2 transform hover:text-blue-500 dark:hover:text-blue-400 hover:scale-110 transition-colors duration-300">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="w-4 mr-2 transform hover:text-yellow-500 dark:hover:text-yellow-400 hover:scale-110 transition-colors duration-300">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Chưa có sản phẩm nào từ thương hiệu này.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection