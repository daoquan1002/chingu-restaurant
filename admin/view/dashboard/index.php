<?php
$pageTitle = "Dashboard Tổng Quan • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<h1 class="mt-4">Bảng Điều Khiển</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard Tổng Quan & Vận Hành Nhà Hàng</li>
</ol>

<!-- 4 THẺ THỐNG KÊ CHUẨN SB ADMIN -->
<div class="row">
    <!-- Thẻ 1: Doanh thu thực tế (bg-primary) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Doanh Thu Đã Thu</div>
                        <div class="fs-4 fw-bold mt-1"><?= number_format($orderStats['total_revenue'] ?? 0, 0, ',', '.') ?> đ</div>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="index.php?act=orders&status=completed">Xem chi tiết đơn hoàn tất</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Thẻ 2: Tổng đơn món (bg-warning) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Tổng Đơn Đặt Món</div>
                        <div class="fs-4 fw-bold mt-1"><?= intval($orderStats['total_orders'] ?? 0) ?> đơn</div>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-receipt fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="index.php?act=orders">Chờ duyệt: <?= intval($orderStats['pending_orders'] ?? 0) ?> đơn</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Thẻ 3: Bàn đang phục vụ (bg-success) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Bàn Đang Có Khách</div>
                        <div class="fs-4 fw-bold mt-1"><?= intval($tableStats['occupied_tables'] ?? 0) ?> / <?= intval($tableStats['total_tables'] ?? 0) ?> bàn</div>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-chair fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="index.php?act=tables">Bàn trống: <?= intval($tableStats['available_tables'] ?? 0) ?> bàn</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Thẻ 4: Món ăn hoạt động (bg-danger) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Món Ăn Thực Đơn</div>
                        <div class="fs-4 fw-bold mt-1"><?= intval($totalProducts) ?> món</div>
                    </div>
                    <div class="opacity-75">
                        <i class="fas fa-utensils fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="index.php?act=products">Trong <?= intval($totalCategories) ?> danh mục</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- CỘT TRÁI: DANH SÁCH ĐƠN HÀNG MỚI NHẤT -->
    <div class="col-xl-8">
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <div>
                    <i class="fas fa-clock text-warning me-1"></i>
                    <strong>Đơn Hàng Mới Nhất</strong>
                </div>
                <a href="index.php?act=orders" class="btn btn-sm btn-outline-primary">
                    Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách Hàng</th>
                                <th>Bàn</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th class="text-end">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentOrders)): ?>
                                <?php foreach ($recentOrders as $od): ?>
                                    <?php
                                        $badgeClass = 'badge-order-' . $od['status'];
                                        $statusLabels = [
                                            'pending' => 'Chờ duyệt',
                                            'preparing' => 'Vào bếp',
                                            'served' => 'Đã ra món',
                                            'completed' => 'Hoàn tất',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                    ?>
                                    <tr>
                                        <td>
                                            <strong class="text-primary">#<?= htmlspecialchars($od['order_code']) ?></strong>
                                            <div class="text-muted small"><?= date('H:i d/m', strtotime($od['created_at'])) ?></div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($od['customer_name']) ?></div>
                                            <?php if (!empty($od['note'])): ?>
                                                <small class="text-muted fst-italic"><?= htmlspecialchars($od['note']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($od['table_number'] ?? 'Mang về') ?></span>
                                        </td>
                                        <td>
                                            <strong class="text-danger"><?= number_format($od['total_amount'], 0, ',', '.') ?> đ</strong>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeClass ?> px-2 py-1 rounded-pill">
                                                <?= $statusLabels[$od['status']] ?? $od['status'] ?>
                                            </span>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div class="d-inline-flex align-items-center justify-content-end gap-1 flex-wrap">
                                                <a href="index.php?act=order-detail&id=<?= $od['id'] ?>" class="btn btn-sm btn-outline-primary" title="Xem chi tiết đơn">
                                                    <i class="fas fa-eye"></i> Chi tiết
                                                </a>
                                                <?php if ($od['status'] === 'pending'): ?>
                                                    <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=preparing" class="btn btn-sm btn-success" title="Duyệt chuyển bếp">
                                                        <i class="fas fa-check"></i> Duyệt
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="p-0 border-0">
                                        <div class="table-empty-state">
                                            <i class="fas fa-clipboard-check text-secondary"></i>
                                            <div class="empty-title">Chưa có đơn hàng nào hôm nay</div>
                                            <div class="empty-desc">Các đơn hàng mới phát sinh sẽ được hiển thị trực tiếp tại đây.</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- CỘT PHẢI: TÌNH TRẠNG BÀN ĂN -->
    <div class="col-xl-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <div>
                    <i class="fas fa-th-large text-warning me-1"></i>
                    <strong>Sơ Đồ Bàn Ăn Nhanh</strong>
                </div>
                <a href="index.php?act=tables" class="btn btn-sm btn-outline-secondary">
                    Quản lý <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <?php foreach ($tables as $tbl): ?>
                        <?php
                            $isOccupied = ($tbl['status'] === 'occupied');
                            $cardBorder = $isOccupied ? 'border-danger bg-danger bg-opacity-10' : 'border-success bg-success bg-opacity-10';
                            $textClass = $isOccupied ? 'text-danger' : 'text-success';
                            $stText = $isOccupied ? 'Có khách' : 'Bàn trống';
                        ?>
                        <div class="col-6">
                            <div class="p-3 rounded border <?= $cardBorder ?> text-center">
                                <div class="fw-bold fs-6 mb-1 text-dark"><?= htmlspecialchars($tbl['table_number']) ?></div>
                                <span class="badge <?= $isOccupied ? 'bg-danger' : 'bg-success' ?> mb-1"><?= $stText ?></span>
                                <div class="text-muted small"><?= $tbl['capacity'] ?> chỗ ngồi</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
