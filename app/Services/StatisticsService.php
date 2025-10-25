<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsService
{
    /**
     * Get basic counts for dashboard
     */
    public function getBasicCounts()
    {
        return [
            'total_products' => Product::count(),
            'total_customers' => Customer::count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_orders' => Order::count(),
        ];
    }

    /**
     * Get order statistics
     */
    public function getOrderStatistics()
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $yesterday = $now->copy()->subDay()->startOfDay();
        $thisWeek = $now->copy()->startOfWeek();
        $lastWeek = $now->copy()->subWeek()->startOfWeek();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();

        return [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),

            // Today's orders
            'orders_today' => Order::where('created_at', '>=', $today)->count(),
            'orders_yesterday' => Order::whereBetween('created_at', [$yesterday, $today])->count(),

            // Weekly comparisons
            'orders_this_week' => Order::where('created_at', '>=', $thisWeek)->count(),
            'orders_last_week' => Order::whereBetween('created_at', [$lastWeek, $thisWeek])->count(),

            // Monthly comparisons
            'orders_this_month' => Order::where('created_at', '>=', $thisMonth)->count(),
            'orders_last_month' => Order::whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
        ];
    }

    /**
     * Get revenue statistics
     */
    public function getRevenueStatistics()
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $yesterday = $now->copy()->subDay()->startOfDay();
        $thisWeek = $now->copy()->startOfWeek();
        $lastWeek = $now->copy()->subWeek()->startOfWeek();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();

        $validStatuses = ['processing', 'shipped', 'delivered'];

        return [
            'total_revenue' => Order::whereIn('status', $validStatuses)->sum('total_amount'),

            // Today's revenue
            'revenue_today' => Order::whereIn('status', $validStatuses)
                ->where('created_at', '>=', $today)
                ->sum('total_amount'),
            'revenue_yesterday' => Order::whereIn('status', $validStatuses)
                ->whereBetween('created_at', [$yesterday, $today])
                ->sum('total_amount'),

            // Weekly revenue
            'revenue_this_week' => Order::whereIn('status', $validStatuses)
                ->where('created_at', '>=', $thisWeek)
                ->sum('total_amount'),
            'revenue_last_week' => Order::whereIn('status', $validStatuses)
                ->whereBetween('created_at', [$lastWeek, $thisWeek])
                ->sum('total_amount'),

            // Monthly revenue
            'revenue_this_month' => Order::whereIn('status', $validStatuses)
                ->where('created_at', '>=', $thisMonth)
                ->sum('total_amount'),
            'revenue_last_month' => Order::whereIn('status', $validStatuses)
                ->whereBetween('created_at', [$lastMonth, $thisMonth])
                ->sum('total_amount'),
        ];
    }

    /**
     * Get customer growth statistics
     */
    public function getCustomerGrowthStatistics()
    {
        $now = Carbon::now();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();
        $thisWeek = $now->copy()->startOfWeek();
        $lastWeek = $now->copy()->subWeek()->startOfWeek();

        return [
            'customers_this_month' => Customer::where('created_at', '>=', $thisMonth)->count(),
            'customers_last_month' => Customer::whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
            'customers_this_week' => Customer::where('created_at', '>=', $thisWeek)->count(),
            'customers_last_week' => Customer::whereBetween('created_at', [$lastWeek, $thisWeek])->count(),
        ];
    }

    /**
     * Get product statistics
     */
    public function getProductStatistics()
    {
        $now = Carbon::now();
        $thisMonth = $now->copy()->startOfMonth();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();

        return [
            'active_products' => Product::where('is_active', true)->count(),
            'inactive_products' => Product::where('is_active', false)->count(),
            'low_stock_products' => Product::where('stock', '<', 10)->where('is_active', true)->count(),
            'out_of_stock_products' => Product::where('stock', '<=', 0)->where('is_active', true)->count(),
            'products_added_this_month' => Product::where('created_at', '>=', $thisMonth)->count(),
            'products_added_last_month' => Product::whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
        ];
    }

    /**
     * Get sales data for chart (last 7 days)
     */
    public function getSalesChartData($days = 7)
    {
        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        $salesData = Order::whereIn('status', ['processing', 'shipped', 'delivered'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartData = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $dayLabel = $date->format('D'); // Mon, Tue, etc.

            $labels[] = $dayLabel;
            $chartData[] = $salesData->get($dateKey)->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $chartData
        ];
    }

    /**
     * Get top selling products
     */
    public function getTopSellingProducts($limit = 5)
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')
            )
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->orderBy('total_quantity', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Get recent orders
     */
    public function getRecentOrders($limit = 5)
    {
        return Order::with(['customer'])->latest()->take($limit)->get();
    }

    /**
     * Get recent products
     */
    public function getRecentProducts($limit = 5)
    {
        return Product::latest()->take($limit)->get();
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts($threshold = 10, $limit = 5)
    {
        return Product::where('stock', '<', $threshold)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->take($limit)
            ->get();
    }

    /**
     * Calculate percentage change
     */
    public function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Get comprehensive dashboard data
     */
    public function getDashboardData()
    {
        $basicCounts = $this->getBasicCounts();
        $orderStats = $this->getOrderStatistics();
        $revenueStats = $this->getRevenueStatistics();
        $customerGrowth = $this->getCustomerGrowthStatistics();
        $productStats = $this->getProductStatistics();
        $salesChart = $this->getSalesChartData();

        // Calculate percentage changes
        $orderPercentageChange = $this->calculatePercentageChange(
            $orderStats['orders_this_week'],
            $orderStats['orders_last_week']
        );

        $revenuePercentageChange = $this->calculatePercentageChange(
            $revenueStats['revenue_today'],
            $revenueStats['revenue_yesterday']
        );

        $customerPercentageChange = $this->calculatePercentageChange(
            $customerGrowth['customers_this_month'],
            $customerGrowth['customers_last_month']
        );

        $productPercentageChange = $this->calculatePercentageChange(
            $productStats['products_added_this_month'],
            $productStats['products_added_last_month']
        );

        return [
            'basic_counts' => $basicCounts,
            'order_statistics' => $orderStats,
            'revenue_statistics' => $revenueStats,
            'customer_growth' => $customerGrowth,
            'product_statistics' => $productStats,
            'sales_chart' => $salesChart,
            'percentage_changes' => [
                'orders' => $orderPercentageChange,
                'revenue' => $revenuePercentageChange,
                'customers' => $customerPercentageChange,
                'products' => $productPercentageChange,
            ],
            'recent_data' => [
                'orders' => $this->getRecentOrders(),
                'products' => $this->getRecentProducts(),
                'top_selling_products' => $this->getTopSellingProducts(),
                'low_stock_products' => $this->getLowStockProducts(),
            ]
        ];
    }
}