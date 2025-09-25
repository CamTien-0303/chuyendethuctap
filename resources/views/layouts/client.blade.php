<!DOCTYPE html>
<html lang="en" x-data="{
        darkMode: false,
        initDarkMode() {
            const saved = localStorage.getItem('darkMode');
            const defaultMode = {{ $settings['dark_mode_default'] ? 'true' : 'false' }};
            this.darkMode = saved === 'true' || (saved === null && defaultMode);
            this.applyDarkMode();
        },
        applyDarkMode() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('darkMode', this.darkMode);
        }
    }" x-init="
        initDarkMode();
        $watch('darkMode', () => applyDarkMode());
    " :class="darkMode ? 'dark' : ''">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings['site_name'] ?? 'Flower Shop' }} @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/css/client-dark-mode.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Dark mode initialization script -->
    <script>
        // Initialize dark mode before Alpine.js loads
        (function () {
            const isDarkModeDefault = {{ $settings['dark_mode_default'] ? 'true' : 'false' }};
            const savedDarkMode = localStorage.getItem('darkMode');
            const isDarkMode = savedDarkMode === 'true' || (savedDarkMode === null && isDarkModeDefault);

            if (isDarkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <header class="bg-pink-600 dark:bg-pink-800 text-white shadow-md transition-colors duration-300">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center">
                        <i class="fas fa-flower fa-lg mr-2"></i>
                        {{ $settings['site_name'] ?? 'Flower Shop' }}
                    </a>
                </div>

                <nav class="hidden lg:flex space-x-4 flex-wrap">
                    <a href="{{ route('home') }}" class="hover:text-pink-200 whitespace-nowrap">Trang chủ</a>
                    <a href="{{ route('products.index') }}" class="hover:text-pink-200 whitespace-nowrap">Tất cả hoa</a>
                    @foreach(App\Models\Category::where('is_active', true)->take(4)->get() as $category)
                        <a href="{{ route('products.category', $category) }}"
                            class="hover:text-pink-200 whitespace-nowrap">{{ $category->name }}</a>
                    @endforeach
                </nav>

                <!-- Mobile menu button -->
                <button class="lg:hidden p-2 text-white hover:text-pink-200" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center space-x-2 flex-wrap gap-2">
                    <form action="/products" method="GET" class="hidden md:flex">
                        <input type="text" name="search" placeholder="Tìm kiếm hoa..."
                            class="px-3 py-1 text-black dark:text-white dark:bg-gray-700 dark:border-gray-600 rounded-l-md focus:outline-none">
                        <button type="submit"
                            class="bg-pink-700 dark:bg-pink-900 px-3 py-1 rounded-r-md hover:bg-pink-800 dark:hover:bg-pink-800 transition-colors duration-300">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <!-- Dark mode toggle -->
                    <button @click="darkMode = !darkMode"
                        class="p-2 text-white hover:text-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 rounded-lg transition-all duration-200"
                        title="Chuyển đổi chế độ tối"
                        :aria-label="darkMode ? 'Chuyển sang chế độ sáng' : 'Chuyển sang chế độ tối'">
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <i x-show="!darkMode"
                               x-transition:enter="transition-opacity ease-in duration-200"
                               x-transition:enter-start="opacity-0"
                               x-transition:enter-end="opacity-100"
                               x-transition:leave="transition-opacity ease-out duration-200"
                               x-transition:leave-start="opacity-100"
                               x-transition:leave-end="opacity-0"
                               class="fas fa-moon text-lg absolute"></i>
                            <i x-show="darkMode"
                               x-transition:enter="transition-opacity ease-in duration-200"
                               x-transition:enter-start="opacity-0"
                               x-transition:enter-end="opacity-100"
                               x-transition:leave="transition-opacity ease-out duration-200"
                               x-transition:leave-start="opacity-100"
                               x-transition:leave-end="opacity-0"
                               class="fas fa-sun text-lg text-yellow-300 absolute"></i>
                        </div>
                    </button>

                    <a href="{{ route('cart.index') }}"
                        class="flex items-center hover:text-pink-200 transition-colors duration-200">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="ml-1">
                            @auth
                                {{ App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}
                            @else
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                            @endif
                        </span>
                    </a>

                    <a href="{{ route('wishlist.show') }}"
                        class="flex items-center ml-4 hover:text-pink-200 transition-colors duration-200">
                        <i class="fas fa-heart text-xl"></i>
                    </a>

                    <!-- Auth Links -->
                    @auth
                        <div class="ml-4 relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center hover:text-pink-200 transition-colors duration-200">
                                <i class="fas fa-user text-xl mr-1"></i>
                                {{ auth()->user()->name }}
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('account.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <a href="{{ route('account.orders') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-shopping-bag mr-2"></i>Đơn hàng
                                </a>
                                <a href="{{ route('account.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-edit mr-2"></i>Hồ sơ
                                </a>
                                <form method="POST" action="{{ route('client.logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="ml-4 flex items-center space-x-4">
                            <a href="{{ route('client.login') }}"
                                class="flex items-center hover:text-pink-200 transition-colors duration-200"
                                title="Đăng nhập">
                                <i class="fas fa-sign-in-alt text-xl"></i>
                            </a>
                            <a href="{{ route('client.register') }}"
                                class="flex items-center hover:text-pink-200 transition-colors duration-200"
                                title="Đăng ký">
                                <i class="fas fa-user-plus text-xl"></i>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="lg:hidden hidden bg-pink-700 dark:bg-pink-900 mt-4 rounded-lg">
                <div class="px-4 py-2 space-y-2">
                    <a href="{{ route('home') }}" class="block py-2 hover:text-pink-200">Trang chủ</a>
                    <a href="{{ route('products.index') }}" class="block py-2 hover:text-pink-200">Tất cả hoa</a>
                    @foreach(App\Models\Category::where('is_active', true)->take(4)->get() as $category)
                        <a href="{{ route('products.category', $category) }}" class="block py-2 hover:text-pink-200">{{ $category->name }}</a>
                    @endforeach

                    <!-- Mobile search -->
                    <form action="/products" method="GET" class="mt-4 mb-2">
                        <div class="flex">
                            <input type="text" name="search" placeholder="Tìm kiếm hoa..."
                                class="flex-1 px-3 py-2 text-black dark:text-white dark:bg-gray-700 dark:border-gray-600 rounded-l-md focus:outline-none">
                            <button type="submit"
                                class="bg-pink-800 dark:bg-pink-900 px-3 py-2 rounded-r-md hover:bg-pink-900 dark:hover:bg-pink-800 transition-colors duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen">

        @yield('content')
    </main>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-8 mt-12 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Về chúng tôi</h3>
                    <p class="text-gray-400 dark:text-gray-300">
                        {{ $settings['site_description'] ?? 'Chúng tôi cung cấp hoa tươi đẹp cho mọi dịp. Từ sinh nhật đến đám cưới, hoa của chúng tôi luôn tươi mới và rực rỡ.' }}
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên kết nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">Cửa hàng</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Danh mục</h3>
                    <ul class="space-y-2">
                        @foreach(App\Models\Category::where('is_active', true)->take(5)->get() as $category)
                            <li>
                                <a href="{{ route('products.category', $category) }}"
                                    class="text-gray-400 hover:text-white">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                    <ul class="space-y-2 text-gray-400 dark:text-gray-300">
                        <li class="flex items-center"><i class="fas fa-map-marker-alt w-6"></i>
                            {{ $settings['address'] ?? '123 Đường Hoa, Thành phố' }}
                        </li>
                        <li class="flex items-center"><i class="fas fa-phone w-6"></i>
                            {{ $settings['contact_phone'] ?? '+1 234 567 8901' }}</li>
                        <li class="flex items-center"><i class="fas fa-envelope w-6"></i> {{ $settings['contact_email']
                            ?? 'info@flowershop.com' }}</li>
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-gray-700 dark:border-gray-600 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 dark:text-gray-300">&copy; {{ date('Y') }}
                    {{ $settings['site_name'] ?? 'Flower Shop' }}. Đã đăng ký bản quyền.</p>

                <div class="flex space-x-4 mt-4 md:mt-0">
                    @if($settings['social_media']['facebook'])
                        <a href="{{ $settings['social_media']['facebook'] }}"
                            class="text-gray-400 dark:text-gray-300 hover:text-white transition-colors duration-200"><i
                                class="fab fa-facebook"></i></a>
                    @endif
                    @if($settings['social_media']['instagram'])
                        <a href="{{ $settings['social_media']['instagram'] }}"
                            class="text-gray-400 dark:text-gray-300 hover:text-white transition-colors duration-200"><i
                                class="fab fa-instagram"></i></a>
                    @endif
                    @if($settings['social_media']['twitter'])
                        <a href="{{ $settings['social_media']['twitter'] }}"
                            class="text-gray-400 dark:text-gray-300 hover:text-white transition-colors duration-200"><i
                                class="fab fa-twitter"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

            toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform translate-x-full transition-transform duration-300 ease-in-out`;

            toast.innerHTML = `
                <i class="${icon}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            `;

            container.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Show flash messages as toasts
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    </script>

    @yield('scripts')
</body>

</html>