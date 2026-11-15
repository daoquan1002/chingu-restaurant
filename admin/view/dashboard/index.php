<?php
$pageTitle = "Tổng Quan Hệ Thống • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<!-- TIÊU ĐỀ TRANG -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold text-white mb-1">Bảng Điều Khiển</h3>
    <p class="text-white-50 small mb-0">Tổng quan hoạt động kinh doanh và trạng thái đơn món tại bàn</p>
  </div>
  <a href="index.php?act=orders" class="btn btn-danger btn-sm rounded-pill px-3 py-2 fw-semibold">
    <i class="bi bi-bell-fill me-1"></i> Xem Đơn Mới (<?= intval($orderStats['pending_orders'] ?? 0) ?>)
  </a>
</div>

<!-- 4 THẺ THỐNG KÊ TỔNG QUAN -->
<div class="row g-3 mb-4">
  <!-- Doanh thu thực tế -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="admin-card admin-stat-card">
      <div>
        <span class="text-white-50 small">Doanh Thu Đã Thu</span>
        <h4 class="text-warning fw-bold my-1"><?= number_format($orderStats['total_revenue'] ?? 0, 0, ',', '.') ?> đ</h4>
        <small class="text-success"><i class="bi bi-cash-coin me-1"></i>Thanh toán hoàn tất</small>
      </div>
      <div class="stat-icon bg-warning bg-opacity-10 text-warning">
        <i class="bi bi-wallet2"></i>
      </div>
    </div>
  </div>

  <!-- Tổng đơn hàng -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="admin-card admin-stat-card">
      <div>
        <span class="text-white-50 small">Tổng Đơn Đặt Món</span>
        <h4 class="text-white fw-bold my-1"><?= intval($orderStats['total_orders'] ?? 0) ?> đơn</h4>
        <small class="text-warning"><i class="bi bi-hourglass-split me-1"></i>Chờ xác nhận: <strong><?= intval($orderStats['pending_orders'] ?? 0) ?></strong></small>
      </div>
      <div class="stat-icon bg-danger bg-opacity-10 text-danger">
        <i class="bi bi-receipt-cutoff"></i>
      </div>
    </div>
  </div>

  <!-- Bàn đang phục vụ -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="admin-card admin-stat-card">
      <div>
        <span class="text-white-50 small">Bàn Đang Có Khách</span>
        <h4 class="text-white fw-bold my-1"><?= intval($tableStats['occupied_tables'] ?? 0) ?> / <?= intval($tableStats['total_tables'] ?? 0) ?> bàn</h4>
        <small class="text-success"><i class="bi bi-check2-circle me-1"></i>Bàn trống: <?= intval($tableStats['available_tables'] ?? 0) ?></small>
      </div>
      <div class="stat-icon bg-info bg-opacity-10 text-info">
        <i class="bi bi-shop"></i>
      </div>
    </div>
  </div>

  <!-- Món ăn trong thực đơn -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="admin-card admin-stat-card">
      <div>
        <span class="text-white-50 small">Món Ăn Hoạt Động</span>
        <h4 class="text-white fw-bold my-1"><?= intval($totalProducts) ?> món</h4>
        <small class="text-white-50"><i class="bi bi-grid me-1"></i>Trong <?= intval($totalCategories) ?> danh mục</small>
      </div>
      <div class="stat-icon bg-success bg-opacity-10 text-success">
        <i class="bi bi-egg-fried"></i>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- BẢNG ĐƠN HÀNG MỚI NHẤT CẦN XỬ LÝ -->
  <div class="col-12 col-xl-8">
    <div class="admin-card h-100">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-white mb-0">
          <i class="bi bi-clock-history text-warning me-2"></i>Đơn Hàng Mới Nhất
        </h5>
        <a href="index.php?act=orders" class="text-warning text-decoration-none small fw-semibold">
          Xem tất cả <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Mã Đơn</th>
              <th>Khách Hàng</th>
              <th>Vị Trí</th>
              <th>Tổng Tiền</th>
              <th>Trạng Thái</th>
              <th class="text-end">Hành Động</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($recentOrders)): ?>
              <?php foreach ($recentOrders as $od): ?>
                <?php
                  $badgeClass = 'badge-order-' . $od['status'];
                  $statusLabels = [
                    'pending' => 'Chờ duyệt',
                    'preparing' => 'Bếp chuẩn bị',
                    'served' => 'Đã phục vụ',
                    'completed' => 'Hoàn tất',
                    'cancelled' => 'Đã hủy'
                  ];
                ?>
                <tr>
                  <td>
                    <strong class="text-warning">#<?= htmlspecialchars($od['order_code']) ?></strong>
                    <div class="text-white-50" style="font-size: 0.75rem;">
                      <?= date('H:i d/m', strtotime($od['created_at'])) ?>
                    </div>
                  </td>
                  <td>
                    <div class="text-white fw-semibold"><?= htmlspecialchars($od['customer_name']) ?></div>
                    <?php if (!empty($od['note'])): ?>
                      <small class="text-white-50 fst-italic"><?= htmlspecialchars($od['note']) ?></small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="badge bg-dark border border-secondary text-white-50 px-2 py-1">
                      <?= htmlspecialchars($od['table_number'] ?? 'Mang về') ?>
                    </span>
                  </td>
                  <td>
                    <strong class="text-white"><?= number_format($od['total_amount'], 0, ',', '.') ?> đ</strong>
                  </td>
                  <td>
                    <span class="badge <?= $badgeClass ?> px-2 py-1 rounded-pill small">
                      <?= $statusLabels[$od['status']] ?? $od['status'] ?>
                    </span>
                  </td>
                  <td class="text-end">
                    <a href="index.php?act=order-detail&id=<?= $od['id'] ?>" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1" title="Xem chi tiết đơn">
                      <i class="bi bi-eye"></i>
                    </a>
                    <?php if ($od['status'] === 'pending'): ?>
                      <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=preparing" class="btn btn-sm btn-success rounded-pill px-2 py-1 ms-1" title="Duyệt đơn chuyển bếp">
                        <i class="bi bi-check-lg"></i> Duyệt
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-white-50">Chưa có đơn hàng nào phát sinh.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SƠ ĐỒ TRẠNG THÁI BÀN ĂN NHANH -->
  <div class="col-12 col-xl-4">
    <div class="admin-card h-100">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-white mb-0">
          <i class="bi bi-grid-3x3-gap text-warning me-2"></i>Tình Trạng Bàn
        </h5>
        <a href="index.php?act=tables" class="text-warning text-decoration-none small fw-semibold">
          Quản lý <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="row g-2">
        <?php foreach ($tables as $tbl): ?>
          <?php
            $bgBadge = 'border-success text-success';
            $stText = 'Trống';
            if ($tbl['status'] === 'occupied') {
              $bgBadge = 'border-danger text-danger bg-danger bg-opacity-10';
              $stText = 'Có khách';
            }
          ?>
          <div class="col-6">
            <div class="p-3 rounded-3 border <?= $bgBadge ?> text-center" style="background: rgba(255,255,255,0.02);">
              <div class="fw-bold fs-6 mb-1"><?= htmlspecialchars($tbl['table_number']) ?></div>
              <small class="d-block" style="font-size: 0.78rem;"><?= $stText ?> (<?= $tbl['capacity'] ?> chỗ)</small>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
