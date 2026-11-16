<?php
$pageTitle = "Chỉnh Sửa Món Ăn • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="mt-4 mb-2">
    <h1 class="h3 mb-0">Chỉnh Sửa: <?= htmlspecialchars($product['name']) ?></h1>
    <small class="text-muted">Cập nhật thông tin giá tiền, hình ảnh và trạng thái món ăn</small>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=products">Món Ăn</a></li>
    <li class="breadcrumb-item active">Chỉnh Sửa #<?= $product['id'] ?></li>
</ol>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger py-2 rounded mb-3" style="max-width: 850px;">
        <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm" style="max-width: 850px;">
    <div class="card-header bg-white">
        <i class="fas fa-edit text-primary me-1"></i>
        <strong>Cập Nhật Thông Tin Món Ăn</strong>
    </div>
    <div class="card-body">
        <form action="index.php?act=product-edit&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <!-- Tên món tiếng Việt -->
                <div class="col-md-8">
                    <label for="name" class="form-label fw-bold">Tên Món Ăn (Tiếng Việt) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required />
                </div>

                <!-- Tên tiếng Hàn -->
                <div class="col-md-4">
                    <label for="korean_name" class="form-label fw-bold">Tên Tiếng Hàn</label>
                    <input type="text" class="form-control" id="korean_name" name="korean_name" value="<?= htmlspecialchars($product['korean_name'] ?? '') ?>" />
                </div>

                <!-- Danh mục -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-bold">Danh Mục Thực Đơn <span class="text-danger">*</span></label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $product['category_id'] == $c['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Đơn giá -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-bold">Đơn Giá (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" step="1000" min="0" class="form-control" id="price" name="price" value="<?= intval($product['price']) ?>" required />
                </div>

                <!-- Huy hiệu / Badge -->
                <div class="col-md-6">
                    <label for="badge" class="form-label fw-bold">Huy Hiệu Nổi Bật</label>
                    <input type="text" class="form-control" id="badge" name="badge" value="<?= htmlspecialchars($product['badge'] ?? '') ?>" placeholder="Ví dụ: Best Seller, Signature..." />
                </div>

                <!-- Trạng thái -->
                <div class="col-md-6">
                    <label for="status" class="form-label fw-bold">Trạng Thái Kinh Doanh</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Đang kinh doanh (Hiển thị cho khách)</option>
                        <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Tạm ẩn / Tạm hết hàng</option>
                    </select>
                </div>

                <!-- Hình ảnh hiện tại & thay thế -->
                <div class="col-12">
                    <label class="form-label fw-bold d-block">Hình Ảnh Món Ăn</label>
                    <?php if (!empty($product['image'])): ?>
                        <div class="mb-2">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Ảnh hiện tại" class="admin-prod-thumb" style="width: 70px; height: 70px;" />
                            <small class="text-muted ms-2">(Ảnh hiện tại)</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" />
                    <small class="text-muted">Chọn tệp ảnh mới nếu muốn thay đổi ảnh đại diện món ăn</small>
                </div>

                <!-- Mô tả món -->
                <div class="col-12">
                    <label for="description" class="form-label fw-bold">Mô Tả Hương Vị & Thành Phần</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>

                <!-- Nút thao tác -->
                <div class="col-12 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Lưu Thay Đổi
                    </button>
                    <a href="index.php?act=products" class="btn btn-outline-secondary px-4">
                        Hủy Bỏ
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
