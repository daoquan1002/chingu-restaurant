<?php
$pageTitle = "Chi Tiết Đơn Hàng #" . htmlspecialchars($order['order_code']) . " • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';

$statusMap = [
  'pending' => ['label' => 'Chờ Xác Nhận', 'class' => 'bg-warning text-dark', 'icon' => 'fas fa-hourglass-half'],
  'preparing' => ['label' => 'Bếp Đang Nấu', 'class' => 'bg-info text-dark', 'icon' => 'fas fa-fire'],
  'served' => ['label' => 'Đã Ra Món', 'class' => 'bg-primary text-white', 'icon' => 'fas fa-concierge-bell'],
  'completed' => ['label' => 'Hoàn Tất Đơn', 'class' => 'bg-success text-white', 'icon' => 'fas fa-check-double'],
  'cancelled' => ['label' => 'Đã Hủy', 'class' => 'bg-danger text-white', 'icon' => 'fas fa-times-circle']
];
$curr = $statusMap[$order['status']] ?? ['label' => $order['status'], 'class' => 'bg-secondary text-white', 'icon' => 'fas fa-info-circle'];

$step = 1;
if ($order['status'] === 'preparing') $step = 2;
elseif ($order['status'] === 'served') $step = 3;
elseif ($order['status'] === 'completed') $step = 4;
elseif ($order['status'] === 'cancelled') $step = 0;
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0">
            Đơn Hàng: <span class="text-primary">#<?= htmlspecialchars($order['order_code']) ?></span>
        </h1>
        <small class="text-muted">Thời gian tạo: <?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?></small>
    </div>
    <div>
        <span class="badge <?= $curr['class'] ?> px-3 py-2 fs-6">
            <i class="<?= $curr['icon'] ?> me-1"></i> <?= $curr['label'] ?>
        </span>
    </div>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=orders">Đơn Hàng</a></li>
    <li class="breadcrumb-item active">#<?= htmlspecialchars($order['order_code']) ?></li>
</ol>

