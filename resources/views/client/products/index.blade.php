@extends('layouts.client')

@section('title', ' - Tất cả hoa')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-800 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">{{ $title ?? 'Tất cả hoa' }}</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    @if(isset($category))
                        <li><a href="{{ route('products.index') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Sản phẩm</a></li>
                        <li class="mx-2">/</li>
                        <li class="text-pink-600 dark:text-pink-400">{{ $category->name }}</li>
                    @elseif(isset($brand))
                        <li><a href="{{ route('products.index') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Sản phẩm</a></li>
                        <li class="mx-2">/</li>
                        <li class="text-pink-600 dark:text-pink-400">{{ $brand->name }}</li>
                    @else
                        <li class="text-pink-600 dark:text-pink-400">Sản phẩm</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Lỗi:</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <!-- Categories -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow mb-6 transition-colors duration-300">
                    <h3 class="font-bold text-xl mb-4 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-800 dark:text-white">Danh mục</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.category', $cat) }}"
                                    class="flex items-center justify-between hover:text-pink-600 dark:hover:text-pink-400 {{ isset($category) && $category->id === $cat->id ? 'text-pink-600 dark:text-pink-400 font-semibold' : 'text-gray-800 dark:text-gray-200' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-full px-2 py-1">{{ $cat->products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Brands -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow mb-6 transition-colors duration-300">
                    <h3 class="font-bold text-xl mb-4 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-800 dark:text-white">Thương hiệu</h3>
                    <ul class="space-y-2">
                        @foreach($brands as $b)
                            <li>
                                <a href="{{ route('products.brand', $b) }}"
                                    class="flex items-center justify-between hover:text-pink-600 dark:hover:text-pink-400 {{ isset($brand) && $brand->id === $b->id ? 'text-pink-600 dark:text-pink-400 font-semibold' : 'text-gray-800 dark:text-gray-200' }}">
                                    <span>{{ $b->name }}</span>
                                    <span
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-full px-2 py-1">{{ $b->products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow mb-6 transition-colors duration-300">
                    <h3 class="font-bold text-xl mb-4 border-b border-gray-200 dark:border-gray-700 pb-2 text-gray-800 dark:text-white">Khoảng giá</h3>
                    <form action="{{ route('products.index') }}" method="GET">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('brand_id'))
                            <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <div class="mb-3">
                            <label for="min_price" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Giá tối thiểu:</label>
                            <input type="number" name="min_price" id="min_price" min="0"
                                value="{{ request('min_price', '') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded focus:outline-none focus:border-pink-500"
                                placeholder="Giá tối thiểu">
                        </div>
                        <div class="mb-3">
                            <label for="max_price" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Giá tối đa:</label>
                            <input type="number" name="max_price" id="max_price" min="0"
                                value="{{ request('max_price', '') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded focus:outline-none focus:border-pink-500"
                                placeholder="Giá tối đa">
                        </div>
                        <button type="submit" class="bg-pink-600 dark:bg-pink-700 hover:bg-pink-700 dark:hover:bg-pink-800 text-white px-4 py-2 rounded w-full transition-colors duration-300">
                            Áp dụng lọc
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="lg:w-3/4">
                <!-- Search and Sort -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6 flex flex-col md:flex-row justify-between items-center transition-colors duration-300">
                    <div class="mb-4 md:mb-0 w-full md:w-1/2">
                        <form action="{{ route('products.index') }}" method="GET" class="flex">
                            @if(request()->has('category_id'))
                                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                            @endif
                            @if(request()->has('brand_id'))
                                <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
                            @endif
                            @if(request()->has('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if(request()->has('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif
                            <input type="text" name="search" value="{{ request('search', '') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-l focus:outline-none focus:border-pink-500"
                                placeholder="Tìm kiếm sản phẩm...">
                            <button type="submit" class="bg-pink-600 dark:bg-pink-700 hover:bg-pink-700 dark:hover:bg-pink-800 text-white px-4 py-2 rounded-r transition-colors duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="w-full md:w-auto">
                        <form action="{{ route('products.index') }}" method="GET" class="flex items-center" id="sort-form">
                            @if(request()->has('category_id'))
                                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                            @endif
                            @if(request()->has('brand_id'))
                                <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
                            @endif
                            @if(request()->has('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if(request()->has('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif
                            @if(request()->has('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <label for="sort" class="text-sm text-gray-600 dark:text-gray-400 mr-2">Sắp xếp theo:</label>
                            <select name="sort" id="sort"
                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded focus:outline-none focus:border-pink-500"
                                onchange="document.getElementById('sort-form').submit()">
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_low_high" {{ request('sort') === 'price_low_high' ? 'selected' : '' }}>
                                    Giá: Thấp đến cao</option>
                                <option value="price_high_low" {{ request('sort') === 'price_high_low' ? 'selected' : '' }}>
                                    Giá: Cao đến thấp</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Tên: A đến Z
                                </option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Tên: Z đến A
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                @if($products->count() > 0)
                    <!-- Products -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 border border-gray-200 dark:border-gray-700">
                                <a href="{{ route('products.show', $product) }}">
                                    <div class="h-56 overflow-hidden">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-cover hover:scale-110 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                                <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $product) }}" class="block mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white hover:text-pink-600 dark:hover:text-pink-400 transition duration-300">
                                            {{ $product->name }}</h3>
                                    </a>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        @if($product->category)
                                            <a href="{{ route('products.category', $product->category) }}"
                                                class="hover:text-pink-600 dark:hover:text-pink-400">{{ $product->category->name }}</a>
                                        @endif
                                        @if($product->brand)
                                            | <a href="{{ route('products.brand', $product->brand) }}"
                                                class="hover:text-pink-600 dark:hover:text-pink-400">{{ $product->brand->name }}</a>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-lg font-bold text-pink-600 dark:text-pink-400">${{ number_format($product->price, 2) }}</span>
                                        <div class="flex gap-2">
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="bg-pink-600 dark:bg-pink-700 hover:bg-pink-700 dark:hover:bg-pink-800 text-white rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                    <i class="fas fa-shopping-basket"></i>
                                                </button>
                                            </form>
                                            
                                            @auth
                                                @php
                                                    $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                                        ->where('product_id', $product->id)
                                                        ->exists();
                                                @endphp
                                                
                                                @if($inWishlist)
                                                    <form action="{{ route('wishlist.remove', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                            <i class="fas fa-heart"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                            <i class="far fa-heart"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                    <i class="far fa-heart"></i>
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow text-center transition-colors duration-300">
                        <i class="fas fa-search text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-2">Không tìm thấy sản phẩm</h3>
                        <p class="text-gray-500 dark:text-gray-400">Chúng tôi không thể tìm thấy sản phẩm nào phù hợp với tiêu chí của bạn. Hãy thử điều chỉnh bộ lọc hoặc từ khóa tìm kiếm.</p>
                        <a href="{{ route('products.index') }}"
                            class="mt-4 inline-block bg-pink-600 dark:bg-pink-700 hover:bg-pink-700 dark:hover:bg-pink-800 text-white py-2 px-6 rounded-md transition duration-300">
                            Xem tất cả sản phẩm
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection