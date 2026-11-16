<?php
$pageTitle = "Chỉnh Sửa Cấu Hình VietQR • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';

$previewAmount = 289000;
$previewAddInfo = ($config['prefix'] ?? 'CG') . ' DEMO123';
$previewUrl = "https://img.vietqr.io/image/{$config['bank_id']}-{$config['account_no']}-{$config['template']}.png?amount={$previewAmount}&addInfo=" . urlencode($previewAddInfo) . "&accountName=" . urlencode($config['account_name']);
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0">Cấu Hình Tài Khoản Thanh Toán VietQR</h1>
        <small class="text-muted">Tùy chỉnh thông tin tài khoản ngân hàng thụ hưởng và tạo mã QR tự động cho khách hàng</small>
    </div>
</div>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Chỉnh Sửa VietQR</li>
</ol>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- CỘT TRÁI: FORM CẤU HÌNH THÔNG TIN VIETQR -->
    <div class="col-lg-7">
        <div class="card mb-4 shadow-sm border-start border-primary border-4">
            <div class="card-header bg-white py-3">
                <i class="fas fa-university text-primary me-1"></i>
                <strong>Thông Tin Tài Khoản Ngân Hàng Thụ Hưởng</strong>
            </div>
            <div class="card-body p-4">
                <form action="index.php?act=vietqr-update" method="POST" id="vietqrForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Ngân Hàng Thụ Hưởng <span class="text-danger">*</span></label>
                        <select name="bank_id" id="bankSelect" class="form-select" required>
                            <?php foreach ($banks as $b): ?>
                                <option value="<?= $b['id'] ?>" data-name="<?= htmlspecialchars($b['name']) ?>" <?= ($config['bank_id'] === $b['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b['name']) ?> (<?= $b['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Chọn ngân hàng bạn đang dùng để nhận tiền chuyển khoản của khách hàng.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Số Tài Khoản Ngân Hàng <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="account_no"
                            id="accountNoInput"
                            class="form-control font-monospace fw-bold fs-6"
                            placeholder="Ví dụ: 0987654321, 1012345678"
                            value="<?= htmlspecialchars($config['account_no']) ?>"
                            required
                        />
                        <small class="text-muted">Số tài khoản chính xác để tạo mã QR thanh toán nhanh 24/7.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tên Chủ Tài Khoản (In hoa không dấu) <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="account_name"
                            id="accountNameInput"
                            class="form-control text-uppercase fw-bold"
                            placeholder="Ví dụ: CHINGU RESTAURANT, NGUYEN VAN A"
                            value="<?= htmlspecialchars($config['account_name']) ?>"
                            required
                        />
                        <small class="text-muted">Tên hiển thị trên mã QR và ứng dụng chuyển khoản của khách hàng.</small>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Mẫu Giao Diện VietQR</label>
                            <select name="template" id="templateSelect" class="form-select">
                                <option value="compact2" <?= ($config['template'] === 'compact2') ? 'selected' : '' ?>>Mẫu Compact 2 (Kèm khung logo và thông tin chi tiết)</option>
                                <option value="compact" <?= ($config['template'] === 'compact') ? 'selected' : '' ?>>Mẫu Compact (Gọn nhẹ tiêu chuẩn)</option>
                                <option value="qr_only" <?= ($config['template'] === 'qr_only') ? 'selected' : '' ?>>Chỉ Mã QR (Không kèm khung)</option>
                                <option value="print" <?= ($config['template'] === 'print') ? 'selected' : '' ?>>Mẫu In Ấn (Độ nét cao để in tại bàn)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Tiền Tố Nội Dung Chuyển Khoản</label>
                            <input
                                type="text"
                                name="prefix"
                                id="prefixInput"
                                class="form-control text-uppercase font-monospace"
                                placeholder="Ví dụ: CG"
                                value="<?= htmlspecialchars($config['prefix'] ?? 'CG') ?>"
                                maxlength="10"
                            />
                            <small class="text-muted">Hệ thống sẽ tự ghép thành: <strong><?= htmlspecialchars($config['prefix'] ?? 'CG') ?> [Mã_Đơn]</strong>.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <a href="index.php?act=dashboard" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay Lại
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                            <i class="fas fa-save me-1"></i> Lưu Cấu Hình VietQR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CỘT PHẢI: XEM TRƯỚC TRỰC TIẾP -->
    <div class="col-lg-5">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white py-3">
                <i class="fas fa-qrcode text-primary me-1"></i>
                <strong>Xem Trước Trực Tiếp</strong>
            </div>
            <div class="card-body text-center p-4">
                <div class="bg-white p-3 rounded-4 shadow-sm border d-inline-block mx-auto mb-3" style="max-width: 270px;">
                    <img
                        id="vietqrPreviewImg"
                        src="<?= htmlspecialchars($previewUrl) ?>"
                        alt="Xem trước mã VietQR"
                        class="img-fluid rounded-2"
                        style="display: block; width: 100%; height: auto; min-height: 250px; background-color: #f8f9fa;"
                    />
                </div>

                <div class="bg-light p-3 rounded-3 text-start small border">
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted">Ngân hàng:</span>
                        <strong class="text-dark" id="previewBankText"><?= htmlspecialchars($config['bank_name']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted">Số tài khoản:</span>
                        <strong class="text-primary font-monospace fs-6" id="previewAccountNo"><?= htmlspecialchars($config['account_no']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted">Chủ tài khoản:</span>
                        <strong class="text-dark text-uppercase" id="previewAccountName"><?= htmlspecialchars($config['account_name']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span class="text-muted">Nội dung mẫu:</span>
                        <strong class="text-danger font-monospace" id="previewContent"><?= htmlspecialchars($previewAddInfo) ?></strong>
                    </div>
                </div>

                <div class="text-muted small mt-3">
                    <i class="fas fa-info-circle me-1 text-primary"></i> Khách hàng khi chọn hình thức thanh toán Chuyển khoản sẽ nhìn thấy mã QR này với số tiền chính xác theo từng đơn hàng.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bankSelect = document.getElementById('bankSelect');
    const accountNoInput = document.getElementById('accountNoInput');
    const accountNameInput = document.getElementById('accountNameInput');
    const templateSelect = document.getElementById('templateSelect');
    const prefixInput = document.getElementById('prefixInput');

    const previewImg = document.getElementById('vietqrPreviewImg');
    const previewBankText = document.getElementById('previewBankText');
    const previewAccountNo = document.getElementById('previewAccountNo');
    const previewAccountName = document.getElementById('previewAccountName');
    const previewContent = document.getElementById('previewContent');

    let updateTimer = null;

    function updateLivePreview() {
        const bankId = bankSelect ? bankSelect.value : 'MB';
        const selectedOption = bankSelect ? bankSelect.options[bankSelect.selectedIndex] : null;
        const bankName = selectedOption ? (selectedOption.getAttribute('data-name') || selectedOption.text) : bankId;
        const accountNo = accountNoInput ? accountNoInput.value.trim() : '0987654321';
        const accountName = accountNameInput ? accountNameInput.value.trim().toUpperCase() : 'CHINGU RESTAURANT';
        const template = templateSelect ? templateSelect.value : 'compact2';
        const prefix = prefixInput ? prefixInput.value.trim().toUpperCase() : 'CG';
        const demoContent = (prefix ? prefix + ' ' : '') + 'DEMO123';

        // Cập nhật text tóm tắt
        if (previewBankText) previewBankText.textContent = bankName;
        if (previewAccountNo) previewAccountNo.textContent = accountNo || '(Chưa nhập)';
        if (previewAccountName) previewAccountName.textContent = accountName || '(Chưa nhập)';
        if (previewContent) previewContent.textContent = demoContent;

        // Cập nhật ảnh QR thời gian thực (sau 300ms debounce khi người dùng gõ phím)
        clearTimeout(updateTimer);
        updateTimer = setTimeout(function () {
            if (previewImg && accountNo) {
                const url = `https://img.vietqr.io/image/${bankId}-${encodeURIComponent(accountNo)}-${template}.png?amount=289000&addInfo=${encodeURIComponent(demoContent)}&accountName=${encodeURIComponent(accountName)}`;
                previewImg.src = url;
            }
        }, 300);
    }

    if (bankSelect) bankSelect.addEventListener('change', updateLivePreview);
    if (templateSelect) templateSelect.addEventListener('change', updateLivePreview);
    if (accountNoInput) accountNoInput.addEventListener('input', updateLivePreview);
    if (accountNameInput) accountNameInput.addEventListener('input', updateLivePreview);
    if (prefixInput) prefixInput.addEventListener('input', updateLivePreview);
});
</script>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
