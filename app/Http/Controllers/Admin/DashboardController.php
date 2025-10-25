<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StatisticsService;

class DashboardController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index()
    {
        // Get comprehensive dashboard data from statistics service
        $dashboardData = $this->statisticsService->getDashboardData();

        // Extract data for the view
        $basicCounts = $dashboardData['basic_counts'];
        $orderStats = $dashboardData['order_statistics'];
        $revenueStats = $dashboardData['revenue_statistics'];
        $customerGrowth = $dashboardData['customer_growth'];
        $productStats = $dashboardData['product_statistics'];
        $percentageChanges = $dashboardData['percentage_changes'];
        $recentData = $dashboardData['recent_data'];
        $salesChart = $dashboardData['sales_chart'];

        // Prepare data for the view
        $totalProducts = $basicCounts['total_products'];
        $totalCustomers = $basicCounts['total_customers'];
        $totalCategories = $basicCounts['total_categories'];
        $totalBrands = $basicCounts['total_brands'];
        $totalOrders = $basicCounts['total_orders'];

        // Order statistics
        $pendingOrders = $orderStats['pending_orders'];
        $processingOrders = $orderStats['processing_orders'];
        $shippedOrders = $orderStats['shipped_orders'];
        $deliveredOrders = $orderStats['delivered_orders'];
        $cancelledOrders = $orderStats['cancelled_orders'];

        // Revenue
        $totalSales = $revenueStats['total_revenue'];
        $revenueToday = $revenueStats['revenue_today'];

        // Recent data
        $latestOrders = $recentData['orders'];
        $latestProducts = $recentData['products'];
        $topSellingProducts = $recentData['top_selling_products'];
        $lowStockProducts = $recentData['low_stock_products'];

        // Calculate growth percentages for display
        $orderGrowthPercentage = $percentageChanges['orders'];
        $customerGrowthPercentage = $percentageChanges['customers'];
        $productGrowthPercentage = $percentageChanges['products'];
        $revenueGrowthPercentage = $percentageChanges['revenue'];

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalCategories',
            'totalBrands',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalSales',
            'revenueToday',
            'latestOrders',
            'latestProducts',
            'topSellingProducts',
            'lowStockProducts',
            'orderGrowthPercentage',
            'customerGrowthPercentage',
            'productGrowthPercentage',
            'revenueGrowthPercentage',
            'salesChart'
        ));
    }
}