<!-- KHỐI TIẾN ĐỘ THEO DÕI ĐƠN HÀNG (STEPPER CHUẨN SB ADMIN CARD) -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-tasks text-primary me-1"></i>
            <strong>Tiến Độ Quy Trình Phục Vụ Bếp</strong> (Mã đơn: #<?= htmlspecialchars($order['order_code']) ?> • Bàn: <?= htmlspecialchars($order['table_number'] ?? 'Chưa chỉ định') ?>)
        </div>
        <div class="text-muted small">
            <i class="far fa-clock me-1"></i><?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?>
        </div>
    </div>
    <div class="card-body text-center py-4">
        <?php if ($order['status'] !== 'cancelled'): ?>
            <div class="order-progress-track position-relative my-2">
                <div class="track-step <?= $step > 1 ? 'completed' : ($step === 1 ? 'active' : '') ?>">
                    <div class="step-dot"><i class="fas <?= $step > 1 ? 'fa-check' : 'fa-receipt' ?>"></i></div>
                    <div class="step-label">1. Tiếp nhận</div>
                </div>
                <div class="track-step <?= $step > 2 ? 'completed' : ($step === 2 ? 'active' : '') ?>">
                    <div class="step-dot"><i class="fas <?= $step > 2 ? 'fa-check' : 'fa-fire' ?>"></i></div>
                    <div class="step-label">2. Vào bếp</div>
                </div>
                <div class="track-step <?= $step > 3 ? 'completed' : ($step === 3 ? 'active' : '') ?>">
                    <div class="step-dot"><i class="fas <?= $step > 3 ? 'fa-check' : 'fa-concierge-bell' ?>"></i></div>
                    <div class="step-label">3. Ra món / Phục vụ</div>
                </div>
                <div class="track-step <?= $step === 4 ? 'completed active' : '' ?>">
                    <div class="step-dot"><i class="fas fa-check-double"></i></div>
                    <div class="step-label">4. Hoàn tất</div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger mb-0 py-2 rounded">
                <i class="fas fa-times-circle me-1"></i> Đơn hàng này đã bị hủy bỏ bởi quản lý.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- THANH THAO TÁC QUY TRÌNH XỬ LÝ & THU NGÂN (NẰM NGANG ĐỒNG BỘ) -->
<div class="card mb-4 shadow-sm border-start border-primary border-4">
    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-cogs text-primary me-1"></i>
            <strong>Quy Trình Xử Lý & Thu Ngân</strong>
        </div>
        <span class="text-muted small">Thao tác nhanh đơn #<?= htmlspecialchars($order['order_code']) ?></span>
    </div>
    <div class="card-body py-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <!-- Nhóm nút chuyển bước tiến trình & thu ngân -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <?php if ($order['status'] === 'pending'): ?>
                    <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=preparing&redirect=detail" class="btn btn-success fw-semibold d-inline-flex align-items-center px-3 py-2">
                        <i class="fas fa-fire me-1"></i> 1. Xác Nhận & Chuyển Bếp
                    </a>
                <?php elseif ($order['status'] === 'preparing'): ?>
                    <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=served&redirect=detail" class="btn btn-info fw-semibold text-dark d-inline-flex align-items-center px-3 py-2">
                        <i class="fas fa-concierge-bell me-1"></i> 2. Đã Ra Món / Phục Vụ
                    </a>
                <?php elseif ($order['status'] === 'served' && $currentRole !== 'kitchen'): ?>
                    <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=completed&redirect=detail" class="btn btn-primary fw-semibold d-inline-flex align-items-center px-3 py-2">
                        <i class="fas fa-check-double me-1"></i> 3. Hoàn Tất Đơn & Trả Bàn
                    </a>
                <?php elseif ($order['status'] === 'completed'): ?>
                    <span class="badge bg-success py-2 px-3 fs-6 d-inline-flex align-items-center">
                        <i class="fas fa-check-circle me-1"></i> Đơn Đã Hoàn Tất
                    </span>
                <?php endif; ?>

                <?php if ($currentRole !== 'kitchen'): ?>
                    <?php if ($order['payment_status'] !== 'paid' && $order['status'] !== 'cancelled'): ?>
                        <a href="index.php?act=order-payment-update&id=<?= $order['id'] ?>&pay_status=paid&method=cash" class="btn btn-warning fw-semibold text-dark d-inline-flex align-items-center px-3 py-2" onclick="return confirm('Xác nhận thu tiền mặt từ khách?');">
                            <i class="fas fa-money-bill-wave me-1"></i> Ghi Nhận Thu Tiền Mặt
                        </a>
                        <a href="index.php?act=order-payment-update&id=<?= $order['id'] ?>&pay_status=paid&method=bank" class="btn btn-outline-primary fw-semibold d-inline-flex align-items-center px-3 py-2" onclick="return confirm('Xác nhận khách đã chuyển khoản ngân hàng?');">
                            <i class="fas fa-university me-1"></i> Ghi Nhận Thu Chuyển Khoản
                        </a>
                    <?php elseif ($order['payment_status'] === 'paid'): ?>
                        <span class="badge bg-success-subtle text-success border border-success py-2 px-3 fs-6 d-inline-flex align-items-center">
                            <i class="fas fa-wallet me-1"></i> Đã Thu Đủ Tiền (<?= $order['payment_method'] === 'bank' ? 'Chuyển Khoản' : 'Tiền Mặt' ?>)
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Nhóm nút hủy đơn & điều hướng -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <?php if ($currentRole !== 'kitchen' && $order['status'] !== 'cancelled' && $order['status'] !== 'completed'): ?>
                    <a href="index.php?act=order-status-update&id=<?= $order['id'] ?>&status=cancelled&redirect=detail" class="btn btn-outline-danger fw-semibold d-inline-flex align-items-center px-3 py-2" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                        <i class="fas fa-times-circle me-1"></i> Hủy Đơn Hàng
                    </a>
                <?php endif; ?>

                <a href="index.php?act=orders" class="btn btn-outline-secondary fw-semibold d-inline-flex align-items-center px-3 py-2">
                    <i class="fas fa-arrow-left me-1"></i> Danh Sách Đơn
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- CỘT TRÁI: DANH SÁCH MÓN ĂN TRONG ĐƠN -->
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <i class="fas fa-utensils text-primary me-1"></i>
                <strong>Danh Sách Món Ăn Khách Đã Gọi</strong>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tên Món Ăn</th>
                                <th class="text-center" style="width: 100px;">Số Lượng</th>
                                <th class="text-end" style="width: 130px;">Đơn Giá</th>
                                <th class="text-end" style="width: 140px;">Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orderDetails)): ?>
                                <?php foreach ($orderDetails as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($item['product_name']) ?></div>
                                            <?php if (!empty($item['note'])): ?>
                                                <small class="text-warning fst-italic">
                                                    <i class="far fa-edit me-1"></i>Yêu cầu: <?= htmlspecialchars($item['note']) ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary fs-6">
                                                x<?= intval($item['quantity']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end text-muted">
                                            <?= number_format($item['price'], 0, ',', '.') ?> đ
                                        </td>
                                        <td class="text-end fw-bold text-danger">
                                            <?= number_format($item['subtotal'], 0, ',', '.') ?> đ
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="p-0 border-0">
                                        <div class="table-empty-state">
                                            <i class="fas fa-receipt text-secondary"></i>
                                            <div class="empty-title">Không có chi tiết món ăn</div>
                                            <div class="empty-desc">Đơn hàng này hiện chưa có danh sách món ăn chi tiết.</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end text-muted">Tạm tính tiền món:</td>
                                <td class="text-end fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-muted border-0">Phí VAT & Dịch vụ:</td>
                                <td class="text-end text-success fw-bold border-0">0 đ (Miễn phí)</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-5">Tổng cộng thanh toán:</td>
                                <td class="text-end text-danger fw-bold fs-5"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CỘT PHẢI: THÔNG TIN KHÁCH HÀNG & THAO TÁC XỬ LÝ -->
    <div class="col-lg-4">
        <!-- Khối Thông Tin Bàn & Khách -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <i class="fas fa-info-circle text-primary me-1"></i>
                <strong>Thông Tin Bàn & Khách Hàng</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="text-muted small d-block">Khách hàng:</span>
                    <strong class="fs-6"><?= htmlspecialchars($order['customer_name']) ?></strong>
                </div>

                <div class="mb-3">
                    <span class="text-muted small d-block">Vị trí phục vụ:</span>
                    <strong class="text-primary fs-6">
                        <i class="fas fa-chair me-1"></i> <?= htmlspecialchars($order['table_number'] ?? 'Chưa chỉ định bàn') ?>
                    </strong>
                </div>

                <?php if (!empty($order['note'])): ?>
                    <div class="mb-3">
                        <span class="text-muted small d-block">Ghi chú của khách:</span>
                        <div class="p-2 bg-light rounded border text-muted small mt-1">
                            <?= htmlspecialchars($order['note']) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <hr />

                <div>
                    <span class="text-muted small d-block mb-1">Trạng thái thanh toán:</span>
                    <?php if ($order['payment_status'] === 'paid'): ?>
                        <span class="badge bg-success px-3 py-2 fs-6">
                            <i class="fas fa-check-circle me-1"></i> ĐÃ THANH TOÁN
                        </span>
                        <div class="text-muted small mt-1">Phương thức: <?= $order['payment_method'] === 'bank' ? 'Chuyển Khoản' : 'Tiền Mặt' ?></div>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                            <i class="far fa-clock me-1"></i> CHƯA THANH TOÁN
                        </span>
                        <div class="text-muted small mt-1">Phương thức dự kiến: <?= $order['payment_method'] === 'bank' ? 'Chuyển Khoản' : 'Tiền Mặt' ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
