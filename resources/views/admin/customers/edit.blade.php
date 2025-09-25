@extends('layouts.admin')

@section('title', 'Chỉnh sửa khách hàng')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white transition-colors duration-300">Chỉnh sửa khách hàng</h1>
            <a href="{{ route('admin.customers.index') }}"
                class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách khách hàng
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4 transition-colors duration-300">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-colors duration-300">
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Họ và tên *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('name') border-red-500 dark:border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('email') border-red-500 dark:border-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}"
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('phone') border-red-500 dark:border-red-400 @enderror">
                    @error('phone')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Địa chỉ</label>
                    <textarea name="address" id="address" rows="3"
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('address') border-red-500 dark:border-red-400 @enderror">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Mật khẩu (bỏ trống nếu không thay đổi)</label>
                    <input type="password" name="password" id="password"
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('password') border-red-500 dark:border-red-400 @enderror">
                    @error('password')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('password_confirmation') border-red-500 dark:border-red-400 @enderror">
                    @error('password_confirmation')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-pink-600 hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-colors duration-300">
                        <i class="fas fa-save mr-2"></i> Cập nhật khách hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection