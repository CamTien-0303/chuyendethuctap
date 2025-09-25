@extends('layouts.admin')

@section('title', ' - Tạo danh mục mới')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white transition-colors duration-300">Tạo Danh Mục</h1>
            <a href="{{ route('admin.categories.index') }}"
                class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 transition-colors duration-300">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Tên danh mục *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('name') border-red-500 dark:border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Mô tả</label>
                    <textarea name="description" id="description" rows="4"
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('description') border-red-500 dark:border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Hình ảnh</label>
                    <input type="file" name="image" id="image" class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 dark:file:bg-gray-600 dark:file:text-gray-300 dark:hover:file:bg-gray-500 @error('image') border-red-500 dark:border-red-400 @enderror">
                    @error('image')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="sort_order" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 transition-colors duration-300">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                        class="shadow appearance-none border border-gray-300 dark:border-gray-600 rounded w-full py-2 px-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-white leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300 @error('sort_order') border-red-500 dark:border-red-400 @enderror">
                    @error('sort_order')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="mr-2 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-300">
                        <label for="is_active" class="text-gray-700 dark:text-gray-300 text-sm font-bold transition-colors duration-300">Kích hoạt</label>
                    </div>
                    @error('is_active')
                        <p class="text-red-500 dark:text-red-400 text-xs italic mt-1 transition-colors duration-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-pink-600 hover:bg-pink-700 dark:bg-pink-700 dark:hover:bg-pink-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-colors duration-300">
                        Tạo danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection