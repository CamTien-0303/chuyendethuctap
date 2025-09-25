@extends('layouts.client')

@section('title', ' - Hoa tươi đẹp cho mọi dịp')

@section('content')
    <!-- Banner Slider -->
    @if($banners->count() > 0)
    <div class="relative">
        <div class="w-full overflow-hidden">
            <div class="carousel-container flex transition-transform duration-500">
                @foreach($banners as $banner)
                <div class="carousel-item w-full flex-shrink-0">
                    <div class="relative h-96 md:h-[500px] w-full">
                        @if($banner->image)
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                            <div class="text-center px-4 max-w-4xl">
                                <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $banner->title }}</h1>
                                @if($banner->description)
                                <p class="text-lg md:text-xl text-white mb-6">{{ $banner->description }}</p>
                                @endif
                                @if($banner->link)
                                <a href="{{ $banner->link }}" class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md text-lg transition duration-300">Mua ngay</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @if($banners->count() > 1)
        <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 p-2 rounded-full carousel-prev">
            <i class="fas fa-chevron-left text-pink-600"></i>
        </button>
        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 p-2 rounded-full carousel-next">
            <i class="fas fa-chevron-right text-pink-600"></i>
        </button>
        @endif
    </div>
    @endif

    <!-- Categories Section -->
    <section class="py-12 bg-white dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-900 dark:text-white">Mua theo danh mục</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('products.category', $category) }}" class="group">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 h-full">
                        <div class="h-48 overflow-hidden">
                            @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            @endif
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="text-xl font-semibold mb-1 text-gray-900 dark:text-white">{{ $category->name }}</h3>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
    <section class="py-12 bg-pink-50 dark:bg-gray-800 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-900 dark:text-white">Hoa nổi bật</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <a href="{{ route('products.show', $product) }}">
                        <div class="h-56 overflow-hidden">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition duration-300">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                            @endif
                        </div>
                    </a>
                    <div class="p-4">
                        <a href="{{ route('products.show', $product) }}" class="block mb-2">
                            <h3 class="text-lg font-semibold hover:text-pink-600 text-gray-900 dark:text-white transition duration-300">{{ $product->name }}</h3>
                        </a>
                        <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-pink-600">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                    <i class="fas fa-shopping-basket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                    Xem tất cả hoa
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Products -->
    <section class="py-12 bg-white dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-900 dark:text-white">Sản phẩm mới nhất</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestProducts->take(8) as $product)
                <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 border border-gray-200 dark:border-gray-700">
                    <a href="{{ route('products.show', $product) }}">
                        <div class="h-56 overflow-hidden">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition duration-300">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            @endif
                        </div>
                    </a>
                    <div class="p-4">
                        <a href="{{ route('products.show', $product) }}" class="block mb-2">
                            <h3 class="text-lg font-semibold hover:text-pink-600 text-gray-900 dark:text-white transition duration-300">{{ $product->name }}</h3>
                        </a>
                        <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-pink-600">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                    <i class="fas fa-shopping-basket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                    Xem tất cả hoa
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Simple carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.carousel-container');
        const items = document.querySelectorAll('.carousel-item');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');
        let current = 0;
        
        if (items.length > 0) {
            // Set initial position
            updateCarousel();
            
            // Auto play
            setInterval(() => {
                current = (current + 1) % items.length;
                updateCarousel();
            }, 5000);
            
            // Button controls
            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', function() {
                    current = (current - 1 + items.length) % items.length;
                    updateCarousel();
                });
                
                nextBtn.addEventListener('click', function() {
                    current = (current + 1) % items.length;
                    updateCarousel();
                });
            }
        }
        
        function updateCarousel() {
            container.style.transform = `translateX(-${current * 100}%)`;
        }
    });
</script>
@endsection
