@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')
@section('page-title', 'Quản lý Người dùng')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Quản lý Người dùng</h1>
                <p class="text-gray-600 dark:text-gray-400">Xem, tìm kiếm và quản lý tất cả các người dùng.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tạo người dùng mới
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tìm kiếm</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Tên, tên đăng nhập, email..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vai trò</label>
                    <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="">Tất cả</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                    </select>
                </div>
                <div></div>
                <div class="flex items-end gap-2 justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i> Tìm kiếm
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
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
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-40"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-4 text-left">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                Họ tên
                                @if(request('sort') == 'name')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-40"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-4 text-left">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                Email
                                @if(request('sort') == 'email')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-40"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-4 text-left">
                            Vai trò
                        </th>
                        <th class="py-3 px-4 text-left">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-900 dark:hover:text-white">
                                Ngày tạo
                                @if(request('sort') == 'created_at')
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
                    @forelse($users as $user)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                            <td class="py-3 px-4 text-left whitespace-nowrap">#{{ $user->id }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-left">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-left">
                                <span class="px-2 py-1 rounded-full text-xs
                                @if($user->role === 'admin') bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300
                                @else bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                                @endif">
                                    {{ $user->role === 'admin' ? 'Quản trị viên' : 'Người dùng' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-left">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex item-center justify-center space-x-3">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition-transform duration-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700 transform hover:scale-110 transition-transform duration-200">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="inline-block" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này không?');">
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
                            <td colspan="6" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">Không có người dùng nào được tìm thấy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection