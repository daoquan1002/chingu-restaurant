<?php
require_once __DIR__ . '/pdo.php';

class Product {
    /**
     * Lấy danh sách sản phẩm (có thể lọc theo danh mục, từ khóa tìm kiếm, trạng thái)
     */
    public static function getAllProducts($categoryId = null, $keyword = null, $status = null) {
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE 1 = 1";
        $params = [];

        if (!empty($categoryId)) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }

        if (!empty($keyword)) {
            $sql .= " AND (p.name LIKE ? OR p.korean_name LIKE ? OR p.description LIKE ?)";
            $search = "%{$keyword}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($status)) {
            $sql .= " AND p.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY p.category_id ASC, p.id ASC";

        if (!empty($params)) {
            return pdo_query($sql, ...$params);
        }
        return pdo_query($sql);
    }

    /**
     * Lấy 1 sản phẩm theo ID
     */
    public static function getProductById($id) {
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        return pdo_query_one($sql, $id);
    }

    /**
     * Lấy sản phẩm theo mã phân loại danh mục (slug, ví dụ: 'bbq', 'hotpot')
     */
    public static function getProductsByCategorySlug($slug) {
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE c.slug = ? AND p.status = 'active' 
                ORDER BY p.id ASC";
        return pdo_query($sql, $slug);
    }

    /**
     * Thêm mới sản phẩm
     */
    public static function insertProduct($categoryId, $name, $koreanName, $description, $price, $image, $badge = '', $status = 'active') {
        $sql = "INSERT INTO products (category_id, name, korean_name, description, price, image, badge, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute_return_id($sql, $categoryId, $name, $koreanName, $description, $price, $image, $badge, $status);
    }

    /**
     * Cập nhật sản phẩm
     */
    public static function updateProduct($id, $categoryId, $name, $koreanName, $description, $price, $image, $badge = '', $status = 'active') {
        $sql = "UPDATE products 
                SET category_id = ?, name = ?, korean_name = ?, description = ?, price = ?, image = ?, badge = ?, status = ? 
                WHERE id = ?";
        return pdo_execute($sql, $categoryId, $name, $koreanName, $description, $price, $image, $badge, $status, $id);
    }

    /**
     * Xóa sản phẩm
     */
    public static function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        return pdo_execute($sql, $id);
    }

    /**
     * Đếm tổng số sản phẩm
     */
    public static function countAllProducts() {
        $sql = "SELECT COUNT(*) FROM products";
        return (int)pdo_query_value($sql);
    }
}
?>
