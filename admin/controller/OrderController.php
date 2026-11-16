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
        $userRole = $_SESSION['employee']['role'] ?? 'staff';

        // Bộ phận bếp chỉ được cập nhật sang preparing hoặc served
        if ($userRole === 'kitchen' && !in_array($status, ['preparing', 'served'])) {
            $_SESSION['admin_error'] = 'Bộ phận Bếp chỉ có quyền cập nhật đơn sang Bếp đang nấu hoặc Đã phục vụ!';
            header('Location: index.php?act=orders');
            exit;
        }

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
        $userRole = $_SESSION['employee']['role'] ?? 'staff';
        if ($userRole === 'kitchen') {
            $_SESSION['admin_error'] = 'Bộ phận Bếp không có quyền ghi nhận thanh toán!';
            header('Location: index.php?act=orders');
            exit;
        }

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

    /**
     * Xóa đơn hàng hoàn toàn khỏi hệ thống
     */
    public function delete() {
        $userRole = $_SESSION['employee']['role'] ?? 'staff';
        if ($userRole !== 'admin') {
            $_SESSION['admin_error'] = 'Chỉ Quản trị viên (Admin) mới có quyền xóa đơn hàng!';
            header('Location: index.php?act=orders');
            exit;
        }

        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $order = Order::getOrderById($id);
            if ($order && !empty($order['table_id']) && $order['status'] !== 'completed' && $order['status'] !== 'cancelled') {
                Table::updateTableStatus($order['table_id'], 'available');
            }
            Order::deleteOrder($id);
            $_SESSION['admin_msg'] = 'Đã xóa vĩnh viễn đơn hàng #' . htmlspecialchars($order['order_code'] ?? $id) . ' thành công!';
        }
        header('Location: index.php?act=orders');
        exit;
    }
}
?>
