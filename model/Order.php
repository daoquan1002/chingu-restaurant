<?php
require_once __DIR__ . '/pdo.php';

class Order {
    /**
     * Tạo mới đơn đặt món
     */
    public static function createOrder($orderCode, $tableId, $userId, $customerName, $customerPhone, $totalAmount, $note, $paymentMethod = 'cash', $paymentStatus = 'unpaid', $status = 'pending') {
        $sql = "INSERT INTO orders (order_code, table_id, user_id, customer_name, customer_phone, total_amount, note, payment_method, payment_status, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute_return_id($sql, $orderCode, $tableId, $userId, $customerName, $customerPhone, $totalAmount, $note, $paymentMethod, $paymentStatus, $status);
    }

    /**
     * Thêm chi tiết món ăn vào đơn hàng
     */
    public static function addOrderDetail($orderId, $productId, $productName, $price, $quantity, $subtotal, $note = '') {
        $sql = "INSERT INTO order_details (order_id, product_id, product_name, price, quantity, subtotal, note) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute_return_id($sql, $orderId, $productId, $productName, $price, $quantity, $subtotal, $note);
    }

    /**
     * Lấy danh sách tất cả đơn hàng (có thể lọc theo trạng thái, ngày)
     */
    public static function getAllOrders($status = null, $keyword = null) {
        $sql = "SELECT o.*, t.table_number 
                FROM orders o 
                LEFT JOIN tables t ON o.table_id = t.id 
                WHERE 1 = 1";
        $params = [];

        if (!empty($status)) {
            $sql .= " AND o.status = ?";
            $params[] = $status;
        }

        if (!empty($keyword)) {
            $sql .= " AND (o.order_code LIKE ? OR o.customer_name LIKE ? OR t.table_number LIKE ?)";
            $search = "%{$keyword}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY o.id DESC";

        if (!empty($params)) {
            return pdo_query($sql, ...$params);
        }
        return pdo_query($sql);
    }

    /**
     * Lấy thông tin 1 đơn hàng theo ID
     */
    public static function getOrderById($id) {
        $sql = "SELECT o.*, t.table_number 
                FROM orders o 
                LEFT JOIN tables t ON o.table_id = t.id 
                WHERE o.id = ?";
        return pdo_query_one($sql, $id);
    }

    /**
     * Lấy thông tin 1 đơn hàng theo Mã đơn (Order Code)
     */
    public static function getOrderByCode($orderCode) {
        $sql = "SELECT o.*, t.table_number 
                FROM orders o 
                LEFT JOIN tables t ON o.table_id = t.id 
                WHERE o.order_code = ?";
        return pdo_query_one($sql, $orderCode);
    }

    /**
     * Lấy danh sách chi tiết các món của 1 đơn hàng
     */
    public static function getOrderDetails($orderId) {
        $sql = "SELECT od.*, p.image, p.korean_name 
                FROM order_details od 
                LEFT JOIN products p ON od.product_id = p.id 
                WHERE od.order_id = ? 
                ORDER BY od.id ASC";
        return pdo_query($sql, $orderId);
    }

    /**
     * Cập nhật trạng thái đơn hàng ('pending', 'preparing', 'served', 'completed', 'cancelled')
     */
    public static function updateOrderStatus($id, $status) {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $res = pdo_execute($sql, $status, $id);

        // Khi đơn hàng chuyển sang 'completed' (hoàn thành) hoặc 'cancelled' (hủy),
        // tự động giải phóng bàn về trạng thái trống ('available') nếu không còn đơn nào khác đang phục vụ
        if ($status === 'completed' || $status === 'cancelled') {
            $order = self::getOrderById($id);
            if ($order && !empty($order['table_id'])) {
                $tableId = intval($order['table_id']);
                $activeSql = "SELECT COUNT(*) AS total FROM orders WHERE table_id = ? AND status NOT IN ('completed', 'cancelled') AND id != ?";
                $activeRow = pdo_query_one($activeSql, $tableId, $id);
                if (empty($activeRow['total'])) {
                    require_once __DIR__ . '/Table.php';
                    Table::updateTableStatus($tableId, 'available');
                }
            }
        }

        return $res;
    }

    /**
     * Cập nhật trạng thái thanh toán ('unpaid', 'paid')
     */
    public static function updatePaymentStatus($id, $paymentStatus, $paymentMethod = null) {
        if (!empty($paymentMethod)) {
            $sql = "UPDATE orders SET payment_status = ?, payment_method = ? WHERE id = ?";
            return pdo_execute($sql, $paymentStatus, $paymentMethod, $id);
        }
        $sql = "UPDATE orders SET payment_status = ? WHERE id = ?";
        return pdo_execute($sql, $paymentStatus, $id);
    }

    /**
     * Lấy thống kê tổng quan doanh thu và số lượng đơn
     */
    public static function getOrderStatistics() {
        $sql = "SELECT 
                    COUNT(*) AS total_orders,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_orders,
                    SUM(CASE WHEN status = 'preparing' THEN 1 ELSE 0 END) AS preparing_orders,
                    SUM(CASE WHEN status = 'served' THEN 1 ELSE 0 END) AS served_orders,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_orders,
                    SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) AS total_revenue
                FROM orders";
        return pdo_query_one($sql);
    }

    /**
     * Xóa đơn hàng và toàn bộ chi tiết món của đơn
     */
    public static function deleteOrder($id) {
        $sqlDetails = "DELETE FROM order_details WHERE order_id = ?";
        pdo_execute($sqlDetails, $id);

        $sqlOrder = "DELETE FROM orders WHERE id = ?";
        return pdo_execute($sqlOrder, $id);
    }
}
?>
