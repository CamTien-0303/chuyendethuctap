@extends('layouts.admin')

@section('title', ' - Hồ sơ cá nhân')
@section('page-title', 'Hồ sơ cá nhân')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Hồ sơ cá nhân</h1>
                <p class="text-gray-600 dark:text-gray-400">Quản lý thông tin cá nhân của bạn</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.profile.edit') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh sửa
                </a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin cá nhân</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Xem và quản lý thông tin tài khoản của bạn</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Avatar Section -->
                    <div class="lg:col-span-1">
                        <div class="text-center">
                            <div class="relative inline-block">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                        class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-lg">
                                @else
                                    <div
                                        class="w-32 h-32 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-white dark:border-gray-600 shadow-lg">
                                        <span class="text-white text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div
                                    class="absolute bottom-0 right-0 w-8 h-8 bg-green-500 rounded-full border-2 border-white dark:border-gray-600">
                                </div>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Thông tin cơ bản</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Họ và
                                            tên</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tên
                                            đăng nhập</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->username }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->email }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Số
                                            điện thoại</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $user->phone ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Địa
                                            chỉ</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $user->address ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Status -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Trạng thái tài khoản
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Vai
                                            trò</label>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' }}">
                                            <i
                                                class="fas {{ $user->role === 'admin' ? 'fa-user-shield' : 'fa-user' }} mr-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Trạng
                                            thái email</label>
                                        @if($user->email_verified_at)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Đã xác thực
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Chưa xác thực
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Account Activity -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hoạt động tài khoản
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Ngày
                                            tạo tài khoản</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $user->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Cập
                                            nhật lần cuối</label>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection