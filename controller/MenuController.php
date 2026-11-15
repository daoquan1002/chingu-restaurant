<?php
require_once __DIR__ . '/../model/Category.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Table.php';

class MenuController {
    public function index() {
        // Nhận diện bàn khi truy cập index.php?pg=menu&table=XX
        $hasTable = false;
        $currentTable = '';
        $isTableOccupied = false;

        if (!empty($_GET['table'])) {
            $tableParam = trim($_GET['table']);
            if (is_numeric($tableParam)) {
                $tableFormatted = "Bàn " . str_pad($tableParam, 2, '0', STR_PAD_LEFT);
            } elseif (mb_stripos($tableParam, 'bàn') === false) {
                $tableFormatted = "Bàn " . $tableParam;
            } else {
                $tableFormatted = $tableParam;
            }

            // Tìm thông tin bàn trong CSDL (hỗ trợ theo tên chuẩn, theo ID, hoặc tên gốc)
            $tableObj = Table::getTableByNumber($tableFormatted);
            if (!$tableObj && is_numeric($tableParam)) {
                $tableObj = Table::getTableById(intval($tableParam));
            }
            if (!$tableObj) {
                $tableObj = Table::getTableByNumber($tableParam);
            }

            // Kiểm tra trạng thái bàn và các đơn hàng gắn với bàn
            if ($tableObj) {
                // Kiểm tra xem bàn này có đơn hàng nào đang trong quá trình phục vụ không
                $activeOrderSql = "SELECT COUNT(*) AS total FROM orders WHERE table_id = ? AND status NOT IN ('completed', 'cancelled')";
                $activeOrder = pdo_query_one($activeOrderSql, $tableObj['id']);
                $hasActiveOrders = !empty($activeOrder['total']);

                // Nếu các đơn hàng gắn với bàn đã chuyển sang 'completed' (hoặc 'cancelled') -> Tự động mở lại trạng thái bàn trống ('available')
                if (!$hasActiveOrders && $tableObj['status'] === 'occupied') {
                    Table::updateTableStatus($tableObj['id'], 'available');
                    $tableObj['status'] = 'available';
                }

                // Nếu bàn đang có đơn phục vụ hoặc trạng thái là occupied
                if ($tableObj['status'] === 'occupied' || $hasActiveOrders) {
                    $isTableOccupied = true;
                    $currentTable = $tableObj['table_number'];
                    unset($_SESSION['current_table']);
                    $hasTable = false;
                } else {
                    $isTableOccupied = false;
                    $currentTable = $tableObj['table_number'];
                    $_SESSION['current_table'] = $currentTable;
                    $hasTable = true;
                }
            } else {
                $currentTable = $tableFormatted;
                $_SESSION['current_table'] = $currentTable;
                $hasTable = true;
                $isTableOccupied = false;
            }
        } else {
            // Không có tiền tố ?table= -> Chế độ chỉ xem thực đơn, không hiển thị bàn và không cho đặt món
            unset($_SESSION['current_table']);
            $currentTable = '';
            $hasTable = false;
        }

        // Lấy danh sách danh mục và sản phẩm từ cơ sở dữ liệu thật
        $categories = Category::getAllCategories(true);
        $products = Product::getAllProducts(null, null, 'active');

        // Nhóm các sản phẩm theo từng danh mục
        $groupedProducts = [];
        foreach ($categories as $cat) {
            $groupedProducts[$cat['slug']] = [];
        }
        foreach ($products as $prod) {
            $slug = $prod['category_slug'] ?? 'other';
            if (!isset($groupedProducts[$slug])) {
                $groupedProducts[$slug] = [];
            }
            $groupedProducts[$slug][] = $prod;
        }

        // Truyền dữ liệu vào View
        include_once __DIR__ . '/../view/menu.php';
    }
}
?>
