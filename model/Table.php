<?php
require_once __DIR__ . '/pdo.php';

class Table {
    /**
     * Lấy danh sách tất cả các bàn ăn
     */
    public static function getAllTables($status = null) {
        $sql = "SELECT * FROM tables";
        if (!empty($status)) {
            $sql .= " WHERE status = ?";
            return pdo_query($sql, $status);
        }
        $sql .= " ORDER BY id ASC";
        return pdo_query($sql);
    }

    /**
     * Lấy 1 bàn theo ID
     */
    public static function getTableById($id) {
        $sql = "SELECT * FROM tables WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    /**
     * Lấy 1 bàn theo số bàn (ví dụ 'Bàn 01')
     */
    public static function getTableByNumber($tableNumber) {
        $sql = "SELECT * FROM tables WHERE table_number = ?";
        return pdo_query_one($sql, $tableNumber);
    }

    /**
     * Thêm mới bàn
     */
    public static function insertTable($tableNumber, $capacity = 4, $status = 'available') {
        $sql = "INSERT INTO tables (table_number, capacity, status) VALUES (?, ?, ?)";
        return pdo_execute_return_id($sql, $tableNumber, $capacity, $status);
    }

    /**
     * Cập nhật thông tin bàn
     */
    public static function updateTable($id, $tableNumber, $capacity, $status) {
        $sql = "UPDATE tables SET table_number = ?, capacity = ?, status = ? WHERE id = ?";
        return pdo_execute($sql, $tableNumber, $capacity, $status, $id);
    }

    /**
     * Cập nhật trạng thái bàn ('available', 'occupied', 'reserved')
     */
    public static function updateTableStatus($id, $status) {
        $sql = "UPDATE tables SET status = ? WHERE id = ?";
        return pdo_execute($sql, $status, $id);
    }

    /**
     * Xóa bàn
     */
    public static function deleteTable($id) {
        $sql = "DELETE FROM tables WHERE id = ?";
        return pdo_execute($sql, $id);
    }

    /**
     * Thống kê số bàn theo trạng thái
     */
    public static function getTableStatistics() {
        $sql = "SELECT 
                    COUNT(*) AS total_tables,
                    SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) AS available_tables,
                    SUM(CASE WHEN status = 'occupied' THEN 1 ELSE 0 END) AS occupied_tables
                FROM tables";
        return pdo_query_one($sql);
    }
}
?>
