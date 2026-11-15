<?php
$pageTitle = "Quản Lý Món Ăn • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
  <div>
    <h3 class="fw-bold text-white mb-1">Quản Lý Món Ăn Thực Đơn</h3>
    <p class="text-white-50 small mb-0">Quản lý giá, hình ảnh, mô tả và trạng thái các món nướng & lẩu</p>
  </div>
  <a href="index.php?act=product-create" class="btn btn-danger btn-sm rounded-pill px-3 py-2 fw-semibold">
    <i class="bi bi-plus-lg me-1"></i> Thêm Món Ăn Mới
  </a>
</div>

<!-- THANH TÌM KIẾM & BỘ LỌC DANH MỤC -->
<div class="admin-card mb-4 p-3">
  <form action="index.php" method="GET" class="row g-2 align-items-center">
    <input type="hidden" name="act" value="products" />
    
    <div class="col-12 col-md-5">
      <div class="input-group">
        <span class="input-group-text bg-dark border-secondary border-opacity-50 text-white-50">
          <i class="bi bi-search"></i>
        </span>
        <input
          type="text"
          name="keyword"
          class="form-control admin-input"
          placeholder="Tìm món theo tên hoặc tiếng Hàn..."
          value="<?= htmlspecialchars($keyword ?? '') ?>"
        />
      </div>
    </div>

    <div class="col-12 col-md-4">
      <select name="cat" class="form-select admin-select" onchange="this.form.submit()">
        <option value="">-- Tất cả danh mục món --</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= $c['id'] ?>" <?= (isset($categoryId) && $categoryId == $c['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12 col-md-3 d-flex gap-2">
      <button type="submit" class="btn btn-outline-warning rounded-pill px-3 py-1 flex-grow-1">
        Lọc
      </button>
      <a href="index.php?act=products" class="btn btn-outline-light rounded-pill px-3 py-1">
        Đặt Lại
      </a>
    </div>
  </form>
</div>

<!-- BẢNG DANH SÁCH MÓN ĂN -->
<div class="admin-card">
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 60px;">Món</th>
          <th>Tên Món Ăn</th>
          <th>Danh Mục</th>
          <th>Đơn Giá</th>
          <th>Huy Hiệu (Badge)</th>
          <th>Trạng Thái</th>
          <th class="text-end" style="width: 140px;">Thao Tác</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $prod): ?>
            <tr>
              <td>
                <img
                  src="<?= htmlspecialchars($prod['image'] ?: '../public/assets/images/logo.png') ?>"
                  alt="<?= htmlspecialchars($prod['name']) ?>"
                  class="rounded-3 object-fit-cover border border-secondary border-opacity-25"
                  style="width: 52px; height: 52px;"
                />
              </td>
              <td>
                <div class="fw-bold text-white fs-6"><?= htmlspecialchars($prod['name']) ?></div>
                <?php if (!empty($prod['korean_name'])): ?>
                  <small class="text-warning font-monospace" style="font-size: 0.8rem;"><?= htmlspecialchars($prod['korean_name']) ?></small>
                <?php endif; ?>
                <div class="text-white-50 text-truncate mt-1" style="max-width: 280px; font-size: 0.78rem;">
                  <?= htmlspecialchars($prod['description'] ?? '') ?>
                </div>
              </td>
              <td>
                <span class="badge bg-dark border border-secondary text-white-50 px-2 py-1">
                  <?= htmlspecialchars($prod['category_name']) ?>
                </span>
              </td>
              <td>
                <strong class="text-warning fs-6"><?= number_format($prod['price'], 0, ',', '.') ?> đ</strong>
              </td>
              <td>
                <?php if (!empty($prod['badge'])): ?>
                  <span class="badge bg-danger rounded-pill px-2 py-1 small"><?= htmlspecialchars($prod['badge']) ?></span>
                <?php else: ?>
                  <span class="text-white-50 small">--</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($prod['status'] === 'active'): ?>
                  <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1 rounded-pill">
                    Đang bán
                  </span>
                <?php else: ?>
                  <span class="badge bg-secondary px-2 py-1 rounded-pill">Hết hàng / Ẩn</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <a href="index.php?act=product-edit&id=<?= $prod['id'] ?>" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1" title="Sửa món">
                  <i class="bi bi-pencil-square"></i> Sửa
                </a>
                <a href="index.php?act=product-delete&id=<?= $prod['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Bạn có chắc muốn xóa món ăn này khỏi thực đơn?');" title="Xóa món">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center py-4 text-white-50">Không tìm thấy món ăn nào phù hợp.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
