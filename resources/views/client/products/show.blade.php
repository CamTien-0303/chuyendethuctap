@extends('layouts.client')

@section('title', ' - ' . $product->name)

@section('content')
    <div class="bg-gray-100 dark:bg-gray-800 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Sản phẩm</a></li>
                    @if($product->category)
                        <li class="mx-2">/</li>
                        <li><a href="{{ route('products.category', $product->category) }}"
                                class="hover:text-pink-600 dark:hover:text-pink-400">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="mx-2">/</li>
                    <li class="text-pink-600 dark:text-pink-400">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-colors duration-300">
            <div class="flex flex-col lg:flex-row">
                <!-- Product Image -->
                <div class="lg:w-1/2">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 dark:bg-gray-700">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                                <i class="fas fa-image text-6xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                <div class="lg:w-1/2 p-6 lg:p-8">
                    <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        <span class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ number_format($product->price, 0) }}₫</span>
                        @if($product->compare_price > $product->price)
                            <span
                                class="ml-2 text-lg text-gray-500 dark:text-gray-400 line-through">{{ number_format($product->compare_price, 0) }}₫</span>
                            <span class="ml-2 bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-xs font-semibold px-2 py-1 rounded">
                                {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% GIẢM
                            </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        @if($product->stock > 0)
                            <span class="inline-block bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 text-sm font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i> Còn hàng ({{ $product->stock }})
                            </span>
                        @else
                            <span class="inline-block bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 text-sm font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-times-circle mr-1"></i> Hết hàng
                            </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
                    </div>

                    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                        @if($product->category)
                            <p class="mb-1">
                                <span class="font-semibold">Danh mục:</span>
                                <a href="{{ route('products.category', $product->category) }}"
                                    class="text-pink-600 dark:text-pink-400 hover:underline">
                                    {{ $product->category->name }}
                                </a>
                            </p>
                        @endif

                        @if($product->brand)
                            <p class="mb-1">
                                <span class="font-semibold">Thương hiệu:</span>
                                <a href="{{ route('products.brand', $product->brand) }}" class="text-pink-600 dark:text-pink-400 hover:underline">
                                    {{ $product->brand->name }}
                                </a>
                            </p>
                        @endif

                        @if($product->sku)
                            <p class="mb-1"><span class="font-semibold">Mã sản phẩm:</span> {{ $product->sku }}</p>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col md:flex-row items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div
                                    class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden mb-4 md:mb-0 md:mr-4">
                                    <button type="button"
                                        class="quantity-btn minus-btn px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1"
                                        class="w-16 text-center border-0 focus:ring-0 focus:outline-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white" id="quantity-input">
                                    <button type="button"
                                        class="quantity-btn plus-btn px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <button type="submit"
                                    class="bg-pink-600 dark:bg-pink-700 hover:bg-pink-700 dark:hover:bg-pink-800 text-white py-2 px-6 rounded-md transition duration-300 w-full md:w-auto flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Thêm vào giỏ hàng
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 py-2 px-6 rounded-md w-full md:w-auto flex items-center justify-center cursor-not-allowed">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Hết hàng
                            </button>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-2 text-sm">
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
                                        <button type="submit" class="flex items-center text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300">
                                            <i class="fas fa-heart mr-1"></i> Xóa khỏi danh sách yêu thích
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400">
                                            <i class="far fa-heart mr-1"></i> Thêm vào danh sách yêu thích
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400">
                                    <i class="far fa-heart mr-1"></i> Thêm vào danh sách yêu thích
                                </a>
                            @endauth
                            <span class="text-gray-300 dark:text-gray-600 mx-2">|</span>
                            <a href="#" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400">
                                <i class="fas fa-share-alt mr-1"></i> Chia sẻ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="p-6 border-t border-gray-200">
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-4 pb-2 border-b text-gray-900 dark:text-white border-gray-200">Chi tiết sản phẩm</h2>
                    <div class="prose max-w-none text-gray-700">
                        {{ $product->description }}
                    </div>
                </div>

                @if($product->specifications)
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">Thông số kỹ thuật</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! $product->specifications !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Sản phẩm liên quan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 border border-gray-200">
                            <a href="{{ route('products.show', $relatedProduct) }}">
                                <div class="h-48 overflow-hidden">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}"
                                            class="w-full h-full object-cover hover:scale-110 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <i class="fas fa-image text-4xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('products.show', $relatedProduct) }}" class="block mb-2">
                                    <h3 class="text-lg font-semibold hover:text-pink-600 text-gray-900 dark:text-white transition duration-300">
                                        {{ $relatedProduct->name }}</h3>
                                </a>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-lg font-bold text-pink-600">{{ number_format($relatedProduct->price, 0) }}₫</span>
                                    <div class="flex gap-2">
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                            <button type="submit"
                                                class="bg-pink-600 hover:bg-pink-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                <i class="fas fa-shopping-basket"></i>
                                            </button>
                                        </form>
                                        
                                        @auth
                                            @php
                                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                                    ->where('product_id', $relatedProduct->id)
                                                    ->exists();
                                            @endphp
                                            
                                            @if($inWishlist)
                                                <form action="{{ route('wishlist.remove', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $relatedProduct->id)->first()) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('wishlist.add', $relatedProduct) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quantity buttons
            const minusBtn = document.querySelector('.minus-btn');
            const plusBtn = document.querySelector('.plus-btn');
            const quantityInput = document.getElementById('quantity-input');

            if (minusBtn && plusBtn && quantityInput) {
                const maxStock = parseInt(quantityInput.getAttribute('max'));

                minusBtn.addEventListener('click', function () {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });

                plusBtn.addEventListener('click', function () {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue < maxStock) {
                        quantityInput.value = currentValue + 1;
                    }
                });

                quantityInput.addEventListener('change', function () {
                    if (this.value < 1) {
                        this.value = 1;
                    } else if (this.value > maxStock) {
                        this.value = maxStock;
                    }
                });
            }
        });

        // Handle add to cart AJAX
        const addToCartForm = document.querySelector('form[action="{{ route('cart.add') }}"]');
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Disable button and show loading
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang thêm...';
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count in header
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.count;
                        }
                        
                        // Show success message (you can customize this)
                        showToast(data.message, 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng', 'error');
                })
                .finally(() => {
                    // Re-enable button
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
            });
        }
    </script>
@endsection