<?php
$pageTitle = "Chi Tiết Đơn Hàng #" . htmlspecialchars($order['order_code']) . " • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';

$statusMap = [
  'pending' => ['label' => 'Chờ Xác Nhận', 'class' => 'badge-order-pending', 'icon' => 'bi-hourglass-split'],
  'preparing' => ['label' => 'Bếp Đang Chuẩn Bị', 'class' => 'badge-order-preparing', 'icon' => 'bi-fire'],
  'served' => ['label' => 'Đã Phục Vụ Tại Bàn', 'class' => 'badge-order-served', 'icon' => 'bi-cup-hot'],
  'completed' => ['label' => 'Hoàn Tất Đơn', 'class' => 'badge-order-completed', 'icon' => 'bi-check-all'],
  'cancelled' => ['label' => 'Đã Hủy', 'class' => 'badge-order-cancelled', 'icon' => 'bi-x-circle']
];
$curr = $statusMap[$order['status']] ?? ['label' => $order['status'], 'class' => 'badge-secondary', 'icon' => 'bi-info'];

$step = 1;
if ($order['status'] === 'preparing') $step = 2;
elseif ($order['status'] === 'served') $step = 3;
elseif ($order['status'] === 'completed') $step = 4;
elseif ($order['status'] === 'cancelled') $step = 0;

$fillWidth = '0%';
if ($step === 2) $fillWidth = '33%';
elseif ($step === 3) $fillWidth = '66%';
elseif ($step === 4) $fillWidth = '100%';
?>

<div class="mb-4">
  <a href="index.php?act=orders" class="text-white-50 text-decoration-none small">
    <i class="bi bi-arrow-left"></i> Quay lại danh sách đơn hàng
  </a>
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
    <div>
      <h3 class="fw-bold text-white mb-0">
        Đơn Hàng: <span class="text-warning">#<?= htmlspecialchars($order['order_code']) ?></span>
      </h3>
      <p class="text-white-50 small mb-0">Thời gian tạo: <?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?></p>
    </div>
    <span class="badge <?= $curr['class'] ?> px-3 py-2 rounded-pill fs-6">
      <i class="bi <?= $curr['icon'] ?> me-1"></i> <?= $curr['label'] ?>
    </span>
  </div>
</div>

<!-- KHỐI TIẾN ĐỘ THEO DÕI ĐƠN HÀNG (STEPPER ĐỒNG BỘ) -->
<div class="admin-card mb-4 p-4 text-center">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div class="text-start">
      <span class="text-white-50 small">Tiến độ quy trình chế biến & phục vụ:</span>
      <h6 class="text-warning fw-bold mb-0">Mã đơn #<?= htmlspecialchars($order['order_code']) ?> • Bàn: <?= htmlspecialchars($order['table_number'] ?? 'Chưa chỉ định') ?></h6>
    </div>
    <div>
      <small class="text-white-50"><i class="bi bi-clock-history me-1"></i><?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?></small>
    </div>
  </div>

  <?php if ($order['status'] !== 'cancelled'): ?>
    <div class="order-progress-track position-relative my-4">
      <div class="track-step <?= $step > 1 ? 'completed' : ($step === 1 ? 'active' : '') ?>">
        <div class="step-dot"><i class="bi <?= $step > 1 ? 'bi-check-lg' : 'bi-receipt' ?>"></i></div>
        <div class="step-label">1. Tiếp nhận</div>
      </div>
      <div class="track-step <?= $step > 2 ? 'completed' : ($step === 2 ? 'active' : '') ?>">
        <div class="step-dot"><i class="bi <?= $step > 2 ? 'bi-check-lg' : 'bi-fire' ?>"></i></div>
        <div class="step-label">2. Vào bếp</div>
      </div>
      <div class="track-step <?= $step > 3 ? 'completed' : ($step === 3 ? 'active' : '') ?>">
        <div class="step-dot"><i class="bi <?= $step > 3 ? 'bi-check-lg' : 'bi-cup-hot' ?>"></i></div>
        <div class="step-label">3. Ra món / Phục vụ</div>
      </div>
      <div class="track-step <?= $step === 4 ? 'completed active' : '' ?>">
        <div class="step-dot"><i class="bi bi-check-all"></i></div>
        <div class="step-label">4. Hoàn tất</div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-danger mb-0 py-2 rounded-pill mt-3">
      <i class="bi bi-x-circle-fill me-1"></i> Đơn hàng này đã bị hủy bỏ.
    </div>
  <?php endif; ?>
</div>

