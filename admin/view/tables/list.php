<?php
$pageTitle = "Quản Lý Bàn Ăn & Mã QR • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <h1 class="h3 mb-0">Quản Lý Bàn Ăn & Mã QR Đặt Món</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddTable">
        <i class="fas fa-plus me-1"></i> Thêm Bàn Mới
    </button>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Bàn Ăn & Mã QR</li>
</ol>

<!-- THẺ THỐNG KÊ NHANH SB ADMIN -->
<div class="row">
    <div class="col-md-4">
        <div class="card bg-secondary text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Tổng Số Bàn</div>
                        <div class="fs-4 fw-bold mt-1"><?= intval($stats['total_tables'] ?? 0) ?> bàn</div>
                    </div>
                    <i class="fas fa-chair fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Bàn Trống (Sẵn sàng)</div>
                        <div class="fs-4 fw-bold mt-1"><?= intval($stats['available_tables'] ?? 0) ?> bàn</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-bold">Bàn Đang Có Khách</div>
                        <div class="fs-4 fw-bold mt-1"><?= intval($stats['occupied_tables'] ?? 0) ?> bàn</div>
                    </div>
                    <i class="fas fa-user-friends fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BẢNG DANH SÁCH BÀN ĂN CHUẨN SB ADMIN -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-table me-1 text-primary"></i>
            <strong>Danh Sách Bàn Ăn Trong Nhà Hàng</strong>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.reload();">
            <i class="fas fa-sync-alt me-1"></i> Làm mới
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle mb-0" id="datatablesSimple">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Tên / Số Bàn</th>
                        <th>Sức Chứa</th>
                        <th>Trạng Thái</th>
                        <th>Mã QR Đặt Món</th>
                        <th class="text-end" style="min-width: 200px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tables)): ?>
                        <?php foreach ($tables as $t): ?>
                            <?php
                                $badgeClass = 'bg-success text-white';
                                $statusText = 'Bàn Trống';
                                if ($t['status'] === 'occupied') {
                                    $badgeClass = 'bg-danger text-white';
                                    $statusText = 'Đang Phục Vụ';
                                }
                            ?>
                            <tr>
                                <td>#<?= $t['id'] ?></td>
                                <td>
                                    <strong class="fs-6"><?= htmlspecialchars($t['table_number']) ?></strong>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <i class="fas fa-user-friends me-1"></i> <?= $t['capacity'] ?> chỗ ngồi
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $badgeClass ?> px-3 py-1 rounded-pill">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?act=table-qr&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-qrcode me-1"></i> Xem & In Mã QR
                                    </a>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                        <?php if ($t['status'] === 'occupied'): ?>
                                            <a href="index.php?act=table-status&id=<?= $t['id'] ?>&status=available" class="btn btn-sm btn-outline-success" title="Mở lại bàn trống" onclick="return confirm('Chuyển bàn này về trạng thái TRỐNG?');">
                                                <i class="fas fa-unlock me-1"></i> Mở bàn trống
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?act=table-status&id=<?= $t['id'] ?>&status=occupied" class="btn btn-sm btn-outline-warning" title="Khóa bàn có khách">
                                                <i class="fas fa-lock me-1"></i> Khóa có khách
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($currentRole === 'admin'): ?>
                                            <a href="index.php?act=table-delete&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bàn này?');" title="Xóa bàn">
                                                <i class="fas fa-trash"></i>
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
                                    <i class="fas fa-chair text-secondary"></i>
                                    <div class="empty-title">Chưa có bàn ăn nào được tạo</div>
                                    <div class="empty-desc">Bấm "Thêm Bàn Ăn Mới" để tạo bàn và mã QR phục vụ thực khách.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL THÊM BÀN ĂN MỚI -->
<div class="modal fade" id="modalAddTable" tabindex="-1" aria-labelledby="modalAddTableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="index.php?act=table-add" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddTableLabel"><i class="fas fa-plus-circle me-1 text-primary"></i> Thêm Bàn Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="table_number" class="form-label fw-bold">Tên / Số Bàn <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="table_number" name="table_number" placeholder="Ví dụ: Bàn 09" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label fw-bold">Sức Chứa (Số Người) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="4" min="1" max="50" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Tạo Bàn Mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
