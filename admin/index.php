<?php
session_start();

// Import các Controller của Admin
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/DashboardController.php';
require_once __DIR__ . '/controller/CategoryController.php';
require_once __DIR__ . '/controller/ProductController.php';
require_once __DIR__ . '/controller/TableController.php';
require_once __DIR__ . '/controller/OrderController.php';
require_once __DIR__ . '/controller/UserController.php';
require_once __DIR__ . '/controller/VietqrController.php';

$authController = new AuthController();
$dashboardController = new DashboardController();
$categoryController = new CategoryController();
$productController = new ProductController();
$tableController = new TableController();
$orderController = new OrderController();
$userController = new UserController();
$vietqrController = new VietqrController();

$act = $_GET['act'] ?? 'dashboard';

// Xử lý các action không yêu cầu đăng nhập trước
if ($act === 'login') {
    $authController->login();
    exit;
} elseif ($act === 'do-login') {
    $authController->doLogin();
    exit;
} elseif ($act === 'logout') {
    $authController->logout();
    exit;
}

// Kiểm tra phiên đăng nhập của nhân viên/quản trị viên
if (!isset($_SESSION['employee'])) {
    header('Location: index.php?act=login');
    exit;
}

$userRole = $_SESSION['employee']['role'] ?? 'staff';

// Đặt trang mặc định theo vai trò (Bếp vào thẳng trang Quản lý đơn hàng)
if (empty($_GET['act'])) {
    $act = ($userRole === 'kitchen') ? 'orders' : 'dashboard';
}

// Hệ thống phân quyền RBAC (Role-Based Access Control)
$rolePermissions = [
    'admin' => ['*'],
    'staff' => [
        'dashboard',
        'orders', 'order-detail', 'order-status-update', 'order-payment-update',
        'tables', 'table-create', 'table-status', 'table-qr'
    ],
    'kitchen' => [
        'orders', 'order-detail', 'order-status-update'
    ]
];

$allowedActs = $rolePermissions[$userRole] ?? $rolePermissions['staff'];

// Kiểm tra quyền truy cập của vai trò hiện tại
if ($allowedActs !== ['*'] && !in_array($act, $allowedActs)) {
    $_SESSION['admin_error'] = 'Tài khoản của bạn (vai trò ' . strtoupper($userRole) . ') không có quyền truy cập chức năng này!';
    $fallbackAct = ($userRole === 'kitchen') ? 'orders' : 'dashboard';
    header("Location: index.php?act={$fallbackAct}");
    exit;
}

// Điều hướng các chức năng quản trị theo yêu cầu /goal
switch ($act) {
    // 1. Dashboard tổng quan
    case 'dashboard':
        $dashboardController->index();
        break;

    // 2. Quản lý danh mục món ăn
    case 'categories':
        $categoryController->index();
        break;
    case 'category-create':
        $categoryController->create();
        break;
    case 'category-edit':
        $categoryController->edit();
        break;
    case 'category-delete':
        $categoryController->delete();
        break;

    // 3. Quản lý món ăn
    case 'products':
        $productController->index();
        break;
    case 'product-create':
        $productController->create();
        break;
    case 'product-edit':
        $productController->edit();
        break;
    case 'product-delete':
        $productController->delete();
        break;

    // 4. Quản lý bàn và mã QR
    case 'tables':
        $tableController->index();
        break;
    case 'table-create':
        $tableController->create();
        break;
    case 'table-status':
        $tableController->updateStatus();
        break;
    case 'table-delete':
        $tableController->delete();
        break;
    case 'table-qr':
        $tableController->viewQr();
        break;

    // 5. Quản lý đơn hàng & xác nhận, thanh toán
    case 'orders':
        $orderController->index();
        break;
    case 'order-detail':
        $orderController->detail();
        break;
    case 'order-status-update':
        $orderController->updateStatus();
        break;
    case 'order-payment-update':
        $orderController->updatePayment();
        break;
    case 'order-delete':
        $orderController->delete();
        break;

    // 6. Quản lý tài khoản & phân quyền
    case 'users':
        $userController->index();
        break;
    case 'user-create':
        $userController->create();
        break;
    case 'user-delete':
        $userController->delete();
        break;
    case 'roles':
        $userController->roles();
        break;
    case 'user-update-role':
        $userController->updateRole();
        break;

    // 7. Cấu hình thanh toán VietQR
    case 'vietqr':
        $vietqrController->index();
        break;
    case 'vietqr-update':
        $vietqrController->update();
        break;

    default:
        $dashboardController->index();
        break;
}
?>
