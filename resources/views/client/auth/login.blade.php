@extends('layouts.client')

@section('title', ' - Đăng nhập')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-800 py-6 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Đăng nhập</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600 dark:hover:text-pink-400">Trang chủ</a>
                    </li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600 dark:text-pink-400">Đăng nhập</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-colors duration-300">
            <form method="POST" action="{{ route('client.login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Địa chỉ email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 dark:focus:ring-pink-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mật khẩu
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 dark:focus:ring-pink-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full bg-pink-600 hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                        Đăng nhập
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Chưa có tài khoản?
                        <a href="{{ route('client.register') }}"
                            class="text-pink-600 dark:text-pink-400 hover:text-pink-800 dark:hover:text-pink-300 font-medium">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection