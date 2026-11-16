<?php
$pageTitle = "Quản Lý Món Ăn • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <h1 class="h3 mb-0">Quản Lý Món Ăn Thực Đơn</h1>
    <a href="index.php?act=product-create" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Thêm Món Ăn Mới
    </a>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Danh Sách Món Ăn</li>
</ol>

<!-- BỘ LỌC TÌM KIẾM THEO TÊN & DANH MỤC (TÌM KIẾM TRỰC TIẾP TỨC THÌ) -->
<div class="card mb-4 shadow-sm">
    <div class="card-body py-3">
        <form id="filterProductForm" action="index.php" method="GET" class="row g-2 align-items-center" onsubmit="return false;">
            <input type="hidden" name="act" value="products" />
            
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        id="productSearchInput"
                        name="keyword"
                        class="form-control"
                        placeholder="Tìm món theo tên hoặc tiếng Hàn..."
                        value="<?= htmlspecialchars($keyword ?? '') ?>"
                        autocomplete="off"
                    />
                    <button type="button" class="btn btn-outline-secondary" id="btnClearSearch" title="Xóa tìm kiếm" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-4">
                <select name="cat" id="productCatSelect" class="form-select">
                    <option value="">-- Tất cả danh mục món --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= htmlspecialchars($c['name']) ?>" <?= (isset($categoryId) && $categoryId == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-1">
                <a href="index.php?act=products" id="btnResetProductFilter" class="btn btn-outline-secondary w-100 text-nowrap">
                    Đặt Lại
                </a>
            </div>
        </form>
    </div>
</div>

<!-- BẢNG DANH SÁCH MÓN ĂN CHUẨN SB ADMIN CARD -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white">
        <i class="fas fa-utensils text-primary me-1"></i>
        <strong>Danh Sách Toàn Bộ Món Ăn (<?= count($products ?? []) ?> món)</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle mb-0" id="datatablesSimple">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">Hình Ảnh</th>
                        <th>Tên Món Ăn</th>
                        <th>Danh Mục</th>
                        <th>Đơn Giá</th>
                        <th>Huy Hiệu (Badge)</th>
                        <th>Trạng Thái</th>
                        <th class="text-end" style="width: 140px; min-width: 140px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $prod): ?>
                            <tr>
                                <td class="text-center">
                                    <img
                                        src="<?= htmlspecialchars($prod['image'] ?: '../public/assets/images/logo.png') ?>"
                                        alt="<?= htmlspecialchars($prod['name']) ?>"
                                        class="admin-prod-thumb"
                                    />
                                </td>
                                <td>
                                    <div class="fw-bold fs-6"><?= htmlspecialchars($prod['name']) ?></div>
                                    <?php if (!empty($prod['korean_name'])): ?>
                                        <small class="text-danger fw-semibold font-monospace"><?= htmlspecialchars($prod['korean_name']) ?></small>
                                    <?php endif; ?>
                                    <div class="text-muted small text-truncate mt-1" style="max-width: 280px;">
                                        <?= htmlspecialchars($prod['description'] ?? '') ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($prod['category_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-danger fs-6"><?= number_format($prod['price'], 0, ',', '.') ?> đ</strong>
                                </td>
                                <td>
                                    <?php if (!empty($prod['badge'])): ?>
                                        <span class="badge bg-danger rounded-pill"><?= htmlspecialchars($prod['badge']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small">--</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($prod['status'] === 'active'): ?>
                                        <span class="badge bg-success rounded-pill">Đang bán</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary rounded-pill">Hết hàng / Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center justify-content-end gap-2">
                                        <a href="index.php?act=product-edit&id=<?= $prod['id'] ?>" class="btn btn-sm btn-outline-primary" title="Sửa món">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </a>
                                        <a href="index.php?act=product-delete&id=<?= $prod['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa món ăn này khỏi thực đơn?');" title="Xóa món">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-0 border-0">
                                <div class="table-empty-state">
                                    <i class="fas fa-utensils text-secondary"></i>
                                    <div class="empty-title">Không tìm thấy món ăn nào</div>
                                    <div class="empty-desc">Chưa có món ăn nào trong danh mục hoặc không khớp với từ khóa tìm kiếm.</div>
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
    const searchInput = document.getElementById('productSearchInput');
    const catSelect = document.getElementById('productCatSelect');
    const clearBtn = document.getElementById('btnClearSearch');
    const resetBtn = document.getElementById('btnResetProductFilter');

    function applyLiveFilter() {
        const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
        const selectedCat = catSelect ? catSelect.value.trim().toLowerCase() : '';

        if (clearBtn) {
            clearBtn.style.display = keyword ? 'inline-block' : 'none';
        }

        // Tích hợp tìm kiếm trực tiếp với Simple-DataTables
        const datatableInput = document.querySelector('.datatable-input');
        if (datatableInput) {
            let term = keyword;
            if (selectedCat) {
                term = term ? (term + ' ' + selectedCat) : selectedCat;
            }
            datatableInput.value = term;
            datatableInput.dispatchEvent(new Event('input', { bubbles: true }));
        } else if (window.adminDataTable && typeof window.adminDataTable.search === 'function') {
            let term = keyword;
            if (selectedCat) {
                term = term ? (term + ' ' + selectedCat) : selectedCat;
            }
            window.adminDataTable.search(term);
        }

        // Lọc trực tiếp các hàng bảng trong DOM để đảm bảo phản hồi tức thì
        const rows = document.querySelectorAll('#datatablesSimple tbody tr');
        rows.forEach(row => {
            if (row.cells.length <= 1) return;
            const text = row.innerText.toLowerCase();
            const catCell = row.querySelector('td:nth-child(3)');
            const catText = catCell ? catCell.innerText.toLowerCase() : '';

            const matchKeyword = !keyword || text.includes(keyword);
            const matchCat = !selectedCat || catText.includes(selectedCat);

            if (matchKeyword && matchCat) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyLiveFilter);
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') e.preventDefault();
        });
    }

    if (catSelect) {
        catSelect.addEventListener('change', applyLiveFilter);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                applyLiveFilter();
            }
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (searchInput) searchInput.value = '';
            if (catSelect) catSelect.value = '';
            if (clearBtn) clearBtn.style.display = 'none';
            applyLiveFilter();
        });
    }

    if (searchInput && searchInput.value) {
        applyLiveFilter();
    }
});
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
