<?php
$pageTitle = "Quản Lý Danh Mục Món Ăn • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold text-white mb-1">Danh Mục Món Ăn</h3>
    <p class="text-white-50 small mb-0">Phân loại thực đơn phục vụ thực khách (BBQ, Lẩu, Pocha, Đồ uống...)</p>
  </div>
  <a href="index.php?act=category-create" class="btn btn-danger btn-sm rounded-pill px-3 py-2 fw-semibold">
    <i class="bi bi-plus-lg me-1"></i> Thêm Danh Mục Mới
  </a>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 70px;">ID</th>
          <th>Tên Danh Mục</th>
          <th>Slug (Mã liên kết)</th>
          <th>Số Món Ăn</th>
          <th>Trạng Thái</th>
          <th class="text-end" style="width: 150px;">Thao Tác</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($categories)): ?>
          <?php foreach ($categories as $cat): ?>
            <tr>
              <td><span class="text-white-50 fw-semibold">#<?= $cat['id'] ?></span></td>
              <td>
                <strong class="text-white fs-6"><?= htmlspecialchars($cat['name']) ?></strong>
              </td>
              <td>
                <span class="badge bg-dark border border-secondary text-warning font-monospace px-2 py-1">
                  <?= htmlspecialchars($cat['slug']) ?>
                </span>
              </td>
              <td>
                <span class="badge bg-primary bg-opacity-25 text-info px-2 py-1 rounded-pill">
                  <?= intval($cat['total_products'] ?? 0) ?> món ăn
                </span>
              </td>
              <td>
                <?php if ($cat['status'] === 'active'): ?>
                  <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1 rounded-pill">
                    Hoạt động
                  </span>
                <?php else: ?>
                  <span class="badge bg-secondary px-2 py-1 rounded-pill">Tạm ẩn</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <a href="index.php?act=category-edit&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1" title="Chỉnh sửa">
                  <i class="bi bi-pencil-square"></i> Sửa
                </a>
                <a href="index.php?act=category-delete&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');" title="Xóa">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center py-4 text-white-50">Chưa có danh mục nào được tạo.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
