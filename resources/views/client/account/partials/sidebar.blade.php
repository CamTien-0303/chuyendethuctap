<div class="lg:w-1/4 mb-6 lg:mb-0">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-colors duration-300">
        <!-- User Info -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div
                    class="flex-shrink-0 h-12 w-12 rounded-full bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center">
                    <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-3">
            <nav class="space-y-1">
                <a href="{{ route('account.dashboard') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.dashboard') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span class="ml-2">Bảng điều khiển</span>
                    </div>
                </a>

                <a href="{{ route('account.orders') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.orders') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-bag w-5 h-5"></i>
                        <span class="ml-2">Đơn hàng của tôi</span>
                    </div>
                </a>

                <a href="{{ route('account.profile') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.profile') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fas fa-user w-5 h-5"></i>
                        <span class="ml-2">Hồ sơ</span>
                    </div>
                </a>

                <a href="{{ route('account.addresses') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.addresses') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt w-5 h-5"></i>
                        <span class="ml-2">Địa chỉ</span>
                    </div>
                </a>

                <a href="{{ route('account.wishlist') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.wishlist') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fas fa-heart w-5 h-5"></i>
                        <span class="ml-2">Yêu thích</span>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-sign-out-alt w-5 h-5"></i>
                            <span class="ml-2">Đăng xuất</span>
                        </div>
                    </button>
                </form>
            </nav>
        </div>
    </div>
</div>