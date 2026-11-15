<?php
require_once __DIR__ . '/pdo.php';

class Category {
    /**
     * Lấy tất cả danh mục đang hoạt động
     */
    public static function getAllCategories($statusOnly = false) {
        $sql = "SELECT * FROM categories";
        if ($statusOnly) {
            $sql .= " WHERE status = 'active'";
        }
        $sql .= " ORDER BY id ASC";
        return pdo_query($sql);
    }

    /**
     * Lấy 1 danh mục theo ID
     */
    public static function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    /**
     * Thêm mới danh mục
     */
    public static function insertCategory($name, $slug = '', $status = 'active') {
        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        }
        $sql = "INSERT INTO categories (name, slug, status) VALUES (?, ?, ?)";
        return pdo_execute_return_id($sql, $name, $slug, $status);
    }

    /**
     * Cập nhật danh mục
     */
    public static function updateCategory($id, $name, $slug = '', $status = 'active') {
        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        }
        $sql = "UPDATE categories SET name = ?, slug = ?, status = ? WHERE id = ?";
        return pdo_execute($sql, $name, $slug, $status, $id);
    }

    /**
     * Xóa danh mục
     */
    public static function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        return pdo_execute($sql, $id);
    }

    /**
     * Đếm số lượng sản phẩm theo danh mục
     */
    public static function getCategoryWithProductCount() {
        $sql = "SELECT c.*, COUNT(p.id) AS total_products 
                FROM categories c 
                LEFT JOIN products p ON c.id = p.category_id 
                GROUP BY c.id 
                ORDER BY c.id ASC";
        return pdo_query($sql);
    }
}
?>
