<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Theo Dõi Đơn Món • Chingu Korean Restaurant</title>

    <!-- Google Fonts: Be Vietnam Pro, Dancing Script, Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Dancing+Script:wght@600;700&family=Playfair+Display:wght@600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap 5 CSS CDN -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap Icons CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>

    <!-- Header / Navbar -->
    <nav class="navbar custom-navbar order-navbar">
      <div class="container">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center gap-2" href="index.php">
          <span>CHINGU <small class="fw-normal text-warning">RESTAURANT</small></span>
        </a>
      </div>
    </nav>

    <!-- Hero Banner -->
    <header class="menu-hero-header order-hero-banner">
      <div class="container text-center">
        <h1 class="menu-hero-title mb-0">Trạng Thái Đơn Hàng</h1>
      </div>
    </header>

    <main class="order-page-wrapper py-4 py-lg-5">
      <div class="container" style="max-width: 680px;">

        <?php if (!empty($order)): ?>
          <?php
            // Định dạng trạng thái đơn
            $statusMap = [
              'pending' => ['label' => 'Chờ Tiếp Nhận', 'class' => 'bg-secondary text-white', 'icon' => 'bi-hourglass-split', 'step' => 1],
              'preparing' => ['label' => 'Bếp Đang Chuẩn Bị', 'class' => 'bg-warning text-dark', 'icon' => 'bi-fire', 'step' => 2],
              'served' => ['label' => 'Đã Phục Vụ Tại Bàn', 'class' => 'bg-info text-dark', 'icon' => 'bi-cup-hot', 'step' => 3],
              'completed' => ['label' => 'Đã Hoàn Thành', 'class' => 'bg-success text-white', 'icon' => 'bi-check-all', 'step' => 4],
              'cancelled' => ['label' => 'Đã Hủy Đơn', 'class' => 'bg-danger text-white', 'icon' => 'bi-x-circle', 'step' => 0]
            ];
            $currentStatus = $statusMap[$order['status']] ?? ['label' => $order['status'], 'class' => 'bg-secondary', 'icon' => 'bi-info-circle', 'step' => 1];
            
            $step = $currentStatus['step'];
            $fillWidth = '0%';
            if ($step === 2) $fillWidth = '33%';
            elseif ($step === 3) $fillWidth = '66%';
            elseif ($step === 4) $fillWidth = '100%';
          ?>

          <!-- Khối tiến độ trạng thái (Stepper Đồng Bộ) -->
          <div class="order-box-card mb-4 text-center">
            <div class="text-start mb-2">
              <span class="text-white-50 small">Mã đơn đặt món:</span>
              <h4 class="text-warning fw-bold mb-0">#<?= htmlspecialchars($order['order_code']) ?></h4>
            </div>

            <?php if ($order['status'] !== 'cancelled'): ?>
              <!-- Thanh tiến trình đơn hàng -->
              <div class="order-progress-track d-flex justify-content-between position-relative my-4">
                <div class="track-step <?= $step > 1 ? 'completed' : ($step === 1 ? 'active' : '') ?>">
                  <div class="step-dot">
                    <i class="bi <?= $step > 1 ? 'bi-check-lg' : 'bi-receipt' ?>"></i>
                  </div>
                  <div class="step-label">Tiếp nhận</div>
                </div>

                <div class="track-step <?= $step > 2 ? 'completed' : ($step === 2 ? 'active' : '') ?>">
                  <div class="step-dot">
                    <i class="bi <?= $step > 2 ? 'bi-check-lg' : 'bi-fire' ?>"></i>
                  </div>
                  <div class="step-label">Vào bếp</div>
                </div>

                <div class="track-step <?= $step > 3 ? 'completed' : ($step === 3 ? 'active' : '') ?>">
                  <div class="step-dot">
                    <i class="bi <?= $step > 3 ? 'bi-check-lg' : 'bi-cup-hot' ?>"></i>
                  </div>
                  <div class="step-label">Phục vụ</div>
                </div>

                <div class="track-step <?= $step === 4 ? 'completed active' : '' ?>">
                  <div class="step-dot">
                    <i class="bi bi-check-all"></i>
                  </div>
                  <div class="step-label">Hoàn tất</div>
                </div>
              </div>
            <?php else: ?>
              <div class="alert alert-danger py-2 rounded-pill my-3">
                <i class="bi bi-x-circle-fill me-1"></i> Đơn hàng này đã bị hủy bỏ bởi quản lý.
              </div>
            <?php endif; ?>

            <div class="text-white-50 small mt-2">
              <div class="mb-1">
                <i class="bi bi-clock-history me-1"></i>
                Thời gian đặt: <?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?>
              </div>
              <div>
                <i class="bi bi-shop me-1 text-warning"></i>
                Vị trí: <strong class="text-warning"><?= htmlspecialchars($order['table_number'] ?? 'Chưa chỉ định bàn') ?></strong>
              </div>
            </div>

            <?php if ($order['status'] !== 'completed' && $order['status'] !== 'cancelled'): ?>
              <!-- Tự động làm mới trạng thái -->
              <div class="d-flex align-items-center justify-content-center gap-2 mt-3 pt-3 border-top border-secondary border-opacity-25 text-white-50 small">
                <span class="spinner-grow spinner-grow-sm text-warning" role="status"></span>
                <span id="refreshTimerContainer">
                  <span id="refreshTimerNormal">Tự động cập nhật sau <strong id="refreshCountdown" class="text-warning">15</strong>s</span>
                  <span id="refreshTimerPaused" class="text-warning fw-semibold" style="display: none;">
                    <i class="bi bi-pause-circle-fill me-1"></i>Đang mở thanh toán (Tạm dừng làm mới)
                  </span>
                </span>
                <button type="button" class="btn btn-link btn-sm text-decoration-none text-white-50 p-0 ms-2" onclick="window.location.reload();" title="Làm mới ngay">
                  <i class="bi bi-arrow-clockwise"></i> Làm mới
                </button>
              </div>
            <?php endif; ?>
          </div>

          <!-- Thông tin bàn & khách hàng -->
          <div class="order-box-card mb-4">
            <div class="order-box-header">
              <h4 class="order-box-title">
                <i class="bi bi-person-badge text-warning"></i> Thông Tin Khách Hàng
              </h4>
            </div>
            <div class="row g-2 text-white-50 small">
              <div class="col-12">Khách hàng: <strong class="text-white"><?= htmlspecialchars($order['customer_name']) ?></strong></div>
              <div class="col-12">Vị trí: <strong class="text-warning"><?= htmlspecialchars($order['table_number'] ?? 'Chưa chọn bàn') ?></strong></div>
              <?php if (!empty($order['note'])): ?>
                <div class="col-12 mt-2 pt-2 border-top border-secondary border-opacity-25">
                  Ghi chú: <em class="text-white"><?= htmlspecialchars($order['note']) ?></em>
                </div>
              <?php endif; ?>
              <div class="col-12 mt-2 pt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-1">
                <span>Trạng thái thanh toán:</span>
                <span class="badge <?= $order['payment_status'] === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill px-3 py-1">
                  <?= $order['payment_status'] === 'paid' ? 'Đã Thanh Toán' : 'Chưa Thanh Toán' ?>
                  (<?= $order['payment_method'] === 'bank' ? 'Chuyển Khoản' : 'Tiền Mặt' ?>)
                </span>
              </div>
            </div>
          </div>

          <!-- Danh sách các món ăn trong đơn -->
          <div class="order-box-card mb-4">
            <div class="order-box-header">
              <h4 class="order-box-title">
                <i class="bi bi-card-checklist text-warning"></i> Danh Sách Món Đã Đặt
              </h4>
            </div>
            <div class="order-items-list">
              <?php foreach ($orderDetails as $item): ?>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary border-opacity-25 text-white-50 small">
                  <div>
                    <span class="text-white fw-semibold"><?= htmlspecialchars($item['product_name']) ?></span>
                    <span class="text-warning ms-1">x<?= intval($item['quantity']) ?></span>
                    <?php if (!empty($item['note'])): ?>
                      <div class="text-white-50 fst-italic" style="font-size: 0.78rem;">Lưu ý: <?= htmlspecialchars($item['note']) ?></div>
                    <?php endif; ?>
                  </div>
                  <span class="text-white fw-bold"><?= number_format($item['subtotal'], 0, ',', '.') ?> đ</span>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Tổng thanh toán -->
            <div class="d-flex justify-content-between align-items-center pt-3">
              <span class="text-white-50">Tổng thanh toán:</span>
              <span class="text-warning fw-bold fs-5"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</span>
            </div>

            <?php if ($order['payment_status'] !== 'paid' && $order['status'] !== 'cancelled'): ?>
              <!-- Nút thanh toán nổi bật -->
              <div class="mt-3 pt-2">
                <button type="button" class="btn btn-warning w-100 rounded-pill py-2 fw-bold text-dark d-flex align-items-center justify-content-center gap-2 shadow" onclick="openPaymentFlyout()">
                  <i class="bi bi-wallet2 fs-5"></i> Thanh Toán Đơn Hàng
                </button>
              </div>
            <?php endif; ?>
          </div>

        <?php else: ?>
          <!-- Trường hợp chưa tìm thấy đơn hàng -->
          <div class="order-box-card text-center py-5">
            <i class="bi <?= !empty($searchError) ? 'bi-exclamation-circle text-danger' : 'bi-search text-warning' ?>" style="font-size: 3rem;"></i>
            <h4 class="text-white fw-bold mt-3 mb-2"><?= !empty($searchError) ? 'Không Tìm Thấy Đơn Hàng' : 'Tra Cứu Trạng Thái Đơn Món' ?></h4>
            <p class="text-white-50 mb-4"><?= !empty($searchError) ? 'Mã đơn bạn vừa nhập không tồn tại hoặc đã bị xóa khỏi hệ thống.' : 'Vui lòng nhập mã đơn hàng của bạn để kiểm tra tình trạng bếp phục vụ' ?></p>

            <?php if (!empty($searchError)): ?>
              <div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger rounded-4 py-2 px-3 mb-4 mx-auto d-flex align-items-center justify-content-center gap-2" style="max-width: 440px; font-size: 0.9rem;">
                <i class="bi bi-x-circle-fill fs-5 flex-shrink-0"></i>
                <span><?= $searchError ?></span>
              </div>
            <?php endif; ?>

            <form action="index.php" method="GET" class="d-flex gap-2 justify-content-center mx-auto" style="max-width: 440px;">
              <input type="hidden" name="pg" value="order-status" />
              <input 
                type="text" 
                name="code" 
                class="form-control form-control-custom <?= !empty($searchError) ? 'is-invalid' : '' ?>" 
                placeholder="Ví dụ: CG-1001" 
                value="<?= htmlspecialchars($rawCode ?? $orderCode ?? '') ?>" 
                required 
              />
              <button type="submit" class="btn btn-warning px-4 rounded-pill fw-bold text-dark text-nowrap flex-shrink-0">Tra cứu</button>
            </form>
          </div>
        <?php endif; ?>

      </div>
    </main>

    <?php if (!empty($order) && $order['payment_status'] !== 'paid' && $order['status'] !== 'cancelled'): ?>
      <!-- FLYOUT THANH TOÁN (BOTTOM SHEET) -->
      <div class="payment-flyout-backdrop" id="paymentFlyoutBackdrop" onclick="closePaymentFlyout()"></div>
      <div class="payment-flyout-sheet" id="paymentFlyoutSheet">
        <!-- Drag handle -->
        <div class="payment-flyout-drag-handle"></div>

        <!-- Header Flyout -->
        <div class="payment-flyout-header d-flex align-items-center justify-content-between px-4 pt-2 pb-3 border-bottom border-secondary border-opacity-25">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-wallet2 text-warning fs-5"></i>
            <div>
              <h5 class="text-white fw-bold mb-0">Thanh Toán Đơn Hàng</h5>
              <small class="text-white-50">Mã đơn: #<?= htmlspecialchars($order['order_code']) ?></small>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle text-white-50 p-2 lh-1" onclick="closePaymentFlyout()" aria-label="Đóng flyout">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>

        <!-- Nội dung Flyout -->
        <div class="payment-flyout-body px-4 py-3 flex-grow-1" style="overflow-y: auto;">
          <!-- Tóm tắt số tiền -->
          <div class="bg-black bg-opacity-40 p-3 rounded-3 border border-secondary border-opacity-25 mb-3 text-center">
            <div class="text-white-50 small mb-1">Số tiền cần thanh toán</div>
            <div class="text-warning fw-bold fs-3"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</div>
          </div>

          <?php if ($order['payment_method'] === 'bank'): ?>
            <!-- HÌNH THỨC CHUYỂN KHOẢN NGÂN HÀNG (VIETQR) -->
            <div class="payment-bank-section text-center">
              <div class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill mb-2">
                <i class="bi bi-qr-code-scan me-1"></i> Quét mã VietQR để thanh toán
              </div>
              <p class="text-white-50 small mb-3">
                Mở ứng dụng Ngân hàng (MB, VCB, Techcombank...) hoặc Ví điện tử để quét mã thanh toán tự động
              </p>

              <!-- Khung mã QR -->
              <div class="bg-white p-3 rounded-4 d-inline-block shadow-lg mx-auto mb-3" style="max-width: 250px;">
                <img 
                  src="https://img.vietqr.io/image/MB-0987654321-compact2.png?amount=<?= intval($order['total_amount']) ?>&addInfo=<?= urlencode('CG ' . $order['order_code']) ?>&accountName=<?= urlencode('CHINGU RESTAURANT') ?>" 
                  alt="Mã VietQR Thanh Toán Chingu" 
                  class="img-fluid rounded-2"
                  style="display: block; width: 100%; height: auto;"
                />
              </div>

              <!-- Chi tiết thông tin chuyển khoản -->
              <div class="bg-dark bg-opacity-75 p-3 rounded-3 border border-secondary border-opacity-25 text-start small mb-3">
                <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-secondary border-opacity-25">
                  <span class="text-white-50">Ngân hàng:</span>
                  <span class="text-white fw-semibold">MB Bank (Quân Đội)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-secondary border-opacity-25">
                  <span class="text-white-50">Số tài khoản:</span>
                  <span class="text-warning fw-bold d-flex align-items-center gap-1">
                    0987654321
                    <button type="button" class="btn btn-link btn-sm text-warning p-0 ms-1 copy-btn" onclick="copyPaymentText('0987654321', this)" title="Sao chép số tài khoản">
                      <i class="bi bi-clipboard"></i>
                    </button>
                  </span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-secondary border-opacity-25">
                  <span class="text-white-50">Chủ tài khoản:</span>
                  <span class="text-white fw-semibold">CHINGU RESTAURANT</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-secondary border-opacity-25">
                  <span class="text-white-50">Số tiền:</span>
                  <span class="text-warning fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-1">
                  <span class="text-white-50">Nội dung CK:</span>
                  <span class="text-warning fw-bold d-flex align-items-center gap-1">
                    CG <?= htmlspecialchars($order['order_code']) ?>
                    <button type="button" class="btn btn-link btn-sm text-warning p-0 ms-1 copy-btn" onclick="copyPaymentText('CG <?= htmlspecialchars($order['order_code']) ?>', this)" title="Sao chép nội dung">
                      <i class="bi bi-clipboard"></i>
                    </button>
                  </span>
                </div>
              </div>

              <div class="alert alert-secondary py-2 small mb-0 text-white-50 border-0 bg-secondary bg-opacity-10 text-center">
                <i class="bi bi-info-circle me-1 text-warning"></i> Sau khi chuyển khoản thành công, thu ngân sẽ xác nhận và cập nhật đơn sang "Đã Thanh Toán".
              </div>
            </div>

          <?php else: ?>
            <!-- HÌNH THỨC TIỀN MẶT (HƯỚNG DẪN RA QUẦY THU NGÂN) -->
            <div class="payment-cash-section text-center py-2">
              <div class="cash-icon-wrap my-3 mx-auto">
                <i class="bi bi-shop text-warning" style="font-size: 2.8rem;"></i>
              </div>
              <h5 class="text-white fw-bold mb-2">Thanh Toán Bằng Tiền Mặt Tại Quầy</h5>
              <p class="text-white-50 small px-2 mb-4">
                Quý khách vui lòng di chuyển đến <strong class="text-warning">Quầy Thu Ngân</strong> của nhà hàng Chingu để thực hiện thanh toán cho đơn món này.
              </p>

              <div class="bg-dark bg-opacity-75 p-3 rounded-3 border border-secondary border-opacity-25 text-start small mb-4">
                <div class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                  <span class="text-white-50">Vị trí bàn phục vụ:</span>
                  <span class="text-warning fw-bold"><?= htmlspecialchars($order['table_number'] ?? 'Chưa chọn bàn') ?></span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-secondary border-opacity-25">
                  <span class="text-white-50">Mã đơn đặt món:</span>
                  <span class="text-white fw-bold">#<?= htmlspecialchars($order['order_code']) ?></span>
                </div>
                <div class="d-flex justify-content-between py-1">
                  <span class="text-white-50">Số tiền thanh toán:</span>
                  <span class="text-warning fw-bold fs-6"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</span>
                </div>
              </div>

              <div class="p-3 rounded-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 text-warning small text-start mb-3">
                <i class="bi bi-bell-fill me-1"></i>
                <strong>Lưu ý:</strong> Vui lòng đọc <span class="fw-bold">Mã đơn #<?= htmlspecialchars($order['order_code']) ?></span> hoặc số <span class="fw-bold"><?= htmlspecialchars($order['table_number'] ?? 'bàn') ?></span> cho nhân viên thu ngân để in hóa đơn và hoàn tất đơn hàng.
              </div>
            </div>
          <?php endif; ?>

          <div class="mt-4 pt-2">
            <button type="button" class="btn btn-outline-light w-100 rounded-pill py-2 fw-semibold" onclick="closePaymentFlyout()">
              Đóng và Tiếp Tục Theo Dõi
            </button>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <style>
      /* Tiến trình theo dõi đơn hàng */
      .order-progress-track {
        margin: 24px 0 16px 0;
      }
      .order-progress-track::before,
      .order-progress-fill {
        display: none !important;
      }
      .track-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
      }
      .step-dot {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #252021;
        border: 2px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px auto;
        font-size: 1.15rem;
        transition: all 0.3s ease;
      }
      .step-label {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 500;
        transition: all 0.3s ease;
      }
      .track-step.completed .step-dot {
        background: #10b981;
        border-color: #34d399;
        color: #ffffff;
      }
      .track-step.completed .step-label {
        color: #ffffff;
      }
      .track-step.active .step-dot {
        background: linear-gradient(135deg, #e63946, #b81b24);
        border-color: #ff4d5a;
        color: #ffffff;
        box-shadow: 0 0 18px rgba(230, 57, 70, 0.7);
        animation: pulse-step-glow 2s infinite;
      }
      .track-step.active .step-label {
        color: var(--accent-gold);
        font-weight: 700;
      }

      @keyframes pulse-step-glow {
        0% { box-shadow: 0 0 0 0 rgba(230, 57, 70, 0.7); }
        70% { box-shadow: 0 0 0 12px rgba(230, 57, 70, 0); }
        100% { box-shadow: 0 0 0 0 rgba(230, 57, 70, 0); }
      }

      /* Flyout Thanh Toán */
      .payment-flyout-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 1080;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      }
      .payment-flyout-backdrop.show {
        opacity: 1;
        pointer-events: auto;
      }
      .payment-flyout-sheet {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        background: #191516;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-bottom: none;
        border-radius: 20px 20px 0 0;
        z-index: 1090;
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.85);
        height: calc(100vh - var(--current-navbar-height, 56px));
        height: calc(100dvh - var(--current-navbar-height, 56px));
        max-height: calc(100dvh - var(--current-navbar-height, 56px));
      }
      @media (min-width: 576px) {
        .payment-flyout-sheet {
          left: 50%;
          right: auto;
          transform: translate(-50%, 100%);
        }
      }
      .payment-flyout-sheet.open {
        transform: translateY(0);
      }
      @media (min-width: 576px) {
        .payment-flyout-sheet.open {
          transform: translate(-50%, 0);
        }
      }
      .payment-flyout-drag-handle {
        width: 44px;
        height: 4px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 4px;
        margin: 10px auto 4px auto;
      }
      .cash-icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(243, 173, 51, 0.12);
        border: 2px dashed rgba(243, 173, 51, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
      }

      @media (max-width: 575.98px) {
        .step-dot {
          width: 36px;
          height: 36px;
          font-size: 0.95rem;
        }
        .step-label {
          font-size: 0.75rem;
        }
      }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/main.js"></script>

    <script>
      // Trạng thái tự động làm mới & flyout thanh toán
      let timeLeft = 15;
      let isAutoRefreshPaused = false;
      const countdownEl = document.getElementById('refreshCountdown');
      const timerNormal = document.getElementById('refreshTimerNormal');
      const timerPaused = document.getElementById('refreshTimerPaused');

      function updateNavHeight() {
        const navbar = document.querySelector('.custom-navbar');
        if (navbar) {
          const navHeight = navbar.offsetHeight;
          document.documentElement.style.setProperty('--current-navbar-height', navHeight + 'px');
        }
      }

      window.addEventListener('resize', updateNavHeight);
      document.addEventListener('DOMContentLoaded', updateNavHeight);

      function openPaymentFlyout() {
        updateNavHeight();
        const backdrop = document.getElementById('paymentFlyoutBackdrop');
        const sheet = document.getElementById('paymentFlyoutSheet');
        if (backdrop) backdrop.classList.add('show');
        if (sheet) sheet.classList.add('open');
        
        // Tạm dừng tự động làm mới trang
        isAutoRefreshPaused = true;
        if (timerNormal) timerNormal.style.display = 'none';
        if (timerPaused) timerPaused.style.display = 'inline';
      }

      function closePaymentFlyout() {
        const backdrop = document.getElementById('paymentFlyoutBackdrop');
        const sheet = document.getElementById('paymentFlyoutSheet');
        if (backdrop) backdrop.classList.remove('show');
        if (sheet) sheet.classList.remove('open');
        
        // Khôi phục tiếp tục tự động làm mới trang
        isAutoRefreshPaused = false;
        if (timerNormal) timerNormal.style.display = 'inline';
        if (timerPaused) timerPaused.style.display = 'none';
      }

      // Đóng flyout khi nhấn phím Escape
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          closePaymentFlyout();
        }
      });

      // Hàm sao chép thông tin ngân hàng kèm hiệu ứng
      function copyPaymentText(text, btn) {
        if (navigator.clipboard) {
          navigator.clipboard.writeText(text).then(() => {
            const icon = btn.querySelector('i');
            if (icon) {
              const originalClass = icon.className;
              icon.className = 'bi bi-check-lg text-success';
              setTimeout(() => {
                icon.className = originalClass;
              }, 1500);
            }
          });
        }
      }

      <?php if (!empty($order) && $order['status'] !== 'completed' && $order['status'] !== 'cancelled'): ?>
        // Tự động làm mới trạng thái đơn sau mỗi 15 giây (sẽ dừng khi đang mở flyout thanh toán)
        setInterval(() => {
          if (isAutoRefreshPaused) return;
          timeLeft--;
          if (timeLeft <= 0) {
            window.location.reload();
          } else if (countdownEl) {
            countdownEl.textContent = timeLeft;
          }
        }, 1000);
      <?php endif; ?>

      // Xóa viền đỏ cảnh báo khi người dùng nhập lại mã tra cứu
      const searchInput = document.querySelector('input[name="code"]');
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          this.classList.remove('is-invalid');
        });
      }
    </script>
  </body>
</html>