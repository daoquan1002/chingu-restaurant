<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Quản Trị Nhà Hàng Chingu BBQ' ?></title>

  <!-- Google Fonts: Be Vietnam Pro, Dancing Script, Playfair Display -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Dancing+Script:wght@600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

  <!-- SIDEBAR QUẢN TRỊ -->
  <aside class="admin-sidebar" id="adminSidebar">
    <!-- Logo Nhà hàng Chingu -->
    <a
      class="navbar-brand text-white fw-bold d-flex align-items-center gap-2 admin-brand"
      href="index.php?act=dashboard"
    >
      <span
        >CHINGU
        <small class="fw-normal text-warning">RESTAURANT</small></span
      >
    </a>

    <nav class="admin-nav">
      <a href="index.php?act=dashboard" class="admin-nav-item <?= ($act ?? '') === 'dashboard' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Tổng Quan (Dashboard)</span>
      </a>

      <a href="index.php?act=orders" class="admin-nav-item <?= strpos(($act ?? ''), 'order') !== false ? 'active' : '' ?>">
        <i class="bi bi-receipt"></i>
        <span>Quản Lý Đơn Hàng</span>
      </a>

      <a href="index.php?act=tables" class="admin-nav-item <?= strpos(($act ?? ''), 'table') !== false ? 'active' : '' ?>">
        <i class="bi bi-shop"></i>
        <span>Bàn Ăn & Mã QR</span>
      </a>

      <a href="index.php?act=products" class="admin-nav-item <?= strpos(($act ?? ''), 'product') !== false ? 'active' : '' ?>">
        <i class="bi bi-egg-fried"></i>
        <span>Quản Lý Món Ăn</span>
      </a>

      <a href="index.php?act=categories" class="admin-nav-item <?= strpos(($act ?? ''), 'categor') !== false ? 'active' : '' ?>">
        <i class="bi bi-grid-fill"></i>
        <span>Danh Mục Thực Đơn</span>
      </a>

      <div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
        <a href="../index.php?pg=menu" target="_blank" class="admin-nav-item text-white-50">
          <i class="bi bi-box-arrow-up-right"></i>
          <span>Xem Thực Đơn Khách</span>
        </a>
        <a href="index.php?act=logout" class="admin-nav-item text-danger">
          <i class="bi bi-box-arrow-right"></i>
          <span>Đăng Xuất</span>
        </a>
      </div>
    </nav>
  </aside>

  <!-- VÙNG NỘI DUNG CHÍNH -->
  <div class="admin-main-wrap">
    
    <!-- THANH TOPBAR -->
    <header class="admin-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-outline-light btn-sm d-lg-none" id="btnToggleSidebar" type="button">
          <i class="bi bi-list fs-5"></i>
        </button>
        <span class="fs-6 fw-semibold text-white d-none d-sm-inline">
          <i class="bi bi-calendar-event me-1 text-warning"></i>
          <?= date('d/m/Y') ?>
        </span>
      </div>

      <div class="d-flex align-items-center gap-3">
        <div class="text-end d-none d-sm-block">
          <div class="text-white fw-bold small"><?= htmlspecialchars($_SESSION['employee']['fullname'] ?? 'Nhân viên') ?></div>
          <small class="badge bg-danger rounded-pill px-2 py-0" style="font-size: 0.72rem;">
            <?= strtoupper(htmlspecialchars($_SESSION['employee']['role'] ?? 'staff')) ?>
          </small>
        </div>
        <a href="index.php?act=logout" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Đăng xuất">
          <i class="bi bi-power"></i>
        </a>
      </div>
    </header>

    <!-- NỘI DUNG TRANG (MAIN CONTENT CONTAINER) -->
    <main class="p-3 p-lg-4 flex-grow-1">
      <?php if (!empty($msg)): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($msg) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
