@extends('layouts.client')

@section('title', ' - Xác nhận đơn hàng')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Xác nhận đơn hàng</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Xác nhận đơn hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 md:p-12 text-center">
                <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check text-3xl text-green-600"></i>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-2">Cảm ơn bạn!</h2>
                <p class="text-lg text-gray-600 mb-6">Đơn hàng của bạn đã được đặt thành công.</p>

                <div class="mb-8">
                    <p class="text-sm text-gray-500 mb-1">Mã đơn hàng:</p>
                    <p class="text-xl font-semibold text-gray-800 mb-2">#{{ $order->id }}</p>
                    <p class="text-sm text-gray-500">Một email xác nhận đã được gửi tới
                        <strong>{{ $order->email }}</strong>
                    </p>
                </div>

                <div class="flex flex-col md:flex-row justify-center gap-4">
                    <a href="{{ route('orders.show', $order) }}"
                        class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                        Xem chi tiết đơn hàng
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-6 rounded-md transition duration-300">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-6 md:p-12 border-t border-gray-200">
                <div class="max-w-3xl mx-auto">
                    <h3 class="text-xl font-bold mb-4">Tóm tắt đơn hàng</h3>

                    <!-- Order Items -->
                    <div class="mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sản phẩm
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Giá
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Số lượng
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tạm tính
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                alt="{{ $item->product->name }}"
                                                                class="h-10 w-10 object-cover rounded">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->product ? $item->product->name : 'Product not found' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($item->price, 0, ',', '.') }}₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                            Tổng cộng:
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                            {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                </tfoot>
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                        Vận chuyển:
                                    </td>
                                    <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                        @if($order->shipping > 0)
                                            {{ number_format($order->shipping, 0, ',', '.') }}₫
                                        @else
                                            Miễn phí
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right text-base font-bold text-gray-900">
                                        Tổng cộng:
                                    </td>
                                    <td class="px-6 py-3 text-right text-base font-bold text-pink-600">
                                        {{ number_format($order->total, 0, ',', '.') }}₫
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Billing Information -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Thông tin thanh toán</h4>
                            <div class="bg-white border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">{{ $order->customer->name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->customer->address }}</p>
                                <p class="text-sm text-gray-600 mt-2">{{ $order->customer->email }}</p>
                                <p class="text-sm text-gray-600">{{ $order->customer->phone }}</p>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Thông tin đơn hàng</h4>
                            <div class="bg-white border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Ghi chú:</span>
                                    {{ $order->notes ?? 'Không có ghi chú' }}
                                </p>
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Trạng thái:</span>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                        @if($order->status === 'pending') Đang chờ
                                        @elseif($order->status === 'processing') Đang xử lý
                                        @elseif($order->status === 'shipped') Đã giao hàng
                                        @elseif($order->status === 'delivered') Đã nhận hàng
                                        @elseif($order->status === 'cancelled') Đã hủy
                                        @else {{ ucfirst($order->status) }} @endif
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Thông tin đơn hàng</h4>
                            <div class="bg-white border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Ngày đặt hàng:</span>
                                    {{ $order->created_at->format('M d, Y, h:i A') }}
                                </p>
                                @if($order->notes)
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-800">Ghi chú đơn hàng:</p>
                                        <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection