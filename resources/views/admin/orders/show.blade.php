@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Đơn hàng #{{ $order->id }}</h1>
            <div>
                <a href="{{ route('admin.orders.edit', $order->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded mr-2 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded dark:bg-gray-700 dark:hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Sản phẩm trong đơn hàng</h2>
                    </div>
                    <div class="p-4">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-2 text-gray-600 dark:text-gray-300">Sản phẩm</th>
                                    <th class="text-center py-2 text-gray-600 dark:text-gray-300">Số lượng</th>
                                    <th class="text-right py-2 text-gray-600 dark:text-gray-300">Giá</th>
                                    <th class="text-right py-2 text-gray-600 dark:text-gray-300">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product_name }}" class="w-12 h-12 object-cover mr-3 rounded">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 mr-3 rounded"></div>
                                                @endif
                                                <div>
                                                    <p class="font-medium text-gray-800 dark:text-gray-200">
                                                        {{ $item->product_name }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Mã SP:
                                                        {{ $item->product ? $item->product->sku : 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-gray-800 dark:text-gray-300">{{ $item->quantity }}</td>
                                        <td class="text-right text-gray-800 dark:text-gray-300">
                                            {{ number_format($item->price, 0, ',', '.') }}₫</td>
                                        <td class="text-right text-gray-800 dark:text-gray-300">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-b dark:border-gray-700">
                                    <td colspan="3" class="text-right py-3 font-medium text-gray-600 dark:text-gray-400">Tạm
                                        tính:</td>
                                    <td class="text-right py-3 text-gray-800 dark:text-gray-300">
                                        {{ number_format($order->subtotal_amount, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td colspan="3" class="text-right py-3 font-medium text-gray-600 dark:text-gray-400">
                                        Thuế:</td>
                                    <td class="text-right py-3 text-gray-800 dark:text-gray-300">
                                        {{ number_format($order->tax_amount, 0, ',', '.') }}₫</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700">
                                    <td colspan="3" class="text-right py-3 font-medium text-gray-600 dark:text-gray-400">Phí
                                        vận chuyển:</td>
                                    <td class="text-right py-3 text-gray-800 dark:text-gray-300">
                                        {{ number_format($order->shipping_amount, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right py-3 font-semibold text-gray-800 dark:text-gray-200">
                                        Tổng cộng:</td>
                                    <td class="text-right py-3 font-semibold text-gray-800 dark:text-gray-200">
                                        {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white dark:bg-gray-800 rounded shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Thông tin đơn hàng</h2>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Mã đơn hàng:</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">#{{ $order->id }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Ngày tạo:</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Trạng thái:</p>
                            <p>
                                <span
                                    class="px-2 py-1 rounded text-xs 
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                        {{ !in_array($order->status, ['completed', 'processing', 'cancelled']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Phương thức thanh toán:</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                {{ $order->payment_method ?? 'Không rõ' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Trạng thái thanh toán:</p>
                            <p>
                                <span
                                    class="px-2 py-1 rounded text-xs 
                                        {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    {{ ucfirst($order->payment_status ?? 'pending') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Thông tin khách hàng</h2>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Họ tên:</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                {{ $order->customer->name ?? 'Không có' }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Email:</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                {{ $order->customer->email ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Số điện thoại:</p>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                {{ $order->customer->phone ?? 'Không có' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded shadow">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Địa chỉ giao hàng</h2>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-800 dark:text-gray-300">
                            {{ $order->shipping_address ?? $order->customer->address ?? 'Chưa cung cấp địa chỉ' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection