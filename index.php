<?php
session_start();

// Import các Controller
include_once 'controller/HomeController.php';
include_once 'controller/MenuController.php';
include_once 'controller/OrderController.php';

// Khởi tạo Controller
$homeController = new HomeController();
$menuController = new MenuController();
$orderController = new OrderController();

// Điều hướng trang theo tham số pg (hoặc act / action)
$pg = $_GET['pg'] ?? $_GET['act'] ?? $_GET['action'] ?? 'home';

switch ($pg) {
    case 'order-submit':
        $orderController->submit();
        break;

    case 'order-status':
        $orderController->status();
        break;

    case 'order':
        $orderController->index();
        break;

    case 'menu':
        $menuController->index();
        break;

    case 'home':
    default:
        $homeController->index();
        break;
}
?>
