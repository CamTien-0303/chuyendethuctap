@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Đơn Hàng')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chỉnh Sửa Đơn Hàng #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded dark:bg-gray-700 dark:hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>

        @if($errors->any())
            <div
                class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Khách
                            hàng</label>
                        <select name="customer_id" id="customer_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- Chọn khách hàng --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trạng thái
                            đơn hàng</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trạng
                            thái thanh
                            toán</label>
                        <select name="payment_status" id="payment_status"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Chờ thanh toán
                            </option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán
                            </option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền
                            </option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Thất bại
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Địa chỉ
                        giao hàng</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded dark:bg-blue-600 dark:hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i> Cập nhật đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection