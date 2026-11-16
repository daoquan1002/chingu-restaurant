<?php
$pageTitle = "Phân Quyền Hệ Thống • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0">Phân Quyền Vai Trò Hệ Thống</h1>
        <small class="text-muted">Quản lý quyền hạn và phân công vai trò cho các tài khoản nội bộ</small>
    </div>
    <a href="index.php?act=users" class="btn btn-outline-primary">
        <i class="fas fa-users-cog me-1"></i> Quản Lý Tài Khoản
    </a>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=users">Tài Khoản</a></li>
    <li class="breadcrumb-item active">Phân Quyền</li>
</ol>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- 1. BẢNG MA TRẬN PHÂN QUYỀN VAI TRÒ -->
<div class="card mb-4 shadow-sm border-start border-primary border-4">
    <div class="card-header bg-white">
        <i class="fas fa-shield-alt text-primary me-1"></i>
        <strong>Ma Trận Quyền Hạn Vai Trò Trong Hệ Thống</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 250px;">Chức Năng / Module</th>
                        <th class="text-center" style="width: 200px;">
                            <span class="badge bg-danger fs-6 px-3 py-1">Admin</span>
                            <div class="small text-muted mt-1">Quản trị viên tối cao</div>
                        </th>
                        <th class="text-center" style="width: 200px;">
                            <span class="badge bg-primary fs-6 px-3 py-1">Staff / Cashier</span>
                            <div class="small text-muted mt-1">Thu ngân & phục vụ bàn</div>
                        </th>
                        <th class="text-center" style="width: 200px;">
                            <span class="badge bg-warning text-dark fs-6 px-3 py-1">Kitchen</span>
                            <div class="small text-muted mt-1">Bếp nấu & pha chế</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold"><i class="fas fa-tachometer-alt text-primary me-2"></i>Xem Bảng Điều Khiển (Dashboard) & Doanh Thu</td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="fas fa-clipboard-list text-primary me-2"></i>Tiếp Nhận, Duyệt Đơn & Theo Dõi Món</td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="fas fa-money-bill-wave text-primary me-2"></i>Xác Nhận Thu Ngân & Xuất Hóa Đơn</td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="fas fa-chair text-primary me-2"></i>Quản Lý Bàn Ăn, Mã QR & Mở Khóa Bàn</td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="fas fa-utensils text-primary me-2"></i>Thêm, Sửa, Xóa Món Ăn & Thực Đơn</td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="fas fa-users-cog text-primary me-2"></i>Quản Lý Tài Khoản & Phân Quyền Nhân Sự</td>
                        <td class="text-center text-success fs-5"><i class="fas fa-check-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                        <td class="text-center text-muted fs-5"><i class="fas fa-times-circle"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2. PHÂN BỔ VAI TRÒ CHO CÁC TÀI KHOẢN -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
        <i class="fas fa-user-tag text-primary me-1"></i>
        <strong>Cập Nhật Phân Quyền Trực Tiếp Cho Tài Khoản</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên Đăng Nhập</th>
                        <th>Họ Và Tên</th>
                        <th>Vai Trò Hiện Tại</th>
                        <th style="width: 320px;">Thay Đổi Phân Quyền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $u): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                        <i class="fas fa-user text-primary"></i>
                                        <span><?= htmlspecialchars($u['username']) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($u['fullname']) ?></td>
                                <td>
                                    <?php if ($u['role'] === 'admin'): ?>
                                        <span class="badge bg-danger px-3 py-2 fs-6">Quản Trị Viên (Admin)</span>
                                    <?php elseif ($u['role'] === 'kitchen'): ?>
                                        <span class="badge bg-warning text-dark px-3 py-2 fs-6">Bếp Nấu (Kitchen)</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary px-3 py-2 fs-6">Nhân Viên / Thu Ngân (Staff)</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($u['id'] == ($_SESSION['employee']['id'] ?? 0)): ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-light text-secondary border px-3 py-2">
                                                <i class="fas fa-lock me-1"></i> Tài khoản đang đăng nhập
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <form action="index.php?act=user-update-role" method="POST" class="d-flex align-items-center gap-2">
                                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>" />
                                            <select name="role" class="form-select form-select-sm">
                                                <option value="staff" <?= $u['role'] === 'staff' ? 'selected' : '' ?>>Staff (Thu ngân / Phục vụ)</option>
                                                <option value="kitchen" <?= $u['role'] === 'kitchen' ? 'selected' : '' ?>>Kitchen (Bếp nấu)</option>
                                                <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin (Quản trị viên)</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary text-nowrap">
                                                <i class="fas fa-check me-1"></i> Lưu
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="p-0 border-0">
                                <div class="table-empty-state">
                                    <i class="fas fa-user-shield text-secondary"></i>
                                    <div class="empty-title">Không tìm thấy tài khoản nhân viên nào</div>
                                    <div class="empty-desc">Hiện không có tài khoản nhân viên nào trong danh sách để phân quyền.</div>
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
