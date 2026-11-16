<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $pageTitle ?? 'Quản Trị Nhà Hàng • Chingu Korean Restaurant' ?></title>

    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Simple-DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- SB Admin CSS -->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <!-- Supplementary Custom Styles (Badges, Stepper, Thumbnails) -->
    <link href="assets/css/admin.css" rel="stylesheet" />
    <!-- FontAwesome v6 & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<?php $currentRole = $_SESSION['employee']['role'] ?? 'staff'; ?>
<body class="sb-nav-fixed">
    <!-- 1. THANH TOPBAR SB ADMIN -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Sidebar Toggle (Nút ba gạch ở góc trái ngoài cùng) -->
        <button class="btn btn-link btn-sm ps-3 pe-2 text-white-50" id="sidebarToggle" href="#!"><i class="fas fa-bars fs-5"></i></button>
        <!-- Navbar Brand (Logo Chingu Restaurant gốc) -->
        <a class="navbar-brand ps-2 fw-bold d-flex align-items-center gap-2" href="<?= $currentRole === 'kitchen' ? 'index.php?act=orders' : 'index.php?act=dashboard' ?>">
            <span>CHINGU <small class="fw-normal text-warning">RESTAURANT</small></span>
        </a>
        <!-- Navbar Date & Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 text-white-50 small">
            <i class="far fa-calendar-alt me-1 text-warning"></i> <?= date('d/m/Y') ?>
        </div>
        <!-- Navbar User Menu-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg text-warning"></i>
                    <span class="d-none d-sm-inline"><?= htmlspecialchars($_SESSION['employee']['fullname'] ?? 'Quản trị viên') ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                    <li class="dropdown-header small text-muted">
                        Vai trò: <strong><?= strtoupper(htmlspecialchars($currentRole)) ?></strong>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="../index.php?pg=menu" target="_blank">
                            <i class="fas fa-external-link-alt me-2 text-primary"></i>Xem Menu Khách
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item text-danger" href="index.php?act=logout">
                            <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- 2. LAYOUT SIDENAV SB ADMIN -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <?php if ($currentRole !== 'kitchen'): ?>
                            <div class="sb-sidenav-menu-heading">TỔNG QUAN</div>
                            <a class="nav-link <?= ($act ?? '') === 'dashboard' ? 'active' : '' ?>" href="index.php?act=dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Bảng Điều Khiển
                            </a>
                        <?php endif; ?>

                        <div class="sb-sidenav-menu-heading">QUẢN LÝ VẬN HÀNH</div>
                        <a class="nav-link <?= strpos(($act ?? ''), 'order') !== false ? 'active' : '' ?>" href="index.php?act=orders">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Quản Lý Đơn Hàng
                        </a>
                        <?php if ($currentRole !== 'kitchen'): ?>
                            <a class="nav-link <?= strpos(($act ?? ''), 'table') !== false ? 'active' : '' ?>" href="index.php?act=tables">
                                <div class="sb-nav-link-icon"><i class="fas fa-chair"></i></div>
                                Bàn Ăn & Mã QR
                            </a>
                        <?php endif; ?>

                        <?php if ($currentRole === 'admin'): ?>
                            <div class="sb-sidenav-menu-heading">QUẢN LÝ THỰC ĐƠN</div>
                            <a class="nav-link <?= strpos(($act ?? ''), 'product') !== false ? 'active' : '' ?>" href="index.php?act=products">
                                <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                                Danh Sách Món Ăn
                            </a>
                            <a class="nav-link <?= strpos(($act ?? ''), 'categor') !== false ? 'active' : '' ?>" href="index.php?act=categories">
                                <div class="sb-nav-link-icon"><i class="fas fa-th-list"></i></div>
                                Danh Mục Thực Đơn
                            </a>

                            <div class="sb-sidenav-menu-heading">THANH TOÁN & CẤU HÌNH</div>
                            <a class="nav-link <?= strpos(($act ?? ''), 'vietqr') !== false ? 'active' : '' ?>" href="index.php?act=vietqr">
                                <div class="sb-nav-link-icon"><i class="fas fa-qrcode"></i></div>
                                Chỉnh Sửa VietQR
                            </a>

                            <div class="sb-sidenav-menu-heading">TÀI KHOẢN</div>
                            <a class="nav-link <?= strpos(($act ?? ''), 'user') !== false && ($act ?? '') !== 'roles' ? 'active' : '' ?>" href="index.php?act=users">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                                Quản Lý Tài Khoản
                            </a>
                            <a class="nav-link <?= ($act ?? '') === 'roles' ? 'active' : '' ?>" href="index.php?act=roles">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                                Phân Quyền
                            </a>
                        <?php endif; ?>

                        <div class="sb-sidenav-menu-heading">HỆ THỐNG</div>
                        <a class="nav-link text-danger" href="index.php?act=logout">
                            <div class="sb-nav-link-icon text-danger"><i class="fas fa-sign-out-alt"></i></div>
                            Đăng Xuất
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- 3. NỘI DUNG CHÍNH (CONTENT AREA) -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-3">
                    <?php 
                        $adminMsg = $msg ?? $_SESSION['admin_msg'] ?? '';
                        $adminError = $error ?? $_SESSION['admin_error'] ?? '';
                        unset($_SESSION['admin_msg'], $_SESSION['admin_error']);
                    ?>
                    <?php if (!empty($adminMsg)): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($adminMsg) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($adminError)): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($adminError) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
