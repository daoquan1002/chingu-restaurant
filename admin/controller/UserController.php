<?php
require_once __DIR__ . '/../../model/Employee.php';

class UserController {
    /**
     * Kiểm tra quyền Admin tối cao
     */
    private function checkAdminPermission() {
        if (($_SESSION['employee']['role'] ?? '') !== 'admin') {
            $_SESSION['admin_error'] = 'Chỉ Quản trị viên (Admin) mới có quyền truy cập quản lý tài khoản & phân quyền!';
            $fallback = (($_SESSION['employee']['role'] ?? '') === 'kitchen') ? 'orders' : 'dashboard';
            header("Location: index.php?act={$fallback}");
            exit;
        }
    }

    /**
     * Danh sách tài khoản người dùng / nhân viên
     */
    public function index() {
        $this->checkAdminPermission();

        $employees = Employee::getAllEmployees();
        $msg = $_SESSION['admin_msg'] ?? '';
        $error = $_SESSION['admin_error'] ?? '';
        unset($_SESSION['admin_msg'], $_SESSION['admin_error']);

        include_once __DIR__ . '/../view/users/list.php';
    }

    /**
     * Thêm tài khoản mới
     */
    public function create() {
        $this->checkAdminPermission();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            $role = trim($_POST['role'] ?? 'staff');

            $validRoles = ['admin', 'staff', 'kitchen'];
            if (!in_array($role, $validRoles)) {
                $role = 'staff';
            }

            if (empty($username) || empty($password) || empty($fullname)) {
                $_SESSION['admin_error'] = 'Vui lòng điền đầy đủ tên đăng nhập, mật khẩu và họ tên!';
            } else {
                try {
                    Employee::createEmployee($username, $password, $fullname, $role);
                    $_SESSION['admin_msg'] = 'Tạo tài khoản ' . htmlspecialchars($username) . ' thành công!';
                } catch (Exception $e) {
                    $_SESSION['admin_error'] = 'Tên đăng nhập đã tồn tại hoặc có lỗi xảy ra!';
                }
            }
        }
        header('Location: index.php?act=users');
        exit;
    }

    /**
     * Xóa tài khoản
     */
    public function delete() {
        $this->checkAdminPermission();

        $id = intval($_GET['id'] ?? 0);
        $currentUserId = $_SESSION['employee']['id'] ?? 0;

        if ($id === $currentUserId) {
            $_SESSION['admin_error'] = 'Bạn không thể tự xóa tài khoản đang đăng nhập!';
        } elseif ($id > 0) {
            Employee::deleteEmployee($id);
            $_SESSION['admin_msg'] = 'Đã xóa tài khoản thành công!';
        }
        header('Location: index.php?act=users');
        exit;
    }

    /**
     * Trang phân quyền vai trò
     */
    public function roles() {
        $this->checkAdminPermission();

        $employees = Employee::getAllEmployees();
        $msg = $_SESSION['admin_msg'] ?? '';
        $error = $_SESSION['admin_error'] ?? '';
        unset($_SESSION['admin_msg'], $_SESSION['admin_error']);

        include_once __DIR__ . '/../view/users/roles.php';
    }

    /**
     * Cập nhật vai trò phân quyền
     */
    public function updateRole() {
        $this->checkAdminPermission();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['user_id'] ?? 0);
            $role = trim($_POST['role'] ?? 'staff');
            $validRoles = ['admin', 'staff', 'kitchen'];

            if ($id > 0 && in_array($role, $validRoles)) {
                Employee::updateRole($id, $role);

                // Nếu tự cập nhật chính tài khoản đang đăng nhập, đồng bộ lại quyền trong session
                if ($id === intval($_SESSION['employee']['id'] ?? 0)) {
                    $_SESSION['employee']['role'] = $role;
                }

                $_SESSION['admin_msg'] = 'Cập nhật phân quyền vai trò thành công!';
            }
        }
        header('Location: index.php?act=roles');
        exit;
    }
}
?>