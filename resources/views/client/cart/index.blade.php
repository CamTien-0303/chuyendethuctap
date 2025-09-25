@extends('layouts.client')

@section('title', ' - Giỏ hàng')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-800 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Giỏ hàng</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600 dark:text-pink-400">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if($cartItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-colors duration-300">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Sản phẩm
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Giá
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Số lượng
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tổng
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($cartItems as $item)
                                    @php
                                        $product = Auth::check() ? $item->product : $item;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16">
                                                    @if($product->image)
                                                        <img class="h-16 w-16 object-cover"
                                                            src="{{ asset('storage/' . $product->image) }}"
                                                            alt="{{ $product->name }}">
                                                    @else
                                                        <div class="h-16 w-16 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                            <i class="fas fa-image text-gray-400 dark:text-gray-500"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        <a href="{{ route('products.show', $product) }}"
                                                            class="hover:text-pink-600 dark:hover:text-pink-400">
                                                            {{ $product->name }}
                                                        </a>
                                                    </div>
                                                    @if($product->sku)
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            SKU: {{ $product->sku }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ number_format($product->price, 0) }}₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                class="flex items-center cart-update-form">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden">
                                                    <button type="button"
                                                        class="quantity-btn minus-btn px-2 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                        class="w-12 text-center border-0 focus:ring-0 focus:outline-none text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                                        data-item-id="{{ $item->id }}">
                                                    <button type="button"
                                                        class="quantity-btn plus-btn px-2 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                            {{ number_format($product->price * $item->quantity, 0) }}₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" title="Xóa sản phẩm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('products.index') }}" class="flex items-center text-pink-600 dark:text-pink-400 hover:text-pink-800 dark:hover:text-pink-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Tiếp tục mua sắm
                        </a>

                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                                Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-300">
                        <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">Tóm tắt đơn hàng</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tạm tính</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($subtotal, 0) }}₫</span>
                            </div>

                            @if($discount > 0)
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Giảm giá</span>
                                    <span>-{{ number_format($discount, 0) }}₫</span>
                                </div>
                            @endif

                            @if($tax > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Thuế ({{ $taxRate * 100 }}%)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($tax, 0) }}₫</span>
                                </div>
                            @endif

                            @if($shipping > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Phí vận chuyển</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($shipping, 0) }}₫</span>
                                </div>
                            @else
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Phí vận chuyển</span>
                                    <span>Miễn phí</span>
                                </div>
                            @endif

                            <div class="pt-2 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Tổng cộng</span>
                                <span class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ number_format($total, 0) }}₫</span>
                            </div>
                        </div>

                        <!-- Coupon Code -->
                        <div class="mb-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('cart.apply-coupon') }}" method="POST" class="flex flex-col space-y-2">
                                @csrf
                                <label for="coupon" class="text-sm font-medium text-gray-700 dark:text-gray-300">Mã giảm giá</label>
                                <div class="flex">
                                    <input type="text" id="coupon" name="coupon" value="{{ session('coupon_code', '') }}"
                                        class="flex-1 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-l-md focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400"
                                        placeholder="Nhập mã giảm giá">
                                    <button type="submit"
                                        class="bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-r-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none transition-colors duration-300">
                                        Áp dụng
                                    </button>
                                </div>
                                @if(session('coupon_message'))
                                    <p class="{{ session('coupon_success') ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} text-xs mt-1">
                                        {{ session('coupon_message') }}
                                    </p>
                                @endif
                            </form>
                        </div>

                        <!-- Checkout Button -->
                        <div class="mt-6">
                            <a href="{{ route('checkout') }}"
                                class="block w-full bg-pink-600 hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 text-white text-center py-3 px-4 rounded-md transition duration-300">
                                Tiến hành thanh toán
                            </a>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Thanh toán an toàn</p>
                            <div class="flex gap-2">
                                <span class="text-gray-400 dark:text-gray-500"><i class="fab fa-cc-visa text-2xl"></i></span>
                                <span class="text-gray-400 dark:text-gray-500"><i class="fab fa-cc-mastercard text-2xl"></i></span>
                                <span class="text-gray-400 dark:text-gray-500"><i class="fab fa-cc-amex text-2xl"></i></span>
                                <span class="text-gray-400 dark:text-gray-500"><i class="fab fa-cc-paypal text-2xl"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center transition-colors duration-300">
                <div class="text-gray-400 dark:text-gray-500 mb-4">
                    <i class="fas fa-shopping-cart text-6xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-white mb-2">Giỏ hàng của bạn đang trống</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Có vẻ như bạn chưa thêm sản phẩm nào vào giỏ hàng.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-pink-600 hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 text-white py-2 px-6 rounded-md transition duration-300">
                    Bắt đầu mua sắm
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle quantity buttons
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const input = form.querySelector('input[name="quantity"]');
                    const currentValue = parseInt(input.value);

                    if (this.classList.contains('minus-btn') && currentValue > 1) {
                        input.value = currentValue - 1;
                    } else if (this.classList.contains('plus-btn')) {
                        input.value = currentValue + 1;
                    }

                    // Auto-submit form when quantity changes
                    form.submit();
                });
            });

            // Auto-submit form when input changes manually
            document.querySelectorAll('.cart-update-form input[name="quantity"]').forEach(input => {
                input.addEventListener('change', function () {
                    if (this.value < 1) {
                        this.value = 1;
                    }
                    this.closest('form').submit();
                });
            });
        });
    </script>
@endsection