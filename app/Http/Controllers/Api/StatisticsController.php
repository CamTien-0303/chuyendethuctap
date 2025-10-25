<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Get basic counts for dashboard
     */
    public function getBasicCounts()
    {
        $data = $this->statisticsService->getBasicCounts();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get order statistics
     */
    public function getOrderStatistics()
    {
        $data = $this->statisticsService->getOrderStatistics();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get revenue statistics
     */
    public function getRevenueStatistics()
    {
        $data = $this->statisticsService->getRevenueStatistics();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get customer growth statistics
     */
    public function getCustomerGrowthStatistics()
    {
        $data = $this->statisticsService->getCustomerGrowthStatistics();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get product statistics
     */
    public function getProductStatistics()
    {
        $data = $this->statisticsService->getProductStatistics();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get sales chart data
     */
    public function getSalesChartData(Request $request)
    {
        $days = $request->get('days', 7);
        $data = $this->statisticsService->getSalesChartData($days);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get top selling products
     */
    public function getTopSellingProducts(Request $request)
    {
        $limit = $request->get('limit', 5);
        $data = $this->statisticsService->getTopSellingProducts($limit);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get comprehensive dashboard data
     */
    public function getDashboardData()
    {
        $data = $this->statisticsService->getDashboardData();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get recent data (orders, products, etc.)
     */
    public function getRecentData(Request $request)
    {
        $limit = $request->get('limit', 5);

        $data = [
            'recent_orders' => $this->statisticsService->getRecentOrders($limit),
            'recent_products' => $this->statisticsService->getRecentProducts($limit),
            'low_stock_products' => $this->statisticsService->getLowStockProducts(10, $limit),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}