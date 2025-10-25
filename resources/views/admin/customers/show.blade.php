@extends('layouts.admin')

@section('title', 'Chi tiết khách hàng')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chi tiết khách hàng</h1>
            <div>
                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded mr-2 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.customers.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded dark:bg-gray-700 dark:hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Thông tin khách hàng</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Họ tên:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Email:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $customer->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Số điện thoại:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $customer->phone ?? 'Không có' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Ngày tạo:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $customer->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Địa chỉ</h2>
                <p class="text-gray-800 dark:text-gray-300">{{ $customer->address ?? 'Chưa có địa chỉ' }}</p>
            </div>

            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Đơn hàng</h2>
                @if($customer->orders && $customer->orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Mã đơn</th>
                                    <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Ngày đặt</th>
                                    <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Tổng tiền</th>
                                    <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Trạng thái</th>
                                    <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $order)
                                    <tr class="border-t dark:border-gray-700">
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-300">#{{ $order->id }}</td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-300">
                                            {{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-300">
                                            {{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td class="px-4 py-2">
                                            <span
                                                class="px-2 py-1 rounded text-xs 
                                                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                                                            {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                                                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}
                                                                            {{ !in_array($order->status, ['completed', 'processing', 'cancelled']) ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500">
                                                <i class="fas fa-eye mr-1"></i> Xem
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Không có đơn hàng nào cho khách hàng này.</p>
                @endif
            </div>
        </div>
    </div>
@endsection