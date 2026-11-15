<?php
$pageTitle = "Thêm Danh Mục Mới • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
  <a href="index.php?act=categories" class="text-white-50 text-decoration-none small">
    <i class="bi bi-arrow-left"></i> Quay lại danh sách danh mục
  </a>
  <h3 class="fw-bold text-white mt-2 mb-1">Thêm Danh Mục Món Ăn</h3>
  <p class="text-white-50 small mb-0">Tạo mới phân loại món ăn cho thực đơn nhà hàng</p>
</div>

<div class="admin-card" style="max-width: 650px;">
  <form action="index.php?act=category-create" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label text-white-50 small mb-1">Tên Danh Mục *</label>
      <input type="text" class="form-control admin-input" id="name" name="name" placeholder="Ví dụ: Lẩu Hàn Quốc, Món Khai Vị..." required autofocus />
    </div>

    <div class="mb-3">
      <label for="slug" class="form-label text-white-50 small mb-1">Mã Slug (Không dấu, viết thường)</label>
      <input type="text" class="form-control admin-input" id="slug" name="slug" placeholder="Ví dụ: hotpot, bbq, pocha, drinks... (Để trống tự tạo)" />
      <small class="text-white-50 d-block mt-1">Dùng để phân loại và làm bộ lọc tab trên trang thực đơn</small>
    </div>

    <div class="mb-4">
      <label for="status" class="form-label text-white-50 small mb-1">Trạng Thái Hiển Thị</label>
      <select class="form-select admin-select" id="status" name="status">
        <option value="active" selected>Hoạt động (Hiển thị cho khách xem)</option>
        <option value="inactive">Tạm ẩn</option>
      </select>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-danger px-4 rounded-pill fw-semibold">
        <i class="bi bi-check2-circle me-1"></i> Lưu Danh Mục
      </button>
      <a href="index.php?act=categories" class="btn btn-outline-light px-4 rounded-pill">
        Hủy Bỏ
      </a>
    </div>
  </form>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
