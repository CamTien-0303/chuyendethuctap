@extends('layouts.client')

@section('title', ' - Đơn hàng #' . $order->id)

@section('content')
    <div class="bg-gray-100 dark:bg-gray-800 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Đơn hàng #{{ $order->id }}</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('account.orders') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Đơn hàng của tôi</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600 dark:text-pink-400">Đơn hàng #{{ $order->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Order Status -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6 transition-colors duration-300">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Đơn hàng #{{ $order->id }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Đặt vào {{ $order->created_at->format('d/m/Y, H:i') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                            {{ $order->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200' : '' }}
                            {{ $order->status === 'processing' ? 'bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200' : '' }}
                            {{ $order->status === 'completed' ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200' : '' }}
                        ">
                        <i class="fas
                            {{ $order->status === 'pending' ? 'fa-clock' : '' }}
                            {{ $order->status === 'processing' ? 'fa-cog fa-spin' : '' }}
                            {{ $order->status === 'completed' ? 'fa-check-circle' : '' }}
                            {{ $order->status === 'cancelled' ? 'fa-times-circle' : '' }}
                            mr-2"></i>
                        @if($order->status === 'pending')
                            Chờ xử lý
                        @elseif($order->status === 'processing')
                            Đang xử lý
                        @elseif($order->status === 'completed')
                            Hoàn thành
                        @elseif($order->status === 'cancelled')
                            Đã hủy
                        @else
                            {{ ucfirst($order->status) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Order Items -->
            <div class="lg:w-2/3">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6 transition-colors duration-300">
                    <h3 class="bg-gray-50 dark:bg-gray-700 px-6 py-3 text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-300">Sản phẩm đã đặt</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Sản phẩm
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Giá
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Số lượng
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Tổng
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                                            alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded">
                                                    @else
                                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $item->product ? $item->product->name : 'Sản phẩm không tìm thấy' }}
                                                    </div>
                                                    @if($item->product)
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                            SKU: {{ $item->product->sku ?? 'N/A' }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ number_format($item->price, 0, ',', '.') }}₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right font-medium">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Tracking -->
                @if($order->status !== 'cancelled' && $order->status !== 'pending')
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6 transition-colors duration-300">
                        <h3 class="bg-gray-50 dark:bg-gray-700 px-6 py-3 text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-300">Theo dõi đơn hàng</h3>

                        <div class="p-6">
                            <div class="relative">
                                <!-- Track line -->
                                <div class="absolute top-0 left-5 ml-px border-l-2 border-gray-200 dark:border-gray-600 h-full"></div>

                                <!-- Order placed -->
                                <div class="relative flex items-start mb-8">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-600 dark:bg-pink-700 text-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Đã đặt hàng</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('d/m/Y, H:i') }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Đơn hàng của bạn đã được tiếp nhận</p>
                                    </div>
                                </div>

                                <!-- Processing -->
                                <div class="relative flex items-start mb-8">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full
                                            {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'bg-pink-600 dark:bg-pink-700 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-400' }}">
                                        <i class="fas fa-cog{{ in_array($order->status, ['processing', 'shipped', 'completed']) ? ' fa-spin' : '' }}"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Đang xử lý</h4>
                                        @if($order->processing_at)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->processing_at->format('d/m/Y, H:i') }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Đơn hàng của bạn đang được xử lý</p>
                                        @else
                                            <p class="text-sm text-gray-400 dark:text-gray-500">Chờ xử lý</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Shipped -->
                                <div class="relative flex items-start mb-8">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full
                                            {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-pink-600 dark:bg-pink-700 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-400' }}">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Đã gửi hàng</h4>
                                        @if($order->shipped_at)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->shipped_at->format('d/m/Y, H:i') }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Đơn hàng của bạn đã được gửi đi</p>
                                            @if($order->tracking_number)
                                                <p class="text-sm font-medium mt-1 text-gray-900 dark:text-white">Mã vận đơn: {{ $order->tracking_number }}</p>
                                            @endif
                                        @else
                                            <p class="text-sm text-gray-400 dark:text-gray-500">Chờ xử lý</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Delivered -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full
                                            {{ $order->status === 'completed' ? 'bg-pink-600 dark:bg-pink-700 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-400' }}">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Đã giao hàng</h4>
                                        @if($order->completed_at)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->completed_at->format('d/m/Y, H:i') }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Đơn hàng của bạn đã được giao thành công</p>
                                        @else
                                            <p class="text-sm text-gray-400 dark:text-gray-500">Chờ xử lý</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:w-1/3">
                <!-- Order Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6 transition-colors duration-300">
                    <h3 class="bg-gray-50 dark:bg-gray-700 px-6 py-3 text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-300">Tổng kết đơn hàng</h3>

                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tổng tiền hàng</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Phí vận chuyển</span>
                                <span class="text-gray-900 dark:text-white font-medium">
                                    @if(isset($order->shipping) && $order->shipping > 0)
                                        {{ number_format($order->shipping, 0, ',', '.') }}₫
                                    @else
                                        <span class="text-green-600 dark:text-green-400">Miễn phí</span>
                                    @endif
                                </span>
                            </div>

                            <div class="pt-3 border-t border-gray-200 dark:border-gray-600 flex justify-between">
                                <span class="font-bold text-lg text-gray-900 dark:text-white">Tổng cộng</span>
                                <span class="font-bold text-lg text-pink-600 dark:text-pink-400">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6 transition-colors duration-300">
                    <h3 class="bg-gray-50 dark:bg-gray-700 px-6 py-3 text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-300">Địa chỉ nhận hàng</h3>

                    <div class="p-6">
                        <address class="not-italic space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-400 w-5 mr-3"></i>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $order->customer->name }}</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-3 mt-1"></i>
                                <p class="text-gray-600 dark:text-gray-400">{{ $order->customer->address }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 w-5 mr-3"></i>
                                <p class="text-gray-600 dark:text-gray-400">{{ $order->customer->email }}</p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 w-5 mr-3"></i>
                                <p class="text-gray-600 dark:text-gray-400">{{ $order->customer->phone }}</p>
                            </div>
                        </address>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-colors duration-300">
                    <h3 class="bg-gray-50 dark:bg-gray-700 px-6 py-3 text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-300">Thông tin thanh toán</h3>

                    <div class="p-6 space-y-4">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-900 dark:text-white mr-2">Phương thức:</span>
                            <span class="text-gray-600 dark:text-gray-400">
                                @if($order->payment_method === 'cod')
                                    Thanh toán khi nhận hàng
                                @elseif($order->payment_method === 'bank_transfer')
                                    Chuyển khoản ngân hàng
                                @elseif($order->payment_method === 'credit_card')
                                    Thẻ tín dụng
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center">
                            <span class="font-medium text-gray-900 dark:text-white mr-2">Trạng thái:</span>
                            <span
                                class="px-3 py-1 text-sm rounded-full font-medium
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200' : 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200' }}">
                                @if($order->payment_status === 'paid')
                                    <i class="fas fa-check-circle mr-1"></i>Đã thanh toán
                                @else
                                    <i class="fas fa-clock mr-1"></i>Chưa thanh toán
                                @endif
                            </span>
                        </div>

                        @if($order->payment_method === 'bank_transfer' && $order->payment_status !== 'paid')
                            <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                                <h4 class="font-medium text-blue-800 dark:text-blue-200 flex items-center">
                                    <i class="fas fa-university mr-2"></i>Thông tin chuyển khoản
                                </h4>
                                <ul class="mt-3 text-sm text-blue-700 dark:text-blue-300 space-y-2">
                                    <li><strong>Ngân hàng:</strong> Vietcombank</li>
                                    <li><strong>Tên tài khoản:</strong> Cửa hàng hoa</li>
                                    <li><strong>Số tài khoản:</strong> 1234567890</li>
                                    <li><strong>Nội dung:</strong> Đơn hàng #{{ $order->id }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('account.orders') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition duration-300 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại đơn hàng của tôi
            </a>

            @if($order->status !== 'cancelled' && $order->status !== 'completed')
                <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg transition duration-300 font-medium">
                        <i class="fas fa-times-circle mr-2"></i> Hủy đơn hàng
                    </button>
                </form>
            @endif

            <a href="#" onclick="window.print()"
                class="inline-flex items-center justify-center px-6 py-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg transition duration-300 font-medium">
                <i class="fas fa-print mr-2"></i> In đơn hàng
            </a>
        </div>
    </div>
@endsection