<div class="row g-4">
  <!-- CỘT TRÁI: DANH SÁCH MÓN ĂN TRONG ĐƠN -->
  <div class="col-12 col-lg-8">
    <div class="admin-card mb-4">
      <h5 class="fw-bold text-white mb-3">
        <i class="bi bi-basket3 text-warning me-2"></i>Danh Sách Món Khách Đã Gọi
      </h5>

      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Tên Món Ăn</th>
              <th class="text-center" style="width: 80px;">Số Lượng</th>
              <th class="text-end" style="width: 120px;">Đơn Giá</th>
              <th class="text-end" style="width: 130px;">Thành Tiền</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orderDetails as $item): ?>
              <tr>
                <td>
                  <div class="fw-bold text-white"><?= htmlspecialchars($item['product_name']) ?></div>
                  <?php if (!empty($item['note'])): ?>
                    <small class="text-warning fst-italic">
                      <i class="bi bi-pencil-square me-1"></i>Yêu cầu: <?= htmlspecialchars($item['note']) ?>
                    </small>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <span class="badge bg-dark border border-secondary text-white px-2 py-1 fs-6">
                    x<?= intval($item['quantity']) ?>
                  </span>
                </td>
                <td class="text-end text-white-50">
                  <?= number_format($item['price'], 0, ',', '.') ?> đ
                </td>
                <td class="text-end fw-bold text-warning">
                  <?= number_format($item['subtotal'], 0, ',', '.') ?> đ
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end text-white-50 fs-6 pt-3">Tạm tính tiền món:</td>
              <td class="text-end fw-bold text-white fs-6 pt-3"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
            </tr>
            <tr>
              <td colspan="3" class="text-end text-white-50 fs-6 border-0">Phí VAT & Dịch vụ:</td>
              <td class="text-end text-success fw-bold border-0">0 đ (Miễn phí)</td>
            </tr>
            <tr>
              <td colspan="3" class="text-end text-white fw-bold fs-5 border-top border-secondary">Tổng cộng thanh toán:</td>
              <td class="text-end text-warning fw-bold fs-5 border-top border-secondary"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- CỘT PHẢI: THÔNG TIN KHÁCH HÀNG & THAO TÁC DUYỆT ĐƠN / THANH TOÁN -->
  <div class="col-12 col-lg-4">
    <!-- KHỐI THÔNG TIN KHÁCH HÀNG -->
    <div class="admin-card mb-4">
      <h5 class="fw-bold text-white mb-3">
        <i class="bi bi-person-lines-fill text-warning me-2"></i>Thông Tin Bàn & Khách
      </h5>

      <div class="text-white-50 small mb-2">
        <span>Khách hàng:</span>
        <div class="text-white fw-bold fs-6"><?= htmlspecialchars($order['customer_name']) ?></div>
      </div>

      <div class="text-white-50 small mb-2">
        <span>Vị trí phục vụ:</span>
        <div class="text-warning fw-bold fs-6">
          <i class="bi bi-shop me-1"></i> <?= htmlspecialchars($order['table_number'] ?? 'Chưa chỉ định bàn') ?>
        </div>
      </div>

      <?php if (!empty($order['note'])): ?>
        <div class="text-white-50 small mb-2">
          <span>Ghi chú đơn:</span>
          <div class="p-2 rounded-2 mt-1 text-white small" style="background: rgba(255,255,255,0.05);">
            <?= htmlspecialchars($order['note']) ?>
          </div>
        </div>
      <?php endif; ?>

      <hr class="border-secondary border-opacity-25 my-3" />

      <!-- THANH TOÁN -->
      <div class="text-white-50 small mb-2">
        <span>Trạng thái thanh toán:</span>
        <div class="mt-1">
          <?php if ($order['payment_status'] === 'paid'): ?>
            <span class="badge bg-success px-3 py-2 rounded-pill fs-6">
              <i class="bi bi-check2-circle me-1"></i> ĐÃ THANH TOÁN
            </span>
            <small class="d-block text-white-50 mt-1">Phương thức: <?= $order['payment_method'] === 'bank' ? 'Chuyển Khoản' : 'Tiền Mặt' ?></small>
          <?php else: ?>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6">
              <i class="bi bi-clock me-1"></i> CHƯA THANH TOÁN
            </span>
            <small class="d-block text-white-50 mt-1">Phương thức dự kiến: <?= $order['payment_method'] === 'bank' ? 'Chuyển Khoản' : 'Tiền Mặt' ?></small>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- KHỐI ĐIỀU KHIỂN QUẢN TRỊ BẾP & THU NGÂN -->
    <div class="admin-card">
      <h5 class="fw-bold text-white mb-3">
        <i class="bi bi-gear-wide-connected text-warning me-2"></i>Quy Trình Xử Lý
      </h5>

      <!-- Nút thao tác trạng thái đơn -->
      <div class="d-grid gap-2 mb-3">
        <?php if ($order['status'] === 'pending'): ?>
          <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=preparing&redirect=detail" class="btn btn-success py-2 rounded-pill fw-bold">
            <i class="bi bi-fire me-1"></i> 1. Xác Nhận & Chuyển Bếp
          </a>
        <?php elseif ($order['status'] === 'preparing'): ?>
          <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=served&redirect=detail" class="btn btn-info py-2 rounded-pill fw-bold text-dark">
            <i class="bi bi-cup-hot me-1"></i> 2. Đã Ra Món / Phục Vụ Xong
          </a>
        <?php elseif ($order['status'] === 'served'): ?>
          <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=completed&redirect=detail" class="btn btn-primary py-2 rounded-pill fw-bold">
            <i class="bi bi-check-all me-1"></i> 3. Hoàn Tất Đơn & Trả Bàn
          </a>
        <?php endif; ?>

        <?php if ($order['payment_status'] !== 'paid'): ?>
          <a href="index.php?act=order-payment-update&id=<?= $order['id'] ?>&pay_status=paid&method=cash" class="btn btn-warning py-2 rounded-pill fw-bold text-dark" onclick="return confirm('Xác nhận thu tiền mặt từ khách?');">
            <i class="bi bi-cash-stack me-1"></i> Ghi Nhận Thu Tiền Mặt
          </a>
          <a href="index.php?act=order-payment-update&id=<?= $order['id'] ?>&pay_status=paid&method=bank" class="btn btn-outline-info py-2 rounded-pill fw-bold" onclick="return confirm('Xác nhận khách đã chuyển khoản ngân hàng?');">
            <i class="bi bi-bank me-1"></i> Ghi Nhận Thu Chuyển Khoản
          </a>
        <?php endif; ?>

        <?php if ($order['status'] !== 'cancelled' && $order['status'] !== 'completed'): ?>
          <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=cancelled&redirect=detail" class="btn btn-outline-danger btn-sm rounded-pill mt-2" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
            <i class="bi bi-x-circle me-1"></i> Hủy Đơn Hàng Này
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
