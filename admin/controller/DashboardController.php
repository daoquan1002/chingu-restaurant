<?php
require_once __DIR__ . '/../../model/Order.php';
require_once __DIR__ . '/../../model/Product.php';
require_once __DIR__ . '/../../model/Table.php';
require_once __DIR__ . '/../../model/Category.php';

class DashboardController {
    public function index() {
        // Thống kê tổng quan
        $orderStats = Order::getOrderStatistics();
        $tableStats = Table::getTableStatistics();
        $totalProducts = Product::countAllProducts();
        $totalCategories = count(Category::getAllCategories());

        // Lấy 8 đơn hàng mới nhất
        $recentOrders = Order::getAllOrders(null, null);
        $recentOrders = array_slice($recentOrders, 0, 8);

        // Lấy danh sách bàn
        $tables = Table::getAllTables();

        include_once __DIR__ . '/../view/dashboard/index.php';
    }
}
?>
