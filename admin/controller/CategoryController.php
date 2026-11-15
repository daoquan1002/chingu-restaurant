<?php
require_once __DIR__ . '/../../model/Category.php';

class CategoryController {
    /**
     * Danh sách danh mục
     */
    public function index() {
        $categories = Category::getCategoryWithProductCount();
        $msg = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);
        include_once __DIR__ . '/../view/categories/list.php';
    }

    /**
     * Thêm mới danh mục
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $status = $_POST['status'] ?? 'active';

            if (!empty($name)) {
                Category::insertCategory($name, $slug, $status);
                $_SESSION['admin_msg'] = 'Đã thêm danh mục mới thành công!';
                header('Location: index.php?act=categories');
                exit;
            }
        }
        include_once __DIR__ . '/../view/categories/create.php';
    }

    /**
     * Chỉnh sửa danh mục
     */
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $category = Category::getCategoryById($id);

        if (!$category) {
            header('Location: index.php?act=categories');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $status = $_POST['status'] ?? 'active';

            if (!empty($name)) {
                Category::updateCategory($id, $name, $slug, $status);
                $_SESSION['admin_msg'] = 'Đã cập nhật danh mục thành công!';
                header('Location: index.php?act=categories');
                exit;
            }
        }

        include_once __DIR__ . '/../view/categories/edit.php';
    }

    /**
     * Xóa danh mục
     */
    public function delete() {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            Category::deleteCategory($id);
            $_SESSION['admin_msg'] = 'Đã xóa danh mục thành công!';
        }
        header('Location: index.php?act=categories');
        exit;
    }
}
?>
