<?php
$pageTitle = "Mã QR Đặt Món - " . htmlspecialchars($table['table_number']) . " • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';

// Tạo URL mã QR động
$qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($orderUrl);
?>

<div class="mt-4 mb-2 d-print-none">
    <h1 class="h3 mb-0">Mã QR Đặt Món: <?= htmlspecialchars($table['table_number']) ?></h1>
    <small class="text-muted">Khách quét mã này trên bàn để truy cập trực tiếp thực đơn và gửi đơn về bếp</small>
</div>

<ol class="breadcrumb mb-4 d-print-none">
    <li class="breadcrumb-item"><a href="index.php?act=dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="index.php?act=tables">Bàn Ăn</a></li>
    <li class="breadcrumb-item active"><?= htmlspecialchars($table['table_number']) ?></li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <!-- THẺ QR ĐẶT BÀN CÓ THỂ IN ẤN -->
        <div class="card text-center p-4 shadow-sm" id="printableCard" style="border-radius: 20px;">
            <div class="mb-2">
                <h4 class="fw-bold mb-0 text-danger" style="letter-spacing: 1px;">CHINGU RESTAURANT</h4>
                <p class="text-muted small fw-semibold">Korean BBQ & Hotpot Dining</p>
            </div>

            <div class="my-2 py-1 bg-light rounded-pill d-inline-block px-4 border mx-auto">
                <h5 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($table['table_number']) ?></h5>
            </div>

            <div class="my-3">
                <img
                    src="<?= $qrApiUrl ?>"
                    alt="Mã QR Đặt Món <?= htmlspecialchars($table['table_number']) ?>"
                    class="img-fluid border p-2 rounded shadow-sm"
                    style="width: 220px; height: 220px;"
                />
            </div>

            <div class="mt-2">
                <h6 class="fw-bold text-dark mb-1">QUÉT MÃ ĐỂ ĐẶT MÓN</h6>
                <p class="text-muted small mb-0">Mở Camera điện thoại hoặc Zalo để gọi món trực tiếp</p>
            </div>

            <div class="mt-3 pt-3 border-top text-muted small" style="font-size: 0.75rem;">
                URL: <code class="text-dark"><?= htmlspecialchars($orderUrl) ?></code>
            </div>
        </div>

        <!-- NÚT IN MÃ QR -->
        <div class="d-flex gap-2 mt-4 d-print-none justify-content-center">
            <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="window.print();">
                <i class="fas fa-print me-1"></i> In Thẻ Đặt Bàn
            </button>
            <a href="index.php?act=tables" class="btn btn-outline-secondary px-4">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printableCard, #printableCard * {
        visibility: visible;
    }
    #printableCard {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        box-shadow: none !important;
        border: 2px solid #333 !important;
    }
}
</style>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
