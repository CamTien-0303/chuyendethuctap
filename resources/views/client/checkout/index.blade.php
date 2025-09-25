@extends('layouts.client')

@section('title', ' - Thanh toán')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-900 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Thanh toán</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Giỏ hàng</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600 dark:text-pink-400">Thanh toán</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Lỗi!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if($cartItems->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center transition-colors duration-300">
                <div class="text-gray-400 dark:text-gray-500 mb-4">
                    <i class="fas fa-shopping-cart text-6xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-white mb-2">Giỏ hàng của bạn đang trống</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Bạn cần thêm sản phẩm vào giỏ hàng trước khi thanh toán.</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 text-white py-2 px-6 rounded-md transition duration-300">
                    Bắt đầu mua sắm
                </a>
            </div>
        @else
            <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Billing & Shipping Details -->
                    <div class="lg:w-2/3 space-y-6">
                        <!-- Billing Details -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-300">
                            <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">Chi tiết thanh toán</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tên <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="text" 
                                        name="first_name" 
                                        id="first_name" 
                                        value="{{ old('first_name', auth()->check() ? auth()->user()->name : '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('first_name') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('first_name')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Họ <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="text" 
                                        name="last_name" 
                                        id="last_name" 
                                        value="{{ old('last_name', '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('last_name') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('last_name')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        value="{{ old('email', auth()->user() ? auth()->user()->email : '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('email') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('email')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Số điện thoại <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="text" 
                                        name="phone" 
                                        id="phone" 
                                        value="{{ old('phone', '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('phone') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('phone')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Địa chỉ <span class="text-red-600 dark:text-red-400">*</span></label>
                                <input 
                                    type="text" 
                                    name="address" 
                                    id="address" 
                                    value="{{ old('address', '') }}" 
                                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('address') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                    required
                                >
                                @error('address')
                                    <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Thành phố <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="text" 
                                        name="city" 
                                        id="city" 
                                        value="{{ old('city', '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('city') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('city')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tỉnh/Bang <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="text" 
                                        name="state" 
                                        id="state" 
                                        value="{{ old('state', '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('state') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('state')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mã bưu điện <span class="text-red-600 dark:text-red-400">*</span></label>
                                    <input 
                                        type="text" 
                                        name="zip_code" 
                                        id="zip_code" 
                                        value="{{ old('zip_code', '') }}" 
                                        class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400 border {{ $errors->has('zip_code') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}" 
                                        required
                                    >
                                    @error('zip_code')
                                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ghi chú đơn hàng (tùy chọn)</label>
                                <textarea 
                                    name="notes" 
                                    id="notes" 
                                    rows="3" 
                                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md px-3 py-2 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-pink-500 dark:focus:ring-pink-400 focus:border-pink-500 dark:focus:border-pink-400"
                                    placeholder="Ghi chú về đơn hàng của bạn, ví dụ: hướng dẫn giao hàng đặc biệt"
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Different Shipping Address -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 transition-colors duration-300">
                            <div class="flex items-center">
                                <input type="checkbox" id="different_shipping" name="different_shipping" class="h-4 w-4 text-pink-600 dark:text-pink-400 focus:ring-pink-500 dark:focus:ring-pink-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                                <label for="different_shipping" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    Giao hàng đến địa chỉ khác?
                                </label>
                            </div>
                            
                            <div id="shipping_address_container" class="mt-4 hidden">
                                <!-- Add shipping form fields similar to billing but with shipping_ prefix -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_first_name" class="block text-sm font-medium text-gray-700 mb-1">Tên <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_first_name" 
                                            id="shipping_first_name" 
                                            value="{{ old('shipping_first_name') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_last_name" class="block text-sm font-medium text-gray-700 mb-1">Họ <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_last_name" 
                                            id="shipping_last_name" 
                                            value="{{ old('shipping_last_name') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_address" 
                                            id="shipping_address" 
                                            value="{{ old('shipping_address') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">Thành phố <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_city" 
                                            id="shipping_city" 
                                            value="{{ old('shipping_city') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">Tỉnh/Bang <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_state" 
                                            id="shipping_state" 
                                            value="{{ old('shipping_state') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">Mã bưu điện <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_zip_code" 
                                            id="shipping_zip_code" 
                                            value="{{ old('shipping_zip_code') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_phone" 
                                            id="shipping_phone" 
                                            value="{{ old('shipping_phone') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200">Phương thức thanh toán</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_method_cod" 
                                        name="payment_method" 
                                        value="cod" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                                        {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                                    >
                                    <label for="payment_method_cod" class="ml-2 block text-sm text-gray-700">
                                        Thanh toán khi nhận hàng (COD)
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_method_bank" 
                                        name="payment_method" 
                                        value="bank_transfer" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                                        {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                                    >
                                    <label for="payment_method_bank" class="ml-2 block text-sm text-gray-700">
                                        Chuyển khoản ngân hàng
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_method_credit_card" 
                                        name="payment_method" 
                                        value="credit_card" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                                        {{ old('payment_method') === 'credit_card' ? 'checked' : '' }}
                                    >
                                    <label for="payment_method_credit_card" class="ml-2 block text-sm text-gray-700">
                                        Thẻ tín dụng / Thẻ ghi nợ
                                    </label>
                                </div>
                                
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div id="credit_card_details" class="mt-4 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Số thẻ <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_number" 
                                            id="card_number" 
                                            placeholder="1234 5678 9012 3456" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Ngày hết hạn <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_expiry" 
                                            id="card_expiry" 
                                            placeholder="MM/YY" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_cvv" 
                                            id="card_cvv" 
                                            placeholder="123" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Tên trên thẻ <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_name" 
                                            id="card_name" 
                                            placeholder="John Doe" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <div id="bank_transfer_details" class="mt-4 hidden bg-gray-50 p-4 rounded-md">
                                <p class="text-sm text-gray-700">
                                    Vui lòng sử dụng các chi tiết ngân hàng sau để thực hiện thanh toán của bạn:
                                </p>
                                <ul class="list-disc pl-5 mt-2 text-sm text-gray-700 space-y-1">
                                    <li>Ngân hàng: Ngân hàng Quốc gia</li>
                                    <li>Tên tài khoản: Flower Shop Inc.</li>
                                    <li>Số tài khoản: 1234567890</li>
                                    <li>Mã sắp xếp: 12-34-56</li>
                                    <li>Tham chiếu: Số đơn hàng của bạn (sẽ được cung cấp sau khi thanh toán)</li>
                                </ul>
                                <p class="text-sm text-gray-700 mt-2">
                                    Đơn hàng của bạn sẽ không được vận chuyển cho đến khi tiền đã được ghi có vào tài khoản của chúng tôi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 sticky top-6 transition-colors duration-300">
                            <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">Tóm tắt đơn hàng</h2>
                            
                            <div class="mb-4">
                                <div class="max-h-60 overflow-y-auto">
                                    @foreach($cartItems as $item)
                                        <div class="flex py-2 border-b border-gray-100 dark:border-gray-700">
                                            <div class="flex-shrink-0 w-16 h-16 border border-gray-200 dark:border-gray-700 rounded-md overflow-hidden">
                                                @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                                                    <i class="fas fa-image text-gray-400 dark:text-gray-500"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <h3 class="text-sm font-medium text-gray-700">{{ $item->product->name }}</h3>
                                                <p class="text-xs text-gray-500 mt-1">Số lượng: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-700">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Tổng phụ</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($discount > 0)
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Giảm giá</span>
                                    <span>-${{ number_format($discount, 2) }}</span>
                                </div>
                                @endif
                                
                                @if($tax > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Thuế ({{ $taxRate * 100 }}%)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($tax, 2) }}</span>
                                </div>
                                @endif
                                
                                @if($shipping > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Vận chuyển</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($shipping, 2) }}</span>
                                </div>
                                @else
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span>Vận chuyển</span>
                                    <span>Miễn phí</span>
                                </div>
                                @endif
                                
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Tổng cộng</span>
                                    <span class="text-lg font-bold text-pink-600 dark:text-pink-400">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="terms_accepted" name="terms_accepted" class="h-4 w-4 text-pink-600 dark:text-pink-400 focus:ring-pink-500 dark:focus:ring-pink-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700" required>
                                    <label for="terms_accepted" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Tôi đã đọc và đồng ý với <a href="#" class="text-pink-600 hover:text-pink-700 dark:text-pink-400 dark:hover:text-pink-300">các điều khoản và điều kiện</a> <span class="text-red-600 dark:text-red-400">*</span>
                                    </label>
                                </div>
                                @error('terms_accepted')
                                    <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 text-white text-center py-3 px-4 rounded-md transition duration-300">
                                Đặt hàng
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle different shipping address form
        const differentShippingCheckbox = document.getElementById('different_shipping');
        const shippingAddressContainer = document.getElementById('shipping_address_container');
        
        differentShippingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                shippingAddressContainer.classList.remove('hidden');
            } else {
                shippingAddressContainer.classList.add('hidden');
            }
        });
        
        // Toggle payment method details
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardDetails = document.getElementById('credit_card_details');
        const bankTransferDetails = document.getElementById('bank_transfer_details');
        
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardDetails.classList.remove('hidden');
                    bankTransferDetails.classList.add('hidden');
                } else if (this.value === 'bank_transfer') {
                    bankTransferDetails.classList.remove('hidden');
                    creditCardDetails.classList.add('hidden');
                } else {
                    creditCardDetails.classList.add('hidden');
                    bankTransferDetails.classList.add('hidden');
                }
            });
        });
        
        // Initialize correct state based on default selection
        paymentMethods.forEach(method => {
            if (method.checked) {
                if (method.value === 'credit_card') {
                    creditCardDetails.classList.remove('hidden');
                } else if (method.value === 'bank_transfer') {
                    bankTransferDetails.classList.remove('hidden');
                }
            }
        });
    });
</script>
@endsection
