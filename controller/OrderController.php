<?php
require_once __DIR__ . '/../model/Table.php';
require_once __DIR__ . '/../model/Order.php';
require_once __DIR__ . '/../model/Product.php';

class OrderController {
    /**
     * Hiển thị trang xác nhận giỏ hàng & thanh toán
     */
    public function index() {
        // Lấy danh sách bàn ăn
        $tables = Table::getAllTables();

        // Nhận diện bàn khi truy cập ?pg=order&table=XX hoặc lấy từ session
        if (isset($_GET['table'])) {
            $tableParam = trim($_GET['table']);
            if (!empty($tableParam)) {
                if (is_numeric($tableParam)) {
                    $tableParam = "Bàn " . str_pad($tableParam, 2, '0', STR_PAD_LEFT);
                } elseif (mb_stripos($tableParam, 'bàn') === false) {
                    $tableParam = "Bàn " . $tableParam;
                }
                $_SESSION['current_table'] = $tableParam;
            }
        }
        $currentTable = $_SESSION['current_table'] ?? '';

        // Nếu người dùng chủ động đặt món mới (từ menu sang với tham số ?new=1), dọn session đơn cũ
        if (isset($_GET['new'])) {
            unset($_SESSION['last_order']);
        }

        // Kiểm tra xem có đơn hàng vừa tạo gần đây lưu trong session hay không (để reload trang không bị mất)
        $lastOrder = null;
        if (!empty($_SESSION['last_order'])) {
            $lastOrder = $_SESSION['last_order'];
            if (!empty($lastOrder['order_code'])) {
                $dbOrder = Order::getOrderByCode($lastOrder['order_code']);
                // Chỉ giữ lại nếu đơn hàng thực sự tồn tại trong DB và đang trong quá trình phục vụ
                if ($dbOrder && in_array($dbOrder['status'], ['pending', 'processing', 'delivering'])) {
                    $details = Order::getOrderDetails($dbOrder['id']);
                    $lastOrder['order_id'] = $dbOrder['id'];
                    $lastOrder['order_code'] = $dbOrder['order_code'];
                    $lastOrder['customer_name'] = $dbOrder['customer_name'];
                    $lastOrder['table_number'] = $dbOrder['table_number'];
                    $lastOrder['note'] = $dbOrder['note'];
                    $lastOrder['payment_method'] = $dbOrder['payment_method'];
                    $lastOrder['total_amount'] = $dbOrder['total_amount'];
                    if (!empty($details)) {
                        $lastOrder['items'] = $details;
                    }
                } else {
                    unset($_SESSION['last_order']);
                    $lastOrder = null;
                }
            } else {
                unset($_SESSION['last_order']);
                $lastOrder = null;
            }
        }

        // Nếu bàn đang phục vụ nhưng KHÔNG PHẢI do vừa tạo đơn hiện tại này -> mới chuyển hướng về menu
        if (!empty($currentTable)) {
            $tableCheck = Table::getTableByNumber($currentTable);
            if ($tableCheck && $tableCheck['status'] === 'occupied') {
                $isCurrentOrderTable = ($lastOrder && !empty($lastOrder['table_number']) && $lastOrder['table_number'] === $currentTable);
                if (!$isCurrentOrderTable) {
                    unset($_SESSION['current_table']);
                    header('Location: index.php?pg=menu&table=' . urlencode($currentTable));
                    exit;
                }
            }
        }
        $selectedTable = $currentTable;

        include_once __DIR__ . '/../view/order.php';
    }

    /**
     * API Lưu đơn đặt món từ khách hàng vào Database (AJAX POST)
     */
    public function submit() {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ!']);
            exit;
        }

