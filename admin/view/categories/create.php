<?php
$pageTitle = "Thêm Danh Mục Mới • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="mt-4 mb-2">
    <h1 class="h3 mb-0">Thêm Danh Mục Món Ăn Mới</h1>
    <small class="text-muted">Tạo mới phân loại món ăn cho thực đơn nhà hàng</small>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=categories">Danh Mục</a></li>
    <li class="breadcrumb-item active">Thêm Mới</li>
</ol>

<div class="card mb-4 shadow-sm" style="max-width: 680px;">
    <div class="card-header bg-white">
        <i class="fas fa-plus-circle text-primary me-1"></i>
        <strong>Biểu Mẫu Danh Mục Món Ăn</strong>
    </div>
    <div class="card-body">
        <form action="index.php?act=category-create" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Tên Danh Mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ví dụ: Lẩu Hàn Quốc, Món Khai Vị..." required autofocus />
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label fw-bold">Mã Slug (Không dấu, viết thường)</label>
                <input type="text" class="form-control" id="slug" name="slug" placeholder="Ví dụ: hotpot, bbq, pocha, drinks... (Để trống tự tạo)" />
                <small class="text-muted d-block mt-1">Dùng để phân loại và làm bộ lọc tab trên trang thực đơn</small>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-bold">Trạng Thái Hiển Thị</label>
                <select class="form-select" id="status" name="status">
                    <option value="active" selected>Hoạt động (Hiển thị cho khách xem)</option>
                    <option value="inactive">Tạm ẩn</option>
                </select>
            </div>

            <div class="pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i> Lưu Danh Mục
                </button>
                <a href="index.php?act=categories" class="btn btn-outline-secondary px-4">
                    Hủy Bỏ
                </a>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
