<?php
$pageTitle = "Quản Lý Danh Mục • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <h1 class="h3 mb-0">Danh Mục Món Ăn Thực Đơn</h1>
    <a href="index.php?act=category-create" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Thêm Danh Mục Mới
    </a>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Danh Mục Món Ăn</li>
</ol>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-th-list text-primary me-1"></i>
            <strong>Danh Sách Phân Loại Món Ăn</strong>
        </div>
        <a href="index.php?act=category-create" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus me-1"></i> Thêm mới
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle mb-0" id="datatablesSimple">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Tên Danh Mục</th>
                        <th>Slug (Mã liên kết URL)</th>
                        <th>Số Món Trong Nhóm</th>
                        <th>Trạng Thái</th>
                        <th class="text-end" style="min-width: 150px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td>#<?= $cat['id'] ?></td>
                                <td>
                                    <strong class="fs-6"><?= htmlspecialchars($cat['name']) ?></strong>
                                </td>
                                <td>
                                    <code class="text-primary font-monospace"><?= htmlspecialchars($cat['slug']) ?></code>
                                </td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill">
                                        <?= intval($cat['total_products'] ?? 0) ?> món ăn
                                    </span>
                                </td>
                                <td>
                                    <?php if ($cat['status'] === 'active'): ?>
                                        <span class="badge bg-success rounded-pill">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill">Tạm ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                        <a href="index.php?act=category-edit&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </a>
                                        <a href="index.php?act=category-delete&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-0 border-0">
                                <div class="table-empty-state">
                                    <i class="fas fa-th-list text-secondary"></i>
                                    <div class="empty-title">Chưa có danh mục món ăn nào</div>
                                    <div class="empty-desc">Bấm "Thêm Danh Mục Mới" để bắt đầu thiết lập phân loại thực đơn.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
