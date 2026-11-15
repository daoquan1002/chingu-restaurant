<?php
$pageTitle = "Chỉnh Sửa Món Ăn • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
  <a href="index.php?act=products" class="text-white-50 text-decoration-none small">
    <i class="bi bi-arrow-left"></i> Quay lại danh sách món ăn
  </a>
  <h3 class="fw-bold text-white mt-2 mb-1">Chỉnh Sửa: <?= htmlspecialchars($product['name']) ?></h3>
  <p class="text-white-50 small mb-0">Cập nhật thông tin giá tiền, hình ảnh và trạng thái món ăn</p>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger py-2 rounded-3 mb-3" style="max-width: 800px;">
    <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="admin-card" style="max-width: 800px;">
  <form action="index.php?act=product-edit&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
    <div class="row g-3">
      <!-- Tên món tiếng Việt -->
      <div class="col-12 col-md-8">
        <label for="name" class="form-label text-white-50 small mb-1">Tên Món Ăn (Tiếng Việt) *</label>
        <input type="text" class="form-control admin-input" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required />
      </div>

      <!-- Tên tiếng Hàn -->
      <div class="col-12 col-md-4">
        <label for="korean_name" class="form-label text-white-50 small mb-1">Tên Tiếng Hàn</label>
        <input type="text" class="form-control admin-input" id="korean_name" name="korean_name" value="<?= htmlspecialchars($product['korean_name'] ?? '') ?>" />
      </div>

      <!-- Danh mục -->
      <div class="col-12 col-md-6">
        <label for="category_id" class="form-label text-white-50 small mb-1">Danh Mục Thực Đơn *</label>
        <select class="form-select admin-select" id="category_id" name="category_id" required>
          <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $product['category_id'] == $c['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Đơn giá -->
      <div class="col-12 col-md-6">
        <label for="price" class="form-label text-white-50 small mb-1">Đơn Giá (VNĐ) *</label>
        <input type="number" step="1000" min="0" class="form-control admin-input" id="price" name="price" value="<?= intval($product['price']) ?>" required />
      </div>

      <!-- Huy hiệu / Badge -->
      <div class="col-12 col-md-6">
        <label for="badge" class="form-label text-white-50 small mb-1">Huy Hiệu Nổi Bật</label>
        <input type="text" class="form-control admin-input" id="badge" name="badge" value="<?= htmlspecialchars($product['badge'] ?? '') ?>" placeholder="Ví dụ: Best Seller, Signature..." />
      </div>

      <!-- Trạng thái -->
      <div class="col-12 col-md-6">
        <label for="status" class="form-label text-white-50 small mb-1">Trạng Thái Kinh Doanh</label>
        <select class="form-select admin-select" id="status" name="status">
          <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Đang bán (Hiển thị đặt món)</option>
          <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Tạm ngưng phục vụ</option>
          <option value="out_of_stock" <?= $product['status'] === 'out_of_stock' ? 'selected' : '' ?>>Tạm hết nguyên liệu</option>
        </select>
      </div>

      <!-- Ảnh xem trước -->
      <?php if (!empty($product['image'])): ?>
        <div class="col-12">
          <label class="form-label text-white-50 small mb-1 d-block">Ảnh Món Hiện Tại</label>
          <img src="<?= htmlspecialchars($product['image']) ?>" alt="Ảnh món" class="rounded-3 border border-secondary border-opacity-50 object-fit-cover" style="width: 120px; height: 120px;" />
        </div>
      <?php endif; ?>

      <!-- Link URL Ảnh -->
      <div class="col-12">
        <label for="image" class="form-label text-white-50 small mb-1">Đường Dẫn Ảnh (URL Trực Tiếp)</label>
        <input type="url" class="form-control admin-input" id="image" name="image" value="<?= htmlspecialchars($product['image'] ?? '') ?>" />
      </div>

      <!-- Hoặc Upload file ảnh mới -->
      <div class="col-12">
        <label for="image_file" class="form-label text-white-50 small mb-1">Thay Đổi Ảnh Bằng File Máy Tính</label>
        <input type="file" class="form-control admin-input" id="image_file" name="image_file" accept="image/*" />
      </div>

      <!-- Mô tả món ăn -->
      <div class="col-12">
        <label for="description" class="form-label text-white-50 small mb-1">Mô Tả Hương Vị & Thành Phần</label>
        <textarea class="form-control admin-textarea" id="description" name="description" rows="3"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
      </div>
    </div>

    <div class="d-flex gap-2 mt-4 pt-2 border-top border-secondary border-opacity-25">
      <button type="submit" class="btn btn-warning px-4 rounded-pill fw-semibold text-dark">
        <i class="bi bi-save me-1"></i> Cập Nhật Món Ăn
      </button>
      <a href="index.php?act=products" class="btn btn-outline-light px-4 rounded-pill">
        Hủy Bỏ
      </a>
    </div>
  </form>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
