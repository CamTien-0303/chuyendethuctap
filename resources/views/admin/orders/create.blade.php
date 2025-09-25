@extends('layouts.admin')

@section('title', 'Tạo Đơn Hàng Mới')
@section('page-title', 'Tạo Đơn Hàng Mới')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tạo Đơn Hàng Mới</h1>
                <p class="text-gray-600 dark:text-gray-400">Thêm một đơn hàng mới vào hệ thống.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 dark:bg-gray-700 dark:hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Quay lại
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin đơn hàng</h2>
            </div>
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <h3 class="text-red-800 dark:text-red-200 font-medium">Có lỗi xảy ra:</h3>
                        </div>
                        <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.orders.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Khách hàng</label>
                            <select name="customer_id" id="customer_id" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                <option value="">-- Chọn khách hàng --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trạng thái</label>
                            <select name="status" id="status" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                <option value="pending" selected>Chờ xử lý</option>
                                <option value="processing">Đang xử lý</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 my-4">Sản phẩm</h3>
                        <div id="order-items-container" class="space-y-4">
                            <!-- Product item will be added here -->
                        </div>
                        <button type="button" id="add-product-btn" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i> Thêm sản phẩm
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Địa chỉ giao hàng</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phương thức thanh toán</label>
                                <select name="payment_method" id="payment_method" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                    <option value="cod" selected>Thanh toán khi nhận hàng (COD)</option>
                                    <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                                </select>
                            </div>
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trạng thái thanh toán</label>
                                <select name="payment_status" id="payment_status" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                                    <option value="pending" selected>Chờ thanh toán</option>
                                    <option value="paid">Đã thanh toán</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i> Tạo đơn hàng
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let productIndex = 0;
        const products = @json($products);

        document.getElementById('add-product-btn').addEventListener('click', function() {
            const container = document.getElementById('order-items-container');
            const itemHtml = `
                <div class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" data-index="${productIndex}">
                    <div class="flex-grow">
                        <select name="items[${productIndex}][product_id]" class="product-select w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors duration-200">
                            <option value="">-- Chọn sản phẩm --</option>
                            ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <input type="number" name="items[${productIndex}][quantity]" min="1" value="1" class="quantity-input w-24 px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-colors duration-200" placeholder="SL">
                    </div>
                    <div class="w-32">
                        <input type="text" name="items[${productIndex}][price]" class="price-input w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white" readonly>
                    </div>
                    <button type="button" class="remove-item-btn text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
            productIndex++;
        });

        document.getElementById('order-items-container').addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const price = selectedOption.dataset.price;
                const itemRow = e.target.closest('.flex');
                itemRow.querySelector('.price-input').value = price ? parseFloat(price).toLocaleString('vi-VN') + '₫' : '';
            }
        });

        document.getElementById('order-items-container').addEventListener('click', function(e) {
            if (e.target.closest('.remove-item-btn')) {
                e.target.closest('.flex').remove();
            }
        });
    });
</script>
@endsection