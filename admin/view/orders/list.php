<?php
$pageTitle = "Quản Lý Đơn Hàng • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<h1 class="mt-4">Quản Lý Đơn Hàng & Bếp</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Quản Lý Đơn Hàng</li>
</ol>

<!-- CÁC TAB LỌC TRẠNG THÁI ĐƠN HÀNG -->
<div class="d-flex flex-wrap gap-2 mb-4" id="orderStatusTabs">
    <?php
        $currentStatus = $_GET['status'] ?? '';
        $tabs = [
            '' => ['label' => 'Tất Cả Đơn', 'count' => intval($stats['total_orders'] ?? 0)],
            'pending' => ['label' => 'Chờ Xác Nhận', 'count' => intval($stats['pending_orders'] ?? 0), 'badge' => 'bg-warning text-dark'],
            'preparing' => ['label' => 'Bếp Đang Nấu', 'count' => intval($stats['preparing_orders'] ?? 0), 'badge' => 'bg-info text-dark'],
            'served' => ['label' => 'Đã Phục Vụ', 'count' => intval($stats['served_orders'] ?? 0), 'badge' => 'bg-primary text-white'],
            'completed' => ['label' => 'Hoàn Tất', 'count' => intval($stats['completed_orders'] ?? 0), 'badge' => 'bg-success text-white'],
        ];
    ?>
    <?php foreach ($tabs as $key => $tab): ?>
        <a
            href="index.php?act=orders<?= $key !== '' ? '&status=' . $key : '' ?>"
            class="btn btn-sm <?= $currentStatus === $key ? 'btn-primary' : 'btn-outline-secondary' ?> d-flex align-items-center gap-2"
        >
            <span><?= $tab['label'] ?></span>
            <span class="badge rounded-pill <?= $tab['badge'] ?? 'bg-secondary' ?>">
                <?= $tab['count'] ?>
            </span>
        </a>
    <?php endforeach; ?>
</div>

