@extends('layouts.client')

@section('title', ' - Chỉnh sửa hồ sơ')

@section('content')


    <div class="flex items-center justify-end mt-6">
        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
            Lưu thay đổi
        </button>
    </div>
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Chỉnh sửa hồ sơ</h1>
        <nav class="text-sm text-gray-500">
            <ol class="list-none p-0 flex flex-wrap">
                <li><a href="{{ route('home') }}" class="hover:text-pink-600">Trang chủ</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('account.dashboard') }}" class="hover:text-pink-600">Tài khoản của tôi</a></li>
                <li class="mx-2">/</li>
                <li class="text-pink-600">Chỉnh sửa hồ sơ</li>
            </ol>
        </nav>
    </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Account Sidebar -->
            @include('client.account.partials.sidebar')

            <!-- Main Content -->
            <div class="lg:w-3/4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                        role="alert">
                        <strong class="font-bold">Thành công!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">Lỗi!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-800">Thông tin hồ sơ</h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('account.profile.update') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('name') border-red-500 @enderror"
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ
                                    Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('email') border-red-500 @enderror"
                                    required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="border-t border-gray-200 pt-4 mt-6">
                                <h3 class="text-lg font-medium text-gray-800 mb-4">Đổi mật khẩu</h3>
                                <p class="text-sm text-gray-600 mb-4">Để trống các trường mật khẩu nếu bạn không muốn
                                    thay đổi mật khẩu.</p>

                                <div class="mb-4">
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mật
                                        khẩu hiện tại</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('current_password') border-red-500 @enderror">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu
                                        mới</label>
                                    <input type="password" id="password" name="password"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu
                                        mới</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500">
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <button type="submit"
                                    class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection