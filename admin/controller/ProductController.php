<?php
require_once __DIR__ . '/../../model/Product.php';
require_once __DIR__ . '/../../model/Category.php';

class ProductController {
    /**
     * Danh sách món ăn
     */
    public function index() {
        $categoryId = isset($_GET['cat']) ? intval($_GET['cat']) : null;
        $keyword = trim($_GET['keyword'] ?? '');

        $categories = Category::getAllCategories();
        $products = Product::getAllProducts($categoryId, $keyword);

        $msg = $_SESSION['admin_msg'] ?? '';
        unset($_SESSION['admin_msg']);

        include_once __DIR__ . '/../view/products/list.php';
    }

    /**
     * Thêm mới món ăn
     */
    public function create() {
        $categories = Category::getAllCategories();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $koreanName = trim($_POST['korean_name'] ?? '');
            $categoryId = intval($_POST['category_id'] ?? 0);
            $price = floatval(str_replace(['.', ','], '', $_POST['price'] ?? 0));
            $description = trim($_POST['description'] ?? '');
            $badge = trim($_POST['badge'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $image = trim($_POST['image'] ?? '');

            // Xử lý upload ảnh nếu có
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['image_file']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
                    $image = 'public/assets/images/' . $fileName;
                }
            }

            if (empty($name) || $categoryId <= 0 || $price <= 0) {
                $error = 'Vui lòng nhập tên món, chọn danh mục và giá hợp lệ!';
            } else {
                Product::insertProduct($categoryId, $name, $koreanName, $description, $price, $image, $badge, $status);
                $_SESSION['admin_msg'] = 'Đã thêm món ăn mới vào thực đơn thành công!';
                header('Location: index.php?act=products');
                exit;
            }
        }

        include_once __DIR__ . '/../view/products/create.php';
    }

    /**
     * Chỉnh sửa món ăn
     */
    public function edit() {
        $id = intval($_GET['id'] ?? 0);
        $product = Product::getProductById($id);

        if (!$product) {
            header('Location: index.php?act=products');
            exit;
        }

        $categories = Category::getAllCategories();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $koreanName = trim($_POST['korean_name'] ?? '');
            $categoryId = intval($_POST['category_id'] ?? 0);
            $price = floatval(str_replace(['.', ','], '', $_POST['price'] ?? 0));
            $description = trim($_POST['description'] ?? '');
            $badge = trim($_POST['badge'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $image = trim($_POST['image'] ?? $product['image']);

            // Xử lý upload ảnh nếu có
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['image_file']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
                    $image = 'public/assets/images/' . $fileName;
                }
            }

            if (empty($name) || $categoryId <= 0 || $price <= 0) {
                $error = 'Vui lòng nhập đầy đủ tên món, danh mục và giá tiền!';
            } else {
                Product::updateProduct($id, $categoryId, $name, $koreanName, $description, $price, $image, $badge, $status);
                $_SESSION['admin_msg'] = 'Đã cập nhật món ăn thành công!';
                header('Location: index.php?act=products');
                exit;
            }
        }

        include_once __DIR__ . '/../view/products/edit.php';
    }

    /**
     * Xóa món ăn
     */
    public function delete() {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            Product::deleteProduct($id);
            $_SESSION['admin_msg'] = 'Đã xóa món ăn khỏi thực đơn!';
        }
        header('Location: index.php?act=products');
        exit;
    }
}
?>