        // Nhận dữ liệu JSON từ client
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }

        $customerName = trim($input['customer_name'] ?? '');
        $note = trim($input['note'] ?? '');
        $paymentMethod = trim($input['payment_method'] ?? 'cash');
        $tableNumber = trim($input['table_number'] ?? ($_SESSION['current_table'] ?? ''));
        $cartItems = $input['items'] ?? [];

        if (empty($customerName)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập họ và tên khách hàng!']);
            exit;
        }

        if (empty($cartItems)) {
            echo json_encode(['success' => false, 'message' => 'Giỏ hàng của bạn đang trống!']);
            exit;
        }

        // Tìm ID bàn nếu có số bàn
        $tableId = null;
        if (!empty($tableNumber)) {
            $tableObj = Table::getTableByNumber($tableNumber);
            if (!$tableObj && is_numeric($tableNumber)) {
                $tableObj = Table::getTableById($tableNumber);
            }
            if ($tableObj) {
                if ($tableObj['status'] === 'occupied') {
                    echo json_encode(['success' => false, 'message' => 'Bàn hiện tại không khả dụng để đặt món']);
                    exit;
                }
                $tableId = $tableObj['id'];
            }
        }

        // Tính tổng tiền đơn hàng
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $qty = max(1, intval($item['qty'] ?? 1));
            $price = floatval($item['price'] ?? 0);
            $totalAmount += ($price * $qty);
        }

        // Tạo mã đơn hàng độc nhất (vd: CG-6281)
        $orderCode = 'CG-' . strtoupper(substr(uniqid(), -4));

        try {
            // 1. Tạo đơn hàng trong bảng orders
            $orderId = Order::createOrder(
                $orderCode,
                $tableId,
                null,
                $customerName,
                null,
                $totalAmount,
                $note,
                $paymentMethod,
                'unpaid',
                'pending'
            );

            // 2. Thêm từng món vào bảng order_details
            foreach ($cartItems as $item) {
                $name = $item['name'] ?? 'Món ăn';
                $price = floatval($item['price'] ?? 0);
                $qty = max(1, intval($item['qty'] ?? 1));
                $subtotal = $price * $qty;
                $itemNote = $item['note'] ?? '';
                $productId = intval($item['id'] ?? 0);

                // Nếu id dạng item_..., tìm product theo tên
                if ($productId <= 0) {
                    $allProds = Product::getAllProducts();
                    foreach ($allProds as $p) {
                        if (trim(strtolower($p['name'])) === trim(strtolower($name))) {
                            $productId = $p['id'];
                            break;
                        }
                    }
                }
                if ($productId <= 0) $productId = 1; // Fallback

                Order::addOrderDetail($orderId, $productId, $name, $price, $qty, $subtotal, $itemNote);
            }

            // 3. Cập nhật trạng thái bàn thành occupied (đang dùng) nếu khách ngồi tại bàn
            if ($tableId) {
                Table::updateTableStatus($tableId, 'occupied');
            }

            // 4. Lưu thông tin đơn vừa tạo vào session để reload trang không bị mất
            $_SESSION['last_order'] = [
                'order_id' => $orderId,
                'order_code' => $orderCode,
                'customer_name' => $customerName,
                'table_number' => $tableNumber,
                'note' => $note,
                'payment_method' => $paymentMethod,
                'total_amount' => $totalAmount,
                'items' => $cartItems
            ];

            echo json_encode([
                'success' => true,
                'order_id' => $orderId,
                'order_code' => $orderCode,
                'message' => 'Tạo đơn hàng thành công! Đơn hàng đã được chuyển tới quầy bếp.'
            ]);
            exit;

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi lưu đơn hàng: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Trang theo dõi trạng thái đơn hàng (Web Client)
     */
    public function status() {
        $rawCode = trim($_GET['code'] ?? '');
        $orderCode = ltrim($rawCode, '#');
        $order = null;
        $orderDetails = [];
        $searchError = '';

        if (!empty($rawCode)) {
            $order = Order::getOrderByCode($orderCode);
            if (!$order) {
                // Thử tìm nguyên mẫu rawCode nếu trong DB có lưu dấu #
                $order = Order::getOrderByCode($rawCode);
            }

            if ($order) {
                $orderDetails = Order::getOrderDetails($order['id']);
            } else {
                $searchError = 'Không tìm thấy đơn hàng nào khớp với mã "' . htmlspecialchars($rawCode) . '". Quý khách vui lòng kiểm tra lại chính xác mã đơn!';
            }
        }

        include_once __DIR__ . '/../view/order_status.php';
    }
}
?>