<!-- BẢNG DANH SÁCH ĐƠN HÀNG CHUẨN SB ADMIN CARD -->
<div class="card mb-4 shadow-sm" id="orderTableCard">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <i class="fas fa-clipboard-list text-primary me-1"></i>
            <strong>Danh Sách Đơn Hàng Tại Bàn</strong>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-light text-dark border d-flex align-items-center gap-1 py-2 px-3 small">
                <i class="fas fa-sync-alt fa-spin text-primary" id="refreshSpinner"></i>
                <span>Tự làm mới: <strong id="refreshCountdown" class="text-danger">5</strong>s</span>
            </span>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnToggleAutoRefresh" title="Tạm dừng hoặc tiếp tục tự động làm mới">
                <i class="fas fa-pause me-1" id="pauseIcon"></i> <span id="pauseText">Tạm dừng</span>
            </button>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btnManualRefresh" title="Làm mới ngay lập tức">
                <i class="fas fa-redo me-1"></i> Làm mới ngay
            </button>
        </div>
    </div>
    <div class="card-body" id="orderTableContainer">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle mb-0" id="datatablesSimple">
                <thead class="table-light">
                    <tr>
                        <th>Mã Đơn / Thời Gian</th>
                        <th>Khách Hàng</th>
                        <th>Vị Trí / Bàn</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái Đơn</th>
                        <th>Thanh Toán</th>
                        <th class="text-end" style="width: 170px; min-width: 170px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $od): ?>
                            <?php
                                $badgeClass = 'badge-order-' . $od['status'];
                                $statusLabels = [
                                    'pending' => 'Chờ duyệt',
                                    'preparing' => 'Bếp đang nấu',
                                    'served' => 'Đã phục vụ',
                                    'completed' => 'Hoàn tất',
                                    'cancelled' => 'Đã hủy'
                                ];
                                $orderTimestamp = strtotime($od['created_at']);
                                $isRecentOrder = (time() - $orderTimestamp <= 300 && $od['status'] === 'pending');
                            ?>
                            <tr class="order-row <?= $isRecentOrder ? 'table-row-new-order' : '' ?>" data-order-id="<?= $od['id'] ?>" data-order-code="<?= htmlspecialchars($od['order_code']) ?>">
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <strong class="text-primary fs-6">#<?= htmlspecialchars($od['order_code']) ?></strong>
                                        <?php if ($isRecentOrder): ?>
                                            <span class="badge bg-danger badge-new-pulse"><i class="fas fa-bell me-1"></i> MỚI</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="far fa-clock me-1"></i><?= date('H:i - d/m/Y', $orderTimestamp) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($od['customer_name']) ?></div>
                                    <?php if (!empty($od['note'])): ?>
                                        <small class="text-muted fst-italic d-block text-truncate" style="max-width: 220px;">
                                            <i class="far fa-comment-dots me-1"></i><?= htmlspecialchars($od['note']) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary px-2 py-1">
                                        <?= htmlspecialchars($od['table_number'] ?? 'Chưa chọn bàn') ?>
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-danger"><?= number_format($od['total_amount'], 0, ',', '.') ?> đ</strong>
                                </td>
                                <td>
                                    <span class="badge <?= $badgeClass ?> px-2 py-1 rounded-pill">
                                        <?= $statusLabels[$od['status']] ?? $od['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($od['payment_status'] === 'paid'): ?>
                                        <span class="badge bg-success text-white">
                                            <i class="fas fa-check-circle me-1"></i>Đã thu (<?= $od['payment_method'] === 'bank' ? 'CK' : 'Tiền mặt' ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="far fa-clock me-1"></i>Chưa thu (<?= $od['payment_method'] === 'bank' ? 'CK' : 'Tiền mặt' ?>)
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                        <a href="index.php?act=order-detail&id=<?= $od['id'] ?>" class="btn btn-sm btn-outline-primary" title="Xem chi tiết đơn">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </a>

                                        <?php if ($od['status'] === 'pending'): ?>
                                            <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=preparing" class="btn btn-sm btn-success" title="Duyệt đơn chuyển bếp">
                                                <i class="fas fa-check"></i> Duyệt
                                            </a>
                                        <?php elseif ($od['status'] === 'preparing'): ?>
                                            <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=served" class="btn btn-sm btn-info text-dark" title="Báo đã phục vụ">
                                                <i class="fas fa-bell"></i> Phục vụ
                                            </a>
                                        <?php elseif ($od['status'] === 'served' && $currentRole !== 'kitchen'): ?>
                                            <a href="index.php?act=order-status-update&id=<?= $od['id'] ?>&status=completed" class="btn btn-sm btn-primary" title="Hoàn tất đơn & trả bàn trống">
                                                <i class="fas fa-check-double"></i> Hoàn tất
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($currentRole === 'admin'): ?>
                                            <a href="index.php?act=order-delete&id=<?= $od['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đơn #<?= htmlspecialchars($od['order_code']) ?>? Thao tác này sẽ xóa toàn bộ chi tiết món của đơn!');" title="Xóa đơn hàng">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-0 border-0">
                                <div class="table-empty-state">
                                    <i class="fas fa-clipboard-list text-secondary"></i>
                                    <div class="empty-title">Không tìm thấy đơn hàng nào</div>
                                    <div class="empty-desc">Hiện chưa có đơn hàng nào trong trạng thái hoặc tiêu chí lọc này.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let timeLeft = 5;
    let isPaused = false;
    let isFetching = false;

    const countdownEl = document.getElementById('refreshCountdown');
    const spinnerEl = document.getElementById('refreshSpinner');
    const toggleBtn = document.getElementById('btnToggleAutoRefresh');
    const pauseIcon = document.getElementById('pauseIcon');
    const pauseText = document.getElementById('pauseText');
    const manualRefreshBtn = document.getElementById('btnManualRefresh');
    const orderStatusTabs = document.getElementById('orderStatusTabs');
    const orderTableContainer = document.getElementById('orderTableContainer');

    const storageKey = 'chingu_known_order_ids';

    // Phat am thanh chuong nhe nhang khi co don moi
    function playChime() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            const audioCtx = new AudioContext();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
            osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.15); // A5
            gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.5);
        } catch (e) {}
    }

    // Danh dau don hang moi so voi bo nho tam
    function markNewOrders(container) {
        const rows = container.querySelectorAll('.order-row');
        const currentIds = Array.from(rows).map(r => r.getAttribute('data-order-id'));
        const knownIdsRaw = sessionStorage.getItem(storageKey);
        let hasBrandNew = false;

        if (knownIdsRaw) {
            try {
                const knownIds = JSON.parse(knownIdsRaw);
                rows.forEach(r => {
                    const id = r.getAttribute('data-order-id');
                    if (!knownIds.includes(id)) {
                        r.classList.add('table-row-new-order');
                        hasBrandNew = true;
                        const codeCol = r.querySelector('td:first-child .d-flex');
                        if (codeCol && !codeCol.querySelector('.badge-new-pulse')) {
                            const newBadge = document.createElement('span');
                            newBadge.className = 'badge bg-danger badge-new-pulse';
                            newBadge.innerHTML = '<i class="fas fa-bell me-1"></i> MỚI';
                            codeCol.appendChild(newBadge);
                        }
                    }
                });
            } catch (e) {}
        }

        sessionStorage.setItem(storageKey, JSON.stringify(currentIds));
        if (hasBrandNew) {
            playChime();
        }
    }

    // Kiem tra ngay khi vua load trang
    if (orderTableContainer) {
        markNewOrders(orderTableContainer);
    }

    // Cap nhat du lieu ngam qua Fetch khong gay load lai trang, giu nguyen vi tri cuon
    async function fetchUpdateOrders() {
        if (isFetching) return;
        isFetching = true;

        if (spinnerEl) spinnerEl.classList.add('fa-spin');

        // Luu lai vi tri cuon hien tai cua trang
        const scrollX = window.scrollX || window.pageXOffset || 0;
        const scrollY = window.scrollY || window.pageYOffset || 0;

        try {
            const response = await fetch(window.location.href, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                cache: 'no-store'
            });

            if (!response.ok) throw new Error('Network error');

            const htmlText = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(htmlText, 'text/html');

            // 1. Cap nhat tab so luong don hang
            const newTabs = doc.getElementById('orderStatusTabs');
            if (newTabs && orderStatusTabs) {
                orderStatusTabs.innerHTML = newTabs.innerHTML;
            }

            // 2. Cap nhat bang don hang
            const newContainer = doc.getElementById('orderTableContainer');
            if (newContainer && orderTableContainer) {
                markNewOrders(newContainer);

                // Huy datatable cu neu co
                if (window.adminDataTable && typeof window.adminDataTable.destroy === 'function') {
                    try {
                        window.adminDataTable.destroy();
                    } catch (e) {}
                }

                orderTableContainer.innerHTML = newContainer.innerHTML;

                // Khoi tao lai DataTable
                const newTableEl = orderTableContainer.querySelector('#datatablesSimple');
                if (newTableEl && typeof simpleDatatables !== 'undefined') {
                    window.adminDataTable = new simpleDatatables.DataTable(newTableEl, {
                        labels: {
                            placeholder: "Tìm kiếm nhanh...",
                            perPage: "bản ghi / trang",
                            noRows: "Không có dữ liệu trong bảng",
                            info: "Hiển thị từ {start} đến {end} trên tổng số {rows} bản ghi",
                        }
                    });
                }
            }

            // 3. Giu nguyen vi tri cuon
            window.scrollTo({
                top: scrollY,
                left: scrollX,
                behavior: 'instant'
            });

        } catch (err) {
            console.error('Lỗi tự động cập nhật:', err);
        } finally {
            isFetching = false;
            timeLeft = 5;
            if (countdownEl) countdownEl.textContent = timeLeft;
            if (!isPaused && spinnerEl) {
                spinnerEl.classList.add('fa-spin');
            } else if (spinnerEl) {
                spinnerEl.classList.remove('fa-spin');
            }
        }
    }

    // Bo dem gio 5s lap vo han khong bao gio bi dung
    setInterval(function () {
        if (isPaused || isFetching) return;

        timeLeft--;
        if (countdownEl) {
            countdownEl.textContent = timeLeft;
        }

        if (timeLeft <= 0) {
            fetchUpdateOrders();
        }
    }, 1000);

    // Nut Tam dung / Tiep tuc
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            if (isPaused) {
                isPaused = false;
                toggleBtn.classList.remove('active-paused', 'btn-warning');
                toggleBtn.classList.add('btn-outline-secondary');
                if (pauseIcon) pauseIcon.className = 'fas fa-pause me-1';
                if (pauseText) pauseText.textContent = 'Tạm dừng';
                if (spinnerEl) spinnerEl.classList.add('fa-spin');
            } else {
                isPaused = true;
                toggleBtn.classList.add('active-paused', 'btn-warning');
                toggleBtn.classList.remove('btn-outline-secondary');
                if (pauseIcon) pauseIcon.className = 'fas fa-play me-1';
                if (pauseText) pauseText.textContent = 'Tiếp tục';
                if (spinnerEl) spinnerEl.classList.remove('fa-spin');
            }
        });
    }

    // Nut Lam moi ngay
    if (manualRefreshBtn) {
        manualRefreshBtn.addEventListener('click', function () {
            timeLeft = 5;
            if (countdownEl) countdownEl.textContent = timeLeft;
            fetchUpdateOrders();
        });
    }
});
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
