@extends('layouts.client')

@section('title', ' - Địa chỉ của tôi')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Địa chỉ của tôi</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('account.dashboard') }}" class="hover:text-pink-600">Tài khoản của tôi</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Địa chỉ</li>
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

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-800">Địa chỉ giao hàng</h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('account.addresses.update') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Địa
                                        chỉ</label>
                                    <input type="text" id="address" name="address"
                                        value="{{ old('address', $user->address) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('address') border-red-500 @enderror"
                                        required>
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Thành phố</label>
                                    <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('city') border-red-500 @enderror"
                                        required>
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Tỉnh/Thành
                                        phố</label>
                                    <input type="text" id="state" name="state" value="{{ old('state', $user->state) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('state') border-red-500 @enderror"
                                        required>
                                    @error('state')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">Mã bưu
                                        điện</label>
                                    <input type="text" id="zip_code" name="zip_code"
                                        value="{{ old('zip_code', $user->zip_code) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('zip_code') border-red-500 @enderror"
                                        required>
                                    @error('zip_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Điện
                                        thoại</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('phone') border-red-500 @enderror"
                                        required>
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <button type="submit"
                                    class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                                    Lưu địa chỉ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection