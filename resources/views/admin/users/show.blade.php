@extends('layouts.admin')

@section('title', ' - Xem người dùng')
@section('page-title', 'Chi tiết người dùng')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chi tiết người dùng: {{ $user->name }}</h1>
            <div>
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Thông tin người dùng</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">ID</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->id }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Tên</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Tên đăng nhập</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->username }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Email</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Vai trò</p>
                            @if($user->role === 'admin')
                                <span
                                    class="bg-purple-200 text-purple-800 dark:bg-purple-900 dark:text-purple-300 py-1 px-3 rounded-full text-xs font-medium">Quản
                                    trị viên</span>
                            @else
                                <span
                                    class="bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-300 py-1 px-3 rounded-full text-xs font-medium">Người
                                    dùng</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Thời gian hoạt động</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Tạo tài khoản</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Cập nhật lần cuối</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($user->email_verified_at)
                            <div class="mb-4">
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Email đã xác minh</p>
                                <p class="font-medium text-green-600 dark:text-green-400">
                                    {{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @else
                            <div class="mb-4">
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Xác minh Email</p>
                                <span
                                    class="bg-yellow-200 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 py-1 px-3 rounded-full text-xs font-medium">Chưa
                                    xác minh</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection