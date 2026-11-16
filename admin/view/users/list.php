<?php
$pageTitle = "Quản Lý Tài Khoản • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0">Quản Lý Tài Khoản Hệ Thống</h1>
        <small class="text-muted">Danh sách tài khoản nhân viên, thu ngân và quản trị viên</small>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUser">
        <i class="fas fa-user-plus me-1"></i> Thêm Tài Khoản Mới
    </button>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Quản Lý Tài Khoản</li>
</ol>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- BẢNG DANH SÁCH TÀI KHOẢN -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-users-cog text-primary me-1"></i>
            <strong>Danh Sách Tài Khoản Nhân Viên (<?= count($employees ?? []) ?> tài khoản)</strong>
        </div>
        <a href="index.php?act=roles" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-user-shield me-1"></i> Bảng Phân Quyền
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle mb-0" id="datatablesSimple">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;" class="text-center">#</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Họ Và Tên</th>
                        <th>Vai Trò Phân Quyền</th>
                        <th>Ngày Tạo</th>
                        <th class="text-end" style="width: 140px; min-width: 140px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $u): ?>
                            <tr>
                                <td class="text-center text-muted fw-bold"><?= $u['id'] ?></td>
                                <td>
                                    <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                        <i class="fas fa-user-circle text-primary"></i>
                                        <span><?= htmlspecialchars($u['username']) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($u['fullname']) ?></td>
                                <td>
                                    <?php if ($u['role'] === 'admin'): ?>
                                        <span class="badge bg-danger px-3 py-2 fs-6">
                                            <i class="fas fa-shield-alt me-1"></i> Quản Trị Viên (Admin)
                                        </span>
                                    <?php elseif ($u['role'] === 'kitchen'): ?>
                                        <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                                            <i class="fas fa-fire me-1"></i> Bếp Nấu (Kitchen)
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary px-3 py-2 fs-6">
                                            <i class="fas fa-user-tag me-1"></i> Nhân Viên / Thu Ngân (Staff)
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small">
                                    <i class="far fa-clock me-1"></i>
                                    <?= date('H:i - d/m/Y', strtotime($u['created_at'])) ?>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                        <a href="index.php?act=roles" class="btn btn-sm btn-outline-primary" title="Cập nhật vai trò phân quyền">
                                            <i class="fas fa-user-shield me-1"></i> Phân quyền
                                        </a>
                                        <?php if ($u['id'] != ($_SESSION['employee']['id'] ?? 0)): ?>
                                            <a href="index.php?act=user-delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa tài khoản <?= htmlspecialchars($u['username']) ?>?');" title="Xóa tài khoản">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-secondary" disabled title="Tài khoản đang đăng nhập">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-0 border-0">
                                <div class="table-empty-state">
                                    <i class="fas fa-users text-secondary"></i>
                                    <div class="empty-title">Chưa có tài khoản nhân viên nào</div>
                                    <div class="empty-desc">Bấm "Thêm Tài Khoản Mới" để cấp tài khoản truy cập hệ thống.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL THÊM TÀI KHOẢN MỚI -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalAddUserLabel">
                    <i class="fas fa-user-plus me-1 text-warning"></i> Thêm Tài Khoản Nhân Viên
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?act=user-create" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tên Đăng Nhập <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Ví dụ: nhanvien1, thungan2" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Mật Khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Họ Và Tên Đầy Đủ <span class="text-danger">*</span></label>
                        <input type="text" name="fullname" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Vai Trò Phân Quyền <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="staff">Nhân Viên / Thu Ngân (Staff)</option>
                            <option value="kitchen">Bếp Nấu / Pha Chế (Kitchen)</option>
                            <option value="admin">Quản Trị Viên Toàn Quyền (Admin)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Lưu Tài Khoản
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
