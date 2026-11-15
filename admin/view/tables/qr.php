<?php
$pageTitle = "Mã QR Đặt Món - " . htmlspecialchars($table['table_number']) . " • Chingu Admin";
include_once __DIR__ . '/../layouts/header.php';

// Tạo URL mã QR động
$qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($orderUrl);
?>

<div class="mb-4 d-print-none">
  <a href="index.php?act=tables" class="text-white-50 text-decoration-none small">
    <i class="bi bi-arrow-left"></i> Quay lại danh sách bàn
  </a>
  <h3 class="fw-bold text-white mt-2 mb-1">Mã QR Đặt Món: <?= htmlspecialchars($table['table_number']) ?></h3>
  <p class="text-white-50 small mb-0">Khách quét mã này trên bàn để truy cập trực tiếp thực đơn và gửi đơn về bếp</p>
</div>

<div class="row g-4 justify-content-center">
  <div class="col-12 col-md-6 col-lg-5">
    
    <!-- THẺ QR ĐẶT BÀN CÓ THỂ IN ẤN -->
    <div class="admin-card text-center p-4 p-lg-5 printable-qr-card" id="printableCard" style="background: #ffffff; color: #121011; border-radius: 20px;">
      <div class="mb-2">
        <h3 class="fw-bold mb-0 text-danger" style="letter-spacing: 1px;">CHINGU RESTAURANT</h3>
        <p class="text-muted small fw-semibold">Korean BBQ & Hotpot Dining</p>
      </div>

      <div class="my-3 py-2 bg-light rounded-pill d-inline-block px-4 border border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($table['table_number']) ?></h4>
      </div>

      <div class="my-3">
        <img
          src="<?= $qrApiUrl ?>"
          alt="Mã QR Đặt Món <?= htmlspecialchars($table['table_number']) ?>"
          class="img-fluid border p-2 rounded-3 shadow-sm"
          style="width: 240px; height: 240px;"
        />
      </div>

      <div class="mt-3">
        <h5 class="fw-bold text-dark mb-1">QUÉT MÃ ĐỂ ĐẶT MÓN</h5>
        <p class="text-muted small mb-0">Mở Camera điện thoại hoặc Zalo để gọi món trực tiếp</p>
      </div>

      <div class="mt-3 pt-3 border-top text-muted small" style="font-size: 0.75rem;">
        URL: <code class="text-dark"><?= htmlspecialchars($orderUrl) ?></code>
      </div>
    </div>

    <!-- NÚT IN MÃ QR -->
    <div class="d-flex gap-2 mt-4 d-print-none justify-content-center">
      <button type="button" class="btn btn-warning px-4 rounded-pill fw-bold text-dark" onclick="window.print();">
        <i class="bi bi-printer-fill me-1"></i> In Thẻ Đặt Bàn Này
      </button>
      <a href="index.php?act=tables" class="btn btn-outline-light px-4 rounded-pill">
        Đóng
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
