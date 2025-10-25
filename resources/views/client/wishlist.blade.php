@extends('layouts.client')

@section('title', ' - Danh sách yêu thích của tôi')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-800 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Danh sách yêu thích</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600 dark:text-pink-400">Yêu thích</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-colors duration-300">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Sản phẩm yêu thích</h2>
            </div>

            @if($wishlistItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                    @foreach($wishlistItems as $item)
                        <div
                            class="border border-gray-200 rounded-lg overflow-hidden group hover:shadow-lg transition-shadow duration-300">
                            <div class="relative">
                                @if($item->product && $item->product->image)
                                    <a href="{{ route('products.show', $item->product) }}">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                            class="w-full h-48 object-cover">
                                    </a>
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 dark:text-gray-500 text-3xl"></i>
                                    </div>
                                @endif

                                <form action="{{ route('wishlist.remove', $item) }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-white dark:bg-gray-700 rounded-full h-8 w-8 flex items-center justify-center shadow-md hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-300"
                                        title="Xóa khỏi danh sách yêu thích">
                                        <i class="fas fa-heart text-red-500"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="p-4">
                                @if($item->product)
                                    <a href="{{ route('products.show', $item->product) }}" class="block">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ $item->product->name }}</h3>
                                    </a>
                                    <div class="flex justify-between items-center mb-2">
                                        <span
                                            class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ number_format($item->product->price, 0, ',', '.') }}₫</span>
                                        <div>
                                            @if($item->product->stock > 0)
                                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-xs rounded-full">Còn hàng</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 text-xs rounded-full">Hết hàng</span>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="w-full bg-pink-600 hover:bg-pink-700 text-white py-2 rounded-md transition duration-300 {{ $item->product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $item->product->stock <= 0 ? 'disabled' : '' }}>
                                            Thêm vào giỏ hàng
                                        </button>
                                    </form>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">Sản phẩm không còn tồn tại</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-heart text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Danh sách yêu thích của bạn đang trống</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-pink-600 dark:bg-pink-700 hover:bg-pink-700 dark:hover:bg-pink-800 text-white py-2 px-6 rounded-md transition duration-300">
                        Mua sắm ngay
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection