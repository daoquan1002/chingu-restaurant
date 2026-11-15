<?php
$pageTitle = "Quản Lý Bàn Ăn & Mã QR • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <div>
    <h3 class="fw-bold text-white mb-1">Quản Lý Bàn Ăn & Mã QR Đặt Món</h3>
    <p class="text-white-50 small mb-0">Theo dõi trạng thái bàn (Trống / Đang phục vụ) và tạo mã QR cho từng bàn</p>
  </div>
  <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddTable">
    <i class="bi bi-plus-lg me-1"></i> Thêm Bàn Mới
  </button>
</div>

<!-- THẺ THỐNG KÊ NHANH -->
<div class="row g-3 mb-4">
  <div class="col-12 col-md-4">
    <div class="admin-card text-center p-3">
      <div class="text-white fs-4 fw-bold"><?= intval($stats['total_tables'] ?? 0) ?></div>
      <small class="text-white-50">Tổng Số Bàn</small>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="admin-card text-center p-3">
      <div class="text-success fs-4 fw-bold"><?= intval($stats['available_tables'] ?? 0) ?></div>
      <small class="text-white-50">Bàn Đang Trống (Sẵn sàng)</small>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="admin-card text-center p-3">
      <div class="text-danger fs-4 fw-bold"><?= intval($stats['occupied_tables'] ?? 0) ?></div>
      <small class="text-white-50">Bàn Đang Phục Vụ (Có khách)</small>
    </div>
  </div>
</div>

<!-- BẢNG DANH SÁCH BÀN ĂN -->
<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 70px;">ID</th>
          <th>Tên / Số Bàn</th>
          <th>Sức Chứa</th>
          <th>Trạng Thái</th>
          <th>Mã QR Đặt Món</th>
          <th class="text-end" style="width: 220px;">Đổi Trạng Thái / Xóa</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($tables)): ?>
          <?php foreach ($tables as $t): ?>
            <?php
              $badgeClass = 'bg-success text-white';
              $statusText = 'Bàn Trống (Sẵn sàng)';
              if ($t['status'] === 'occupied') {
                $badgeClass = 'bg-danger text-white';
                $statusText = 'Đang Phục Vụ';
              }
            ?>
            <tr>
              <td><span class="text-white-50">#<?= $t['id'] ?></span></td>
              <td>
                <strong class="text-white fs-6"><?= htmlspecialchars($t['table_number']) ?></strong>
              </td>
              <td>
                <span class="text-white-50">
                  <i class="bi bi-people me-1"></i> <?= $t['capacity'] ?> Chỗ ngồi
                </span>
              </td>
              <td>
                <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1">
                  <?= $statusText ?>
                </span>
              </td>
              <td>
                <a href="index.php?act=table-qr&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1">
                  <i class="bi bi-qr-code me-1"></i> Xem Mã QR
                </a>
              </td>
              <td class="text-end">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-light dropdown-toggle rounded-pill px-2 py-1" data-bs-toggle="dropdown" aria-expanded="false">
                    Trạng Thái
                  </button>
                  <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                    <li><a class="dropdown-item text-success" href="index.php?act=table-status&id=<?= $t['id'] ?>&status=available"><i class="bi bi-check-circle me-1"></i> Đặt thành Trống</a></li>
                    <li><a class="dropdown-item text-danger" href="index.php?act=table-status&id=<?= $t['id'] ?>&status=occupied"><i class="bi bi-person-fill me-1"></i> Đặt Có khách</a></li>
                  </ul>
                </div>
                <a href="index.php?act=table-delete&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Bạn có chắc chắn muốn xóa bàn này?');" title="Xóa bàn">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center py-4 text-white-50">Chưa có bàn nào trong hệ thống.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL THÊM BÀN ĂN MỚI -->
<div class="modal fade" id="modalAddTable" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #1c1819; border: 1px solid rgba(255,255,255,0.15);">
      <div class="modal-header border-secondary border-opacity-25">
        <h5 class="modal-title text-white fw-bold"><i class="bi bi-plus-circle text-danger me-2"></i>Thêm Bàn Ăn Mới</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="index.php?act=table-create" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="table_number" class="form-label text-white-50 small mb-1">Tên / Số Bàn *</label>
            <input type="text" class="form-control admin-input" id="table_number" name="table_number" placeholder="Ví dụ: Bàn 09, VIP 01..." required />
          </div>
          <div class="mb-3">
            <label for="capacity" class="form-label text-white-50 small mb-1">Số Chỗ Ngồi</label>
            <input type="number" class="form-control admin-input" id="capacity" name="capacity" value="4" min="1" max="50" required />
          </div>
          <div class="mb-3">
            <label for="status" class="form-label text-white-50 small mb-1">Trạng Thái Ban Đầu</label>
            <select class="form-select admin-select" id="status" name="status">
              <option value="available" selected>Trống (Sẵn sàng đón khách)</option>
              <option value="occupied">Đang có khách</option>
            </select>
          </div>
        </div>
        <div class="modal-footer border-secondary border-opacity-25">
          <button type="button" class="btn btn-outline-light rounded-pill px-3" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Lưu Bàn Ăn</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
