<?php
require_once __DIR__ . '/../../model/Employee.php';

class AuthController {
    /**
     * Hiển thị trang đăng nhập
     */
    public function login() {
        if (isset($_SESSION['employee'])) {
            header('Location: index.php?act=dashboard');
            exit;
        }
        $error = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);
        include_once __DIR__ . '/../view/auth/login.php';
    }

    /**
     * Xử lý xác thực đăng nhập
     */
    public function doLogin() {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!';
            header('Location: index.php?act=login');
            exit;
        }

        $employee = Employee::checkLogin($username, $password);

        if ($employee) {
            $_SESSION['employee'] = [
                'id' => $employee['id'],
                'username' => $employee['username'],
                'fullname' => $employee['fullname'],
                'role' => $employee['role']
            ];
            header('Location: index.php?act=dashboard');
            exit;
        } else {
            $_SESSION['login_error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
            header('Location: index.php?act=login');
            exit;
        }
    }

    /**
     * Đăng xuất
     */
    public function logout() {
        unset($_SESSION['employee']);
        header('Location: index.php?act=login');
        exit;
    }
}
?>
