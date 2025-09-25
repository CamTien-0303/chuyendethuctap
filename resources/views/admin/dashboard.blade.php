@extends('layouts.admin')

@section('title', ' - Bảng điều khiển')
@section('page-title', 'Bảng điều khiển')

@section('content')
<div class="space-y-6">
    <!-- Welcome section -->
    <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Chào mừng trở lại, {{ auth()->user()->name }}!</h1>
                <p class="text-pink-100">Đây là tổng quan về cửa hàng hoa của bạn hôm nay</p>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 text-white">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tổng số sản phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProducts }}</h3>
                    <p class="text-xs {{ $productGrowthPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mt-1">
                        <i class="fas fa-arrow-{{ $productGrowthPercentage >= 0 ? 'up' : 'down' }} mr-1"></i>{{ abs($productGrowthPercentage) }}% so với tháng trước
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-green-400 to-green-600 text-white">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Đơn hàng mới</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $latestOrders->count() }}</h3>
                    <p class="text-xs {{ $orderGrowthPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mt-1">
                        <i class="fas fa-arrow-{{ $orderGrowthPercentage >= 0 ? 'up' : 'down' }} mr-1"></i>{{ abs($orderGrowthPercentage) }}% so với tuần trước
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-pink-400 to-pink-600 text-white">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tổng số khách hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCustomers }}</h3>
                    <p class="text-xs {{ $customerGrowthPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mt-1">
                        <i class="fas fa-arrow-{{ $customerGrowthPercentage >= 0 ? 'up' : 'down' }} mr-1"></i>{{ abs($customerGrowthPercentage) }}% so với tháng trước
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600 text-white">
                    <i class="fas fa-list text-2xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tổng số danh mục</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCategories }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-minus mr-1"></i>Không thay đổi
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and tables section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sales chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Doanh thu 7 ngày qua</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-full">7 ngày</button>
                    <button class="px-3 py-1 text-xs text-gray-500 hover:bg-gray-100 rounded-full">30 ngày</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Quick stats -->
        <div class="space-y-6">
            <!-- Revenue card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Doanh thu hôm nay</h3>
                    <i class="fas fa-dollar-sign text-green-500"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ number_format($revenueToday, 0) }}₫</div>
                <p class="text-sm {{ $revenueGrowthPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    <i class="fas fa-arrow-{{ $revenueGrowthPercentage >= 0 ? 'up' : 'down' }} mr-1"></i>{{ abs($revenueGrowthPercentage) }}% so với hôm qua
                </p>
            </div>

            <!-- Top selling product -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sản phẩm bán chạy nhất</h3>
                @if($latestProducts->first())
                <div class="flex items-center">
                    @if($latestProducts->first()->image)
                    <img src="{{ asset('storage/' . $latestProducts->first()->image) }}" 
                         alt="{{ $latestProducts->first()->name }}" 
                         class="w-12 h-12 rounded-lg object-cover">
                    @else
                    <div class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400"></i>
                    </div>
                    @endif
                    <div class="ml-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $latestProducts->first()->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($latestProducts->first()->price, 0) }}₫</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Thao tác nhanh</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.create') }}" 
                       class="flex items-center w-full px-4 py-3 text-sm text-pink-600 dark:text-pink-400 bg-pink-50 dark:bg-pink-900/20 rounded-lg hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-colors duration-200">
                        <i class="fas fa-plus mr-3"></i>
                        Thêm sản phẩm mới
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center w-full px-4 py-3 text-sm text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        Xem đơn hàng
                    </a>
                    <a href="{{ route('admin.customers.index') }}" 
                       class="flex items-center w-full px-4 py-3 text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200">
                        <i class="fas fa-users mr-3"></i>
                        Quản lý khách hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent products and orders tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Latest products -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Sản phẩm mới nhất</h2>
                    <a href="{{ route('admin.products.index') }}" 
                       class="text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-medium">
                        Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Giá</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($latestProducts as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="h-12 w-12 rounded-lg object-cover">
                                    @else
                                    <div class="h-12 w-12 rounded-lg bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $product->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($product->price, 0) }}₫</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Hoạt động
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400 rounded-full">
                                    <i class="fas fa-times-circle mr-1"></i>Tạm dừng
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Latest orders -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Đơn hàng mới nhất</h2>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="text-sm text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-medium">
                        Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Đơn hàng</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tổng tiền</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($latestOrders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">#{{ $order->id }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->customer->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($order->total_amount, 0) }}₫</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($order->status)
                                    @case('pending')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400 rounded-full">
                                            <i class="fas fa-clock mr-1"></i>Đang chờ
                                        </span>
                                        @break
                                    @case('processing')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 rounded-full">
                                            <i class="fas fa-cog mr-1"></i>Đang xử lý
                                        </span>
                                        @break
                                    @case('shipped')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400 rounded-full">
                                            <i class="fas fa-shipping-fast mr-1"></i>Đã giao hàng
                                        </span>
                                        @break
                                    @case('delivered')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i>Đã nhận hàng
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400 rounded-full">
                                            <i class="fas fa-times-circle mr-1"></i>Đã hủy
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full">
                                            {{ $order->status }}
                                        </span>
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChart['labels']),
            datasets: [{
                label: 'Doanh thu',
                data: @json($salesChart['data']),
                borderColor: 'rgb(236, 72, 153)',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(236, 72, 153)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND',
                                minimumFractionDigits: 0
                            }).format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endsection
