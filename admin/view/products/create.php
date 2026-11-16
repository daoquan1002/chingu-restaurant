<?php
$pageTitle = "Thêm Món Ăn Mới • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="mt-4 mb-2">
    <h1 class="h3 mb-0">Thêm Món Ăn Mới Vào Thực Đơn</h1>
    <small class="text-muted">Nhập đầy đủ thông tin để món ăn xuất hiện trên giao diện đặt món của khách</small>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=products">Món Ăn</a></li>
    <li class="breadcrumb-item active">Thêm Mới</li>
</ol>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger py-2 rounded mb-3" style="max-width: 850px;">
        <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card mb-4 shadow-sm" style="max-width: 850px;">
    <div class="card-header bg-white">
        <i class="fas fa-plus-circle text-primary me-1"></i>
        <strong>Biểu Mẫu Thông Tin Món Ăn</strong>
    </div>
    <div class="card-body">
        <form action="index.php?act=product-create" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <!-- Tên món tiếng Việt -->
                <div class="col-md-8">
                    <label for="name" class="form-label fw-bold">Tên Món Ăn (Tiếng Việt) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ví dụ: Ba Chỉ Bò Mỹ Nướng Sốt Cay..." required autofocus />
                </div>

                <!-- Tên tiếng Hàn -->
                <div class="col-md-4">
                    <label for="korean_name" class="form-label fw-bold">Tên Tiếng Hàn (Tùy chọn)</label>
                    <input type="text" class="form-control" id="korean_name" name="korean_name" placeholder="Ví dụ: 삼겹살..." />
                </div>

                <!-- Danh mục -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-bold">Danh Mục Thực Đơn <span class="text-danger">*</span></label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Đơn giá -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-bold">Đơn Giá (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" step="1000" min="0" class="form-control" id="price" name="price" placeholder="Ví dụ: 289000" required />
                </div>

                <!-- Huy hiệu / Badge -->
                <div class="col-md-6">
                    <label for="badge" class="form-label fw-bold">Huy Hiệu Nổi Bật</label>
                    <input type="text" class="form-control" id="badge" name="badge" placeholder="Ví dụ: Best Seller, Signature, Cay Nồng..." />
                </div>

                <!-- Trạng thái -->
                <div class="col-md-6">
                    <label for="status" class="form-label fw-bold">Trạng Thái Kinh Doanh</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" selected>Đang kinh doanh (Hiển thị cho khách)</option>
                        <option value="inactive">Tạm ẩn / Tạm hết hàng</option>
                    </select>
                </div>

                <!-- Tải lên hình ảnh -->
                <div class="col-12">
                    <label for="image" class="form-label fw-bold">Hình Ảnh Món Ăn</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" />
                    <small class="text-muted">Định dạng hỗ trợ: JPG, JPEG, PNG, WEBP (Tối đa 5MB)</small>
                </div>

                <!-- Mô tả món -->
                <div class="col-12">
                    <label for="description" class="form-label fw-bold">Mô Tả Hương Vị & Thành Phần</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mô tả độ ngọt thịt, sốt ướp truyền thống, ăn kèm rau cuốn kim chi..."></textarea>
                </div>

                <!-- Nút thao tác -->
                <div class="col-12 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Lưu & Đăng Món
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
