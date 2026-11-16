<?php
$pageTitle = "Chỉnh Sửa Danh Mục • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="mt-4 mb-2">
    <h1 class="h3 mb-0">Chỉnh Sửa Danh Mục: <?= htmlspecialchars($category['name']) ?></h1>
    <small class="text-muted">Cập nhật thông tin phân loại thực đơn</small>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=categories">Danh Mục</a></li>
    <li class="breadcrumb-item active">Sửa #<?= $category['id'] ?></li>
</ol>

<div class="card mb-4 shadow-sm" style="max-width: 680px;">
    <div class="card-header bg-white">
        <i class="fas fa-edit text-primary me-1"></i>
        <strong>Cập Nhật Thông Tin Danh Mục</strong>
    </div>
    <div class="card-body">
        <form action="index.php?act=category-edit&id=<?= $category['id'] ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Tên Danh Mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($category['name']) ?>" required />
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label fw-bold">Mã Slug (Không dấu, viết thường)</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<?= htmlspecialchars($category['slug']) ?>" />
                <small class="text-muted d-block mt-1">Dùng để phân loại tab trên trang thực đơn</small>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-bold">Trạng Thái Hiển Thị</label>
                <select class="form-select" id="status" name="status">
                    <option value="active" <?= $category['status'] === 'active' ? 'selected' : '' ?>>Hoạt động (Hiển thị cho khách xem)</option>
                    <option value="inactive" <?= $category['status'] === 'inactive' ? 'selected' : '' ?>>Tạm ẩn</option>
                </select>
            </div>

            <div class="pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i> Cập Nhật Danh Mục
                </button>
                <a href="index.php?act=categories" class="btn btn-outline-secondary px-4">
                    Hủy Bỏ
                </a>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
