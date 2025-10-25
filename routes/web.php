<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\WishlistController;
use App\Http\Controllers\Client\AuthController as ClientAuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Health check endpoint for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => date('Y-m-d H:i:s'),
        'service' => 'Laravel Flower Shop',
        'php_version' => PHP_VERSION
    ], 200);
});

// Test route without middleware
Route::get('/test-home', function () {
    return response()->json([
        'status' => 'Laravel Test',
        'message' => 'Framework working without middleware',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
});

// Test HomeController without middleware
Route::get('/test-controller', [HomeController::class, 'index']);

// Client Routes
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('client.only');

// Product Routes
Route::get('/products', [ClientProductController::class, 'index'])->name('products.index')->middleware('client.only');
Route::get('/products/category/{category}', [ClientProductController::class, 'category'])->name('products.category')->middleware('client.only');
Route::get('/products/brand/{brand}', [ClientProductController::class, 'brand'])->name('products.brand')->middleware('client.only');
Route::get('/products/{product}', [ClientProductController::class, 'show'])->name('products.show')->middleware('client.only');
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search')->middleware('client.only');

// Wishlist Public Route
Route::get('/wishlist', [WishlistController::class, 'show'])->name('wishlist.show')->middleware('client.only');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('client.only');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add')->middleware('client.only');
Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update')->middleware('client.only');
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove')->middleware('client.only');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear')->middleware('client.only');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon')->middleware('client.only');

// Checkout Routes
// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware(['client.auth', 'client.only']);
Route::post('/orders', [CheckoutController::class, 'store'])->name('orders.store')->middleware(['client.auth', 'client.only']);

// Order Routes (Protected by auth middleware)
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware(['client.auth', 'client.only']);
Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware(['client.auth', 'client.only']);

// Account Routes (Protected by auth middleware)
Route::prefix('account')->middleware(['client.auth', 'client.only'])->group(function () {
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/addresses', [AccountController::class, 'updateAddresses'])->name('account.addresses.update');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('account.wishlist');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{wishlistItem}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Order Confirmation (Public but requires order ID)
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation')->middleware('client.only');

// Auth Routes
Route::get('/register', [ClientAuthController::class, 'registerForm'])->name('client.register')->middleware('client.only');
Route::post('/register', [ClientAuthController::class, 'register'])->middleware('client.only');

Route::get('/login', [ClientAuthController::class, 'loginForm'])->name('client.login')->middleware('client.only');
Route::post('/login', [ClientAuthController::class, 'login'])->middleware('client.only');
Route::post('/logout', [ClientAuthController::class, 'logout'])->name('client.logout');

// Admin Auth Routes  
Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::prefix('ad')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Categories
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Brands
    Route::resource('brands', BrandController::class)->names([
        'index' => 'admin.brands.index',
        'create' => 'admin.brands.create',
        'store' => 'admin.brands.store',
        'show' => 'admin.brands.show',
        'edit' => 'admin.brands.edit',
        'update' => 'admin.brands.update',
        'destroy' => 'admin.brands.destroy',
    ]);

    // Products
    Route::resource('products', AdminProductController::class)->names([
        'test' => 'admin.products.test',
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);

    // Additional Product Routes
    Route::get('products/export', [AdminProductController::class, 'export'])->name('admin.products.export');
    Route::post('products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('admin.products.bulk-action');

    // Users
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Customers
    Route::resource('customers', CustomerController::class)->names([
        'index' => 'admin.customers.index',
        'create' => 'admin.customers.create',
        'store' => 'admin.customers.store',
        'show' => 'admin.customers.show',
        'edit' => 'admin.customers.edit',
        'update' => 'admin.customers.update',
        'destroy' => 'admin.customers.destroy',
    ]);

    // Orders
    Route::resource('orders', AdminOrderController::class)->names([
        'index' => 'admin.orders.index',
        'create' => 'admin.orders.create',
        'store' => 'admin.orders.store',
        'show' => 'admin.orders.show',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy',
    ]);

    // Order Items
    Route::resource('order-items', OrderItemController::class)->names([
        'index' => 'admin.order-items.index',
        'create' => 'admin.order-items.create',
        'store' => 'admin.order-items.store',
        'show' => 'admin.order-items.show',
        'edit' => 'admin.order-items.edit',
        'update' => 'admin.order-items.update',
        'destroy' => 'admin.order-items.destroy',
    ]);

    // Banners
    Route::resource('banners', BannerController::class)->names([
        'index' => 'admin.banners.index',
        'create' => 'admin.banners.create',
        'store' => 'admin.banners.store',
        'show' => 'admin.banners.show',
        'edit' => 'admin.banners.edit',
        'update' => 'admin.banners.update',
        'destroy' => 'admin.banners.destroy',
    ]);

    // Profile Routes
    Route::get('profile', [ProfileController::class, 'show'])->name('admin.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');

    // Settings Routes
    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::put('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('admin.settings.clear-cache');
    Route::post('settings/reset', [SettingsController::class, 'resetToDefaults'])->name('admin.settings.reset');
});

// API Routes for Statistics
Route::prefix('api')->name('api.')->group(function () {
    Route::prefix('statistics')->name('statistics.')->group(function () {
        Route::get('basic-counts', [App\Http\Controllers\Api\StatisticsController::class, 'getBasicCounts'])->name('basic-counts');
        Route::get('orders', [App\Http\Controllers\Api\StatisticsController::class, 'getOrderStatistics'])->name('orders');
        Route::get('revenue', [App\Http\Controllers\Api\StatisticsController::class, 'getRevenueStatistics'])->name('revenue');
        Route::get('customers', [App\Http\Controllers\Api\StatisticsController::class, 'getCustomerGrowthStatistics'])->name('customers');
        Route::get('products', [App\Http\Controllers\Api\StatisticsController::class, 'getProductStatistics'])->name('products');
        Route::get('sales-chart', [App\Http\Controllers\Api\StatisticsController::class, 'getSalesChartData'])->name('sales-chart');
        Route::get('top-selling', [App\Http\Controllers\Api\StatisticsController::class, 'getTopSellingProducts'])->name('top-selling');
        Route::get('dashboard-data', [App\Http\Controllers\Api\StatisticsController::class, 'getDashboardData'])->name('dashboard-data');
        Route::get('recent-data', [App\Http\Controllers\Api\StatisticsController::class, 'getRecentData'])->name('recent-data');
    });
});
