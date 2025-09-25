@extends('layouts.admin')

@section('title', 'Quản lý Thương hiệu')
@section('page-title', 'Quản lý Thương hiệu')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Quản lý Thương hiệu</h1>
                <p class="text-gray-600 dark:text-gray-400">Xem, tìm kiếm và quản lý tất cả các thương hiệu.</p>
            </div>
            <a href="{{ route('admin.brands.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tạo thương hiệu mới
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <form method="GET" action="{{ route('admin.brands.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tìm kiếm</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Tên thương hiệu, website..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trạng thái</label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                <div></div>
                <div class="flex items-end gap-2 justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i> Tìm kiếm
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.brands.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i> Xóa
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 text-green-700 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">
                            <a href="{{ route('admin.brands.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-40"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-4 text-left">Logo</th>
                        <th class="py-3 px-4 text-left">
                            <a href="{{ route('admin.brands.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                Tên
                                @if(request('sort') == 'name')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-40"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-4 text-left">Website</th>
                        <th class="py-3 px-4 text-left">
                            <a href="{{ route('admin.brands.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => request('sort') == 'is_active' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                Trạng thái
                                @if(request('sort') == 'is_active')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-40"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-4 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200 text-sm font-light">
                    @forelse($brands as $brand)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                            <td class="py-3 px-4 text-left whitespace-nowrap">#{{ $brand->id }}</td>
                            <td class="py-3 px-4 text-left">
                                @if($brand->image)
                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                        class="h-10 w-10 rounded-full object-cover"
                                        onerror="this.onerror=null; this.src='{{ asset('storage/brands/default.png') }}'; this.classList.add('img-error')">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center dark:bg-gray-700">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-left">{{ $brand->name }}</td>
                            <td class="py-3 px-4 text-left">
                                @if($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank" class="text-blue-500 hover:underline">
                                        {{ Str::limit($brand->website, 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Không có website</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-left">
                                <span class="px-2 py-1 rounded-full text-xs
                                @if($brand->is_active) bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                                @endif">
                                    {{ $brand->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex item-center justify-center space-x-3">
                                    <a href="{{ route('admin.brands.show', $brand->id) }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition-transform duration-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="text-yellow-500 hover:text-yellow-700 transform hover:scale-110 transition-transform duration-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="inline-block" action="{{ route('admin.brands.destroy', $brand->id) }}"
                                        method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa thương hiệu này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transform hover:scale-110 transition-transform duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">Không có thương hiệu nào được tìm thấy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $brands->links() }}
        </div>
    </div>
@endsection