<?php
require_once __DIR__ . '/../../model/Order.php';
require_once __DIR__ . '/../../model/Table.php';

class OrderController {
    /**
     * Danh sách đơn hàng
     */
    public function index() {
        $status = $_GET['status'] ?? null;
        $keyword = trim($_GET['keyword'] ?? '');

        $orders = Order::getAllOrders($status, $keyword);
        $stats = Order::getOrderStatistics();

        $msg = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);

        include_once __DIR__ . '/../view/orders/list.php';
    }

    /**
     * Xem chi tiết đơn hàng
     */
    public function detail() {
        $id = intval($_GET['id'] ?? 0);
        $order = Order::getOrderById($id);

        if (!$order) {
            header('Location: index.php?act=orders');
            exit;
        }

        $orderDetails = Order::getOrderDetails($id);

        include_once __DIR__ . '/../view/orders/detail.php';
    }

    /**
     * Cập nhật trạng thái đơn (Xác nhận đơn, Bếp chuẩn bị, Đã phục vụ, Hoàn tất, Hủy)
     */
    public function updateStatus() {
        $id = intval($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? 'pending';

        if ($id > 0) {
            Order::updateOrderStatus($id, $status);

            // Nếu đơn hoàn thành hoặc hủy, giải phóng bàn (chuyển về available)
            if ($status === 'completed' || $status === 'cancelled') {
                $order = Order::getOrderById($id);
                if ($order && !empty($order['table_id'])) {
                    Table::updateTableStatus($order['table_id'], 'available');
                }
            }

            $_SESSION['admin_msg'] = 'Đã cập nhật trạng thái đơn hàng thành công!';
        }

        $redirect = $_GET['redirect'] ?? 'orders';
        if ($redirect === 'detail') {
            header('Location: index.php?act=order-detail&id=' . $id);
        } else {
            header('Location: index.php?act=orders');
        }
        exit;
    }

    /**
     * Ghi nhận thanh toán (Tiền mặt hoặc Chuyển khoản)
     */
    public function updatePayment() {
        $id = intval($_GET['id'] ?? 0);
        $paymentStatus = $_GET['pay_status'] ?? 'paid';
        $paymentMethod = $_GET['method'] ?? null;

        if ($id > 0) {
            Order::updatePaymentStatus($id, $paymentStatus, $paymentMethod);
            $_SESSION['admin_msg'] = 'Đã ghi nhận thanh toán đơn hàng thành công!';
        }

        header('Location: index.php?act=order-detail&id=' . $id);
        exit;
    }
}
?>
