<?php
require_once __DIR__ . '/../../model/Table.php';

class TableController {
    /**
     * Danh sách bàn ăn và trạng thái
     */
    public function index() {
        $status = $_GET['status'] ?? null;
        $tables = Table::getAllTables($status);
        $stats = Table::getTableStatistics();

        $msg = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);

        include_once __DIR__ . '/../view/tables/list.php';
    }

    /**
     * Thêm mới bàn
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tableNumber = trim($_POST['table_number'] ?? '');
            $capacity = intval($_POST['capacity'] ?? 4);
            $status = $_POST['status'] ?? 'available';

            if (!empty($tableNumber)) {
                Table::insertTable($tableNumber, $capacity, $status);
                $_SESSION['admin_msg'] = 'Đã thêm bàn mới thành công!';
            }
        }
        header('Location: index.php?act=tables');
        exit;
    }

    /**
     * Cập nhật trạng thái bàn
     */
    public function updateStatus() {
        $id = intval($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? 'available';

        if ($id > 0) {
            Table::updateTableStatus($id, $status);
            $_SESSION['admin_msg'] = 'Đã cập nhật trạng thái bàn thành công!';
        }
        header('Location: index.php?act=tables');
        exit;
    }

    /**
     * Xóa bàn
     */
    public function delete() {
        $userRole = $_SESSION['employee']['role'] ?? 'staff';
        if ($userRole !== 'admin') {
            $_SESSION['admin_error'] = 'Chỉ Quản trị viên (Admin) mới có quyền xóa bàn ăn!';
            header('Location: index.php?act=tables');
            exit;
        }

        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            Table::deleteTable($id);
            $_SESSION['admin_msg'] = 'Đã xóa bàn thành công!';
        }
        header('Location: index.php?act=tables');
        exit;
    }

    /**
     * Hiển thị và in mã QR cho bàn
     */
    public function viewQr() {
        $id = intval($_GET['id'] ?? 0);
        $table = Table::getTableById($id);

        if (!$table) {
            header('Location: index.php?act=tables');
            exit;
        }

        // Tạo URL đặt món tại bàn này
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $dir = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
        $orderUrl = "{$baseUrl}{$dir}/index.php?pg=menu&table=" . urlencode($table['table_number']);

        include_once __DIR__ . '/../view/tables/qr.php';
    }
}
?>
