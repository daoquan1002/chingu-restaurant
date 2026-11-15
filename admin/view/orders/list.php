<?php
$pageTitle = "Quản Lý Đơn Hàng • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <div>
    <h3 class="fw-bold text-white mb-1">Quản Lý Đơn Hàng & Bếp</h3>
    <p class="text-white-50 small mb-0">Tiếp nhận đơn từ khách tại bàn, chuyển bếp chuẩn bị, phục vụ và thanh toán</p>
  </div>
  <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-3 py-2 fw-semibold" onclick="window.location.reload();">
    <i class="bi bi-arrow-clockwise me-1"></i> Làm Mới Dữ Liệu
  </button>
</div>

<!-- CÁC TAB LỌC TRẠNG THÁI ĐƠN HÀNG -->
<div class="d-flex flex-wrap gap-2 mb-4">
  <?php
    $currentStatus = $_GET['status'] ?? '';
    $tabs = [
      '' => ['label' => 'Tất Cả Đơn', 'count' => intval($stats['total_orders'] ?? 0)],
      'pending' => ['label' => 'Chờ Xác Nhận', 'count' => intval($stats['pending_orders'] ?? 0), 'badge' => 'bg-danger'],
      'preparing' => ['label' => 'Bếp Đang Nấu', 'count' => intval($stats['preparing_orders'] ?? 0), 'badge' => 'bg-warning text-dark'],
      'served' => ['label' => 'Đã Phục Vụ', 'count' => intval($stats['served_orders'] ?? 0), 'badge' => 'bg-info text-dark'],
      'completed' => ['label' => 'Hoàn Tất', 'count' => intval($stats['completed_orders'] ?? 0), 'badge' => 'bg-success'],
    ];
  ?>
  <?php foreach ($tabs as $key => $tab): ?>
    <a
      href="index.php?act=orders<?= $key !== '' ? '&status=' . $key : '' ?>"
      class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center gap-2 <?= $currentStatus === $key ? 'btn-danger' : 'btn-outline-secondary text-white' ?>"
    >
      <span><?= $tab['label'] ?></span>
      <span class="badge rounded-pill <?= $tab['badge'] ?? 'bg-dark text-white' ?>">
        <?= $tab['count'] ?>
      </span>
    </a>
  <?php endforeach; ?>
</div>

<!-- BẢNG DANH SÁCH ĐƠN HÀNG -->
<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Mã Đơn / Thời Gian</th>
          <th>Khách Hàng</th>
          <th>Vị Trí / Bàn</th>
          <th>Tổng Tiền</th>
          <th>Trạng Thái Đơn</th>
          <th>Thanh Toán</th>
          <th class="text-end" style="width: 200px;">Hành Động</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($orders)): ?>
          <?php foreach ($orders as $od): ?>
            <?php
              $badgeClass = 'badge-order-' . $od['status'];
              $statusLabels = [
                'pending' => 'Chờ duyệt',
                'preparing' => 'Bếp đang nấu',
                'served' => 'Đã phục vụ',
                'completed' => 'Hoàn tất',
                'cancelled' => 'Đã hủy'
              ];
            ?>
            <tr>
              <td>
                <strong class="text-warning fs-6">#<?= htmlspecialchars($od['order_code']) ?></strong>
                <div class="text-white-50" style="font-size: 0.78rem;">
                  <i class="bi bi-clock me-1"></i><?= date('H:i - d/m/Y', strtotime($od['created_at'])) ?>
                </div>
              </td>
              <td>
                <div class="text-white fw-bold"><?= htmlspecialchars($od['customer_name']) ?></div>
                <?php if (!empty($od['note'])): ?>
                  <small class="text-white-50 fst-italic d-block text-truncate" style="max-width: 200px;">
                    <i class="bi bi-chat-left-dots me-1"></i><?= htmlspecialchars($od['note']) ?>
                  </small>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge bg-dark border border-secondary text-white px-2 py-1 fs-6">
                  <?= htmlspecialchars($od['table_number'] ?? 'Chưa chọn bàn') ?>
                </span>
              </td>
              <td>
                <strong class="text-warning fs-6"><?= number_format($od['total_amount'], 0, ',', '.') ?> đ</strong>
              </td>
              <td>
                <span class="badge <?= $badgeClass ?> px-3 py-1 rounded-pill small">
                  <?= $statusLabels[$od['status']] ?? $od['status'] ?>
                </span>
              </td>
              <td>
                <?php if ($od['payment_status'] === 'paid'): ?>
                  <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1 rounded-pill small">
                    <i class="bi bi-check-circle me-1"></i>Đã thu (<?= $od['payment_method'] === 'bank' ? 'CK' : 'Tiền mặt' ?>)
                  </span>
                <?php else: ?>
                  <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-2 py-1 rounded-pill small">
                    <i class="bi bi-clock me-1"></i>Chưa thu (<?= $od['payment_method'] === 'bank' ? 'CK' : 'Tiền mặt' ?>)
                  </span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <a href="index.php?act=order-detail&id=<?= $od['id'] ?>" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1" title="Chi tiết món">
                  <i class="bi bi-eye"></i> Chi tiết
                </a>

                <?php if ($od['status'] === 'pending'): ?>
                  <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=preparing" class="btn btn-sm btn-success rounded-pill px-2 py-1 ms-1" title="Xác nhận chuyển bếp">
                    <i class="bi bi-check-lg"></i> Duyệt
                  </a>
                <?php elseif ($od['status'] === 'preparing'): ?>
                  <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=served" class="btn btn-sm btn-info rounded-pill px-2 py-1 ms-1 text-dark fw-semibold" title="Báo đã phục vụ">
                    <i class="bi bi-bell"></i> Phục vụ
                  </a>
                <?php elseif ($od['status'] === 'served'): ?>
                  <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=completed" class="btn btn-sm btn-primary rounded-pill px-2 py-1 ms-1 fw-semibold" title="Hoàn tất đơn & trả bàn trống">
                    <i class="bi bi-check-all"></i> Hoàn tất
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-white-50">
              <i class="bi bi-inbox fs-2 d-block mb-2"></i>
              Không tìm thấy đơn hàng nào trong danh mục này.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
