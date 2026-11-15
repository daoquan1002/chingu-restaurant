<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Xác Nhận Đặt Món - Chingu Korean Restaurant</title>

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

    <!-- Custom CSS kế thừa từ landing page & menu -->
    <link rel="stylesheet" href="public/css/style.css" />

    <?php $hasLastOrder = !empty($lastOrder); ?>
    <style>
      body.order-success-mode {
        padding-bottom: 0 !important;
      }
      .order-page-wrapper.order-success-mode {
        min-height: 100vh !important;
        padding-top: 85px !important;
        padding-bottom: 25px !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
      }
      @media (max-width: 575.98px) {
        .order-page-wrapper.order-success-mode {
          min-height: auto !important;
          padding-top: 78px !important;
          padding-bottom: 25px !important;
          display: block;
        }
      }
      #orderSuccessScreen {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        max-width: 440px !important;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
      }
      #orderSuccessScreen .order-summary-box {
        background: #181516;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        max-height: none;
        padding: 0.85rem 1rem !important;
        margin-bottom: 0.85rem !important;
      }
      #orderSuccessScreen .order-success-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background-color: rgba(25, 135, 84, 0.2);
        border: 2px solid #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.65rem auto;
      }
      #orderSuccessScreen .order-success-icon i {
        font-size: 1.7rem !important;
      }
      #orderSuccessScreen h3 {
        font-size: 1.35rem;
        margin-bottom: 0.2rem !important;
      }
      #orderSuccessScreen .order-code-title {
        font-size: 1.05rem !important;
        margin-bottom: 0.85rem !important;
      }
      #orderSuccessScreen .order-summary-box hr {
        margin: 0.45rem 0 !important;
      }
      #orderSuccessScreen .order-summary-box .info-row {
        margin-bottom: 0.35rem !important;
      }
      #orderSuccessScreen .order-desc-note {
        font-size: 0.825rem;
        line-height: 1.4;
        margin-bottom: 0.85rem !important;
      }
      #orderSuccessScreen .btn-view-status {
        padding: 0.5rem 1.5rem !important;
        font-size: 0.95rem;
      }
    </style>
  </head>
  <body class="<?= $hasLastOrder ? 'order-success-mode' : '' ?>">

    <!-- =========================================================================
       1. HEADER / NAVBAR CỐ ĐỊNH (CHỈ GIỮ LOGO NHÀ HÀNG)
       ========================================================================= -->
    <nav class="navbar custom-navbar order-navbar">
      <div class="container">
        <!-- Logo Nhà hàng Chingu -->
        <a
          class="navbar-brand text-white fw-bold d-flex align-items-center gap-2"
          href="index.php"
        >
          <span>CHINGU <small class="fw-normal text-warning">RESTAURANT</small></span>
        </a>
      </div>
    </nav>

    <!-- =========================================================================
       2. HERO BANNER TRANG XÁC NHẬN ĐẶT MÓN
       ========================================================================= -->
    <header class="menu-hero-header order-hero-banner <?= $hasLastOrder ? 'd-none' : '' ?>" id="orderHeroBanner">
      <div class="container text-center">
        <h1 class="menu-hero-title mb-0">Xác Nhận Đặt Món</h1>
      </div>
    </header>

    <!-- =========================================================================
       3. NỘI DUNG CHÍNH: XÁC NHẬN ĐƠN & THANH TOÁN
       ========================================================================= -->
    <main class="order-page-wrapper <?= $hasLastOrder ? 'order-success-mode' : 'py-4 py-lg-5' ?>" id="orderPageWrapper">
      <div class="container">

        <!-- =====================================================================
           MÀN HÌNH HOÀN TẤT ĐẶT MÓN THÀNH CÔNG (HIỂN THỊ THẲNG VÀO NỀN WEB)
           ===================================================================== -->
        <div id="orderSuccessScreen" class="<?= $hasLastOrder ? '' : 'd-none' ?> mx-auto text-center px-3" style="max-width: 440px;">
          <div class="order-success-icon mx-auto mb-2">
            <i class="bi bi-check-lg text-success"></i>
          </div>
          <h3 class="text-white fw-bold mb-1">Tạo Đơn Hàng Thành Công!</h3>
          <p class="text-warning fw-bold order-code-title">Mã đơn: <span id="confirmedOrderCode">#<?= htmlspecialchars($lastOrder['order_code'] ?? 'CG-8821') ?></span></p>
          
          <div class="order-summary-box text-start p-3">
            <div class="d-flex justify-content-between text-white-50 small info-row">
              <span>Khách hàng:</span>
              <strong class="text-white" id="modalCustName"><?= htmlspecialchars($lastOrder['customer_name'] ?? '--') ?></strong>
            </div>
            <div class="d-flex justify-content-between text-white-50 small info-row">
              <span>Bàn phục vụ:</span>
              <strong class="text-warning fw-bold" id="modalTableNumber"><?= htmlspecialchars(!empty($lastOrder['table_number']) ? $lastOrder['table_number'] : (!empty($currentTable) ? $currentTable : 'Chưa chọn bàn')) ?></strong>
            </div>
            <div class="d-flex justify-content-between text-white-50 small info-row">
              <span>Ghi chú:</span>
              <strong class="text-white" id="modalCustNote"><?= htmlspecialchars(!empty($lastOrder['note']) ? $lastOrder['note'] : 'Không có ghi chú') ?></strong>
            </div>
            <div class="d-flex justify-content-between text-white-50 small info-row align-items-center">
              <span>Hình thức thanh toán:</span>
              <span class="badge <?= ($lastOrder['payment_method'] ?? 'cash') === 'cash' ? 'bg-warning text-dark' : 'bg-info text-dark' ?> rounded-pill px-3 py-1" id="modalPaymentMethod">
                <?= ($lastOrder['payment_method'] ?? 'cash') === 'cash' ? 'Tiền Mặt' : 'Chuyển Khoản Ngân Hàng' ?>
              </span>
            </div>
            <hr class="border-secondary border-opacity-25" />
            <div class="text-white-50 small mb-1 fw-semibold">Danh sách món:</div>
            <div id="modalOrderItemsList" class="small">
              <?php if (!empty($lastOrder['items'])): ?>
                <?php foreach ($lastOrder['items'] as $it): ?>
                  <div class="d-flex justify-content-between text-white-50 py-1">
                    <span><?= htmlspecialchars($it['name'] ?? $it['product_name'] ?? '') ?> <strong class="text-white">x<?= intval($it['qty'] ?? $it['quantity'] ?? 1) ?></strong></span>
                    <span class="text-warning"><?= number_format(($it['price'] ?? $it['unit_price'] ?? 0) * ($it['qty'] ?? $it['quantity'] ?? 1), 0, ',', '.') ?> đ</span>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <hr class="border-secondary border-opacity-25" />
            <div class="d-flex justify-content-between align-items-center pt-1">
              <span class="text-white fw-bold">Tổng thanh toán:</span>
              <span class="text-warning fw-bold fs-5" id="modalGrandTotal"><?= number_format($lastOrder['total_amount'] ?? 0, 0, ',', '.') ?> đ</span>
            </div>
          </div>

          <p class="text-white-50 small order-desc-note">
            Bếp Chingu đã tạo đơn thành công, quý khách vui lòng bấm "Xem trạng thái" để tiến hành thanh toán.
          </p>

          <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold w-100 btn-view-status" id="btnViewOrderStatus">
              Xem Trạng Thái
            </button>
          </div>
        </div>

        <!-- GIAO DIỆN KHI GIỎ HÀNG TRỐNG -->
        <div id="orderEmptyState" class="order-box-card text-center py-5 d-none">
          <div class="mb-3">
            <i class="bi bi-bag-x text-white-50" style="font-size: 4rem;"></i>
          </div>
          <h3 class="text-white fw-bold mb-2">Chưa Có Món Nào Được Chọn</h3>
          <p class="text-white-50 mb-4">
            Giỏ hàng của bạn đang trống. Hãy quay lại thực đơn để chọn các món nướng và lẩu hấp dẫn nhé!
          </p>
          <?php
            $emptyMenuUrl = 'index.php?pg=menu';
            if (!empty($currentTable)) {
              $emptyMenuUrl .= '&table=' . urlencode($currentTable);
            }
          ?>
          <a href="<?= htmlspecialchars($emptyMenuUrl) ?>" id="btnEmptyMenu" class="btn btn-order-empty-menu px-4 py-2 rounded-pill fw-semibold shadow-sm">
            <i class="bi bi-grid-fill me-2"></i> Khám Phá Thực Đơn Ngay
          </a>
        </div>

        <!-- GIAO DIỆN KHI ĐÃ CÓ MÓN ĂN -->
        <div id="orderContentWrap" class="row g-4 <?= $hasLastOrder ? 'd-none' : '' ?>">
          
          <!-- CỘT TRÁI: DANH SÁCH MÓN ĐÃ CHỌN & THÔNG TIN KHÁCH HÀNG -->
          <div class="col-lg-7">
            
            <!-- KHỐI 1: DANH SÁCH CÁC MÓN ĐÃ THÊM -->
            <div class="order-box-card">
              <div class="order-box-header d-flex align-items-center justify-content-between">
                <h4 class="order-box-title">
                  <i class="bi bi-bag-check-fill text-warning"></i>
                  Danh Sách Món Đã Chọn
                </h4>
                <span class="badge bg-danger rounded-pill px-3 py-1" id="orderSummaryBadge">
                  0 món
                </span>
              </div>

              <!-- Danh sách từng món được render động -->
              <div class="order-items-container" id="orderItemsContainer"></div>

              <!-- Tổng kết tiền món -->
              <div class="pt-3 mt-3 border-top border-secondary border-opacity-25">
                <div class="d-flex justify-content-between text-white-50 mb-2 small">
                  <span>Tạm tính tiền món:</span>
                  <span class="text-white fw-semibold" id="subtotalAmount">0 đ</span>
                </div>
                <div class="d-flex justify-content-between text-white-50 mb-2 small">
                  <span>Phí dịch vụ & VAT:</span>
                  <span class="text-success fw-semibold">0 đ (Miễn phí)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-25">
                  <span class="text-white-50 small">Tổng cộng thanh toán:</span>
                  <span class="text-warning fw-bold fs-6" id="grandTotalAmount">0 đ</span>
                </div>
              </div>
            </div>

            <!-- KHỐI 2: THÔNG TIN KHÁCH HÀNG (CHỈ GIỮ Ô NHẬP TÊN VÀ GHI CHÚ) -->
            <div class="order-box-card">
              <div class="order-box-header">
                <h4 class="order-box-title">
                  <i class="bi bi-person-lines-fill text-warning"></i>
                  Thông Tin Khách Hàng
                </h4>
              </div>

              <div class="row g-3">
                <!-- 1. Họ và tên khách hàng -->
                <div class="col-12">
                  <label for="custName" class="form-label text-white-50 small mb-1">
                    Họ và tên khách hàng <span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control form-control-custom"
                    id="custName"
                    placeholder="Nhập họ và tên của bạn..."
                    required
                  />
                  <div class="invalid-feedback text-danger small mt-1">
                    Vui lòng nhập họ và tên khách hàng trước khi đặt món.
                  </div>
                </div>

                <!-- 2. Bàn đang đặt món (dạng input không thể chỉnh sửa) -->
                <div class="col-12">
                  <label for="orderTableNumber" class="form-label text-white-50 small mb-1">
                    Bàn đang đặt món
                  </label>
                  <input
                    type="text"
                    class="form-control form-control-custom"
                    id="orderTableNumber"
                    name="table_number"
                    value="<?= htmlspecialchars(!empty($currentTable) ? $currentTable : 'Chưa chọn bàn') ?>"
                    readonly
                    tabindex="-1"
                    style="cursor: not-allowed; background-color: #211c1d; color: #f3ad33; font-weight: 600;"
                  />
                </div>

                <!-- 3. Ghi chú đơn hàng -->
                <div class="col-12">
                  <label for="custOrderNote" class="form-label text-white-50 small mb-1">Ghi chú</label>
                  <textarea
                    class="form-control form-control-custom"
                    id="custOrderNote"
                    rows="3"
                    placeholder="Nhập ghi chú hoặc yêu cầu món ăn..."
                  ></textarea>
                </div>
              </div>
            </div>

          </div>

          <!-- CỘT PHẢI: HÌNH THỨC THANH TOÁN (TIỀN MẶT HOẶC NGÂN HÀNG, ĐÃ XÓA QR & NÚT ĐẶT MÓN) -->
          <div class="col-lg-5">
            <div class="order-box-card">
              
              <!-- TIÊU ĐỀ KHỐI THANH TOÁN -->
              <div class="order-box-header">
                <h4 class="order-box-title">
                  <i class="bi bi-credit-card-2-front-fill text-warning"></i>
                  Hình Thức Thanh Toán
                </h4>
              </div>

              <!-- HAI NÚT HÌNH THỨC THANH TOÁN: TIỀN MẶT HOẶC NGÂN HÀNG -->
              <div class="payment-methods-grid">
                
                <!-- NÚT 1: TIỀN MẶT -->
                <div class="payment-method-btn active" data-method="cash" id="btnPayCash">
                  <i class="bi bi-check-circle-fill method-check-badge"></i>
                  <i class="bi bi-cash-stack method-icon text-warning"></i>
                  <div class="method-name">Tiền Mặt</div>
                  <div class="method-desc">Thanh toán trực tiếp khi nhận món</div>
                </div>

                <!-- NÚT 2: NGÂN HÀNG -->
                <div class="payment-method-btn" data-method="bank" id="btnPayBank">
                  <i class="bi bi-check-circle-fill method-check-badge"></i>
                  <i class="bi bi-bank method-icon text-info"></i>
                  <div class="method-name">Ngân Hàng</div>
                  <div class="method-desc">Chuyển khoản qua tài khoản ngân hàng</div>
                </div>

              </div>

            </div>
          </div>

        </div>

      </div>
    </main>

    <!-- =========================================================================
       THANH CHÂN TRANG ĐẶT MÓN (HAI HÀNG: HÀNG TRÊN TỔNG THANH TOÁN, HÀNG DƯỚI NÚT ĐẶT MÓN NGAY KO KÈM ICON)
       ========================================================================= -->
    <div class="order-bottom-footer-bar <?= $hasLastOrder ? 'd-none' : '' ?>" id="orderBottomFooterBar">
      <div class="order-footer-inner">
        <!-- Hàng trên: chữ bé Tổng thanh toán bên trái, giá tiền bên phải -->
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="order-footer-label text-white-50">Tổng thanh toán</span>
          <span class="order-footer-price text-warning fw-bold" id="footerGrandTotal">0 đ</span>
        </div>
        <!-- Hàng dưới: nút đặt món ngay ko kèm icon, bo tròn pill như menu.php -->
        <div>
          <button type="button" class="btn btn-order-submit-footer rounded-pill" id="btnPlaceOrderBottom">
            Đặt Món Ngay
          </button>
        </div>
      </div>
    </div>

    <!-- Toast thông báo nhỏ -->
    <div class="food-toast-alert" id="orderToastAlert">
      <i class="bi bi-check-circle-fill"></i>
      <span id="orderToastText">Đã cập nhật đơn hàng</span>
    </div>

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS chung -->
    <script src="public/js/main.js"></script>

    <!-- Script xử lý dữ liệu đơn hàng & thanh toán -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const orderEmptyState = document.getElementById("orderEmptyState");
        const orderContentWrap = document.getElementById("orderContentWrap");
        const orderItemsContainer = document.getElementById("orderItemsContainer");
        const orderSummaryBadge = document.getElementById("orderSummaryBadge");
        const subtotalAmount = document.getElementById("subtotalAmount");
        const grandTotalAmount = document.getElementById("grandTotalAmount");

        const orderBottomFooterBar = document.getElementById("orderBottomFooterBar");
        const footerGrandTotal = document.getElementById("footerGrandTotal");
        const btnPlaceOrderBottom = document.getElementById("btnPlaceOrderBottom");

        const btnPayCash = document.getElementById("btnPayCash");
        const btnPayBank = document.getElementById("btnPayBank");

        const orderToast = document.getElementById("orderToastAlert");
        const orderToastText = document.getElementById("orderToastText");

        let cart = [];
        let selectedPaymentMethod = "cash"; // 'cash' hoặc 'bank'

        // Tạo mã đơn ngẫu nhiên đẹp mắt (vd: CG-6281)
        const randomOrderNum = Math.floor(1000 + Math.random() * 9000);
        const orderCode = `CG-${randomOrderNum}`;

        // Đọc giỏ hàng từ localStorage
        function loadCartFromStorage() {
          try {
            const data = localStorage.getItem("chingu_cart");
            if (data) {
              cart = JSON.parse(data);
            } else {
              cart = [];
            }
          } catch (e) {
            cart = [];
          }
        }

        // Lưu giỏ hàng vào localStorage
        function saveCartToStorage() {
          try {
            localStorage.setItem("chingu_cart", JSON.stringify(cart));
          } catch (e) {}
        }

        // Định dạng tiền tệ
        function formatMoney(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " đ";
        }

        // Toast thông báo
        let toastTimer = null;
        function showToast(msg) {
          if (!orderToast) return;
          orderToastText.textContent = msg;
          orderToast.classList.add("show");
          clearTimeout(toastTimer);
          toastTimer = setTimeout(() => {
            orderToast.classList.remove("show");
          }, 2400);
        }

        // Render giao diện đơn hàng
        function renderOrderPage() {
          const successScreen = document.getElementById("orderSuccessScreen");
          if (successScreen && !successScreen.classList.contains("d-none")) {
            return;
          }

          if (!cart || cart.length === 0) {
            if (orderEmptyState) orderEmptyState.classList.remove("d-none");
            if (orderContentWrap) orderContentWrap.classList.add("d-none");
            if (orderBottomFooterBar) orderBottomFooterBar.classList.add("d-none");
            return;
          }

          if (orderEmptyState) orderEmptyState.classList.add("d-none");
          if (orderContentWrap) orderContentWrap.classList.remove("d-none");
          if (orderBottomFooterBar) orderBottomFooterBar.classList.remove("d-none");

          const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
          const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

          if (orderSummaryBadge) orderSummaryBadge.textContent = `${totalItems} món`;
          if (subtotalAmount) subtotalAmount.textContent = formatMoney(totalPrice);
          if (grandTotalAmount) grandTotalAmount.textContent = formatMoney(totalPrice);
          if (footerGrandTotal) footerGrandTotal.textContent = formatMoney(totalPrice);

          // Render danh sách món (đã xóa nút thùng rác theo yêu cầu)
          let html = "";
          cart.forEach((item) => {
            const itemTotal = item.price * item.qty;
            html += `
              <div class="order-item-entry" data-id="${item.id}">
                <img src="${item.img || 'public/assets/images/logo.png'}" alt="${item.name}" class="order-item-thumb" />
                <div class="order-item-details">
                  <div class="order-item-name">${item.name}</div>
                  <div class="order-item-meta">${formatMoney(item.price)} / món</div>
                  ${item.note ? `<div class="order-item-note"><i class="bi bi-pencil-square me-1"></i>Lưu ý: ${item.note}</div>` : ''}
                  
                  <!-- Nút tăng giảm số lượng (+, -) -->
                  <div class="d-flex align-items-center mt-2">
                    <div class="cart-item-stepper d-flex align-items-center">
                      <button type="button" class="btn-cart-stepper btn-order-minus" data-id="${item.id}" aria-label="Giảm">
                        <i class="bi bi-dash"></i>
                      </button>
                      <span class="cart-stepper-qty px-2">${item.qty}</span>
                      <button type="button" class="btn-cart-stepper btn-order-plus" data-id="${item.id}" aria-label="Tăng">
                        <i class="bi bi-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="order-item-price-col">
                  <div class="order-item-total">${formatMoney(itemTotal)}</div>
                </div>
              </div>
            `;
          });

          orderItemsContainer.innerHTML = html;

          // Gắn sự kiện tăng số lượng
          orderItemsContainer.querySelectorAll(".btn-order-plus").forEach((btn) => {
            btn.addEventListener("click", function () {
              const id = this.getAttribute("data-id");
              const item = cart.find(i => i.id === id);
              if (item) {
                item.qty++;
                saveCartToStorage();
                renderOrderPage();
              }
            });
          });

          // Gắn sự kiện giảm số lượng (nếu giảm dưới 1 thì xóa khỏi danh sách)
          orderItemsContainer.querySelectorAll(".btn-order-minus").forEach((btn) => {
            btn.addEventListener("click", function () {
              const id = this.getAttribute("data-id");
              const item = cart.find(i => i.id === id);
              if (item) {
                if (item.qty > 1) {
                  item.qty--;
                } else {
                  cart = cart.filter(i => i.id !== id);
                  showToast("Đã xóa món khỏi đơn hàng");
                }
                saveCartToStorage();
                renderOrderPage();
              }
            });
          });
        }

        // Chuyển đổi hai hình thức thanh toán (Tiền mặt hoặc Ngân hàng, không hiển thị mã QR)
        if (btnPayCash && btnPayBank) {
          btnPayCash.addEventListener("click", function () {
            btnPayCash.classList.add("active");
            btnPayBank.classList.remove("active");
            selectedPaymentMethod = "cash";
          });

          btnPayBank.addEventListener("click", function () {
            btnPayBank.classList.add("active");
            btnPayCash.classList.remove("active");
            selectedPaymentMethod = "bank";
          });
        }

        // Xóa class cảnh báo invalid khi người dùng gõ vào ô họ tên
        const custNameInput = document.getElementById("custName");
        if (custNameInput) {
          custNameInput.addEventListener("input", function () {
            if (this.value.trim().length > 0) {
              this.classList.remove("is-invalid");
            }
          });
        }

        let confirmedOrderTrackingCode = <?= json_encode($lastOrder['order_code'] ?? '') ?>;

        // Nút xem trạng thái đơn trong modal
        const btnViewOrderStatus = document.getElementById("btnViewOrderStatus");
        if (btnViewOrderStatus) {
          btnViewOrderStatus.addEventListener("click", function (e) {
            const codeToTrack = confirmedOrderTrackingCode || document.getElementById("confirmedOrderCode")?.textContent?.replace("#", "").trim();
            if (codeToTrack) {
              window.location.href = "index.php?pg=order-status&code=" + encodeURIComponent(codeToTrack);
            }
          });
        }

        // Hàm xử lý đặt món khi bấm nút Đặt Món Ngay ở chân trang
        function handlePlaceOrder() {
          if (!cart || cart.length === 0) {
            alert("Giỏ hàng của bạn đang trống!");
            return;
          }

          // Validate ô input họ tên khách hàng
          const custNameVal = custNameInput ? custNameInput.value.trim() : "";
          if (!custNameVal) {
            if (custNameInput) {
              custNameInput.classList.add("is-invalid");
              custNameInput.focus();
              custNameInput.scrollIntoView({ behavior: "smooth", block: "center" });
            }
            return;
          } else {
            if (custNameInput) {
              custNameInput.classList.remove("is-invalid");
            }
          }

          const custName = custNameVal;
          const custNote = document.getElementById("custOrderNote")?.value.trim() || "Không có ghi chú";
          const tableNumberVal = document.getElementById("orderTableNumber")?.value.trim() || "";
          const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

          // Vô hiệu hóa nút trong khi gửi request
          if (btnPlaceOrderBottom) {
            btnPlaceOrderBottom.disabled = true;
            btnPlaceOrderBottom.textContent = "Đang xử lý đơn...";
          }

          // Gửi dữ liệu đơn hàng lên máy chủ (lưu vào database)
          fetch("index.php?pg=order-submit", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              customer_name: custName,
              table_number: tableNumberVal,
              note: custNote,
              payment_method: selectedPaymentMethod,
              items: cart
            })
          })
          .then(res => res.json())
          .then(data => {
            if (btnPlaceOrderBottom) {
              btnPlaceOrderBottom.disabled = false;
              btnPlaceOrderBottom.textContent = "Đặt Món Ngay";
            }

            const finalOrderCode = (data && data.order_code) ? data.order_code : orderCode;
            confirmedOrderTrackingCode = finalOrderCode;

            // Điền thông tin vào Modal xác nhận thành công
            document.getElementById("confirmedOrderCode").textContent = `#${finalOrderCode}`;
            document.getElementById("modalCustName").textContent = custName;
            const modalTableEl = document.getElementById("modalTableNumber");
            if (modalTableEl) {
              modalTableEl.textContent = tableNumberVal || "Chưa chọn bàn";
            }
            document.getElementById("modalCustNote").textContent = custNote;
            document.getElementById("modalPaymentMethod").textContent = selectedPaymentMethod === "cash" ? "Tiền Mặt" : "Chuyển Khoản Ngân Hàng";
            document.getElementById("modalPaymentMethod").className = selectedPaymentMethod === "cash" ? "badge bg-warning text-dark" : "badge bg-info text-dark";
            document.getElementById("modalGrandTotal").textContent = formatMoney(totalPrice);

            // Liệt kê món trong Modal
            const modalList = document.getElementById("modalOrderItemsList");
            if (modalList) {
              let itemsHtml = "";
              cart.forEach((item) => {
                itemsHtml += `
                  <div class="d-flex justify-content-between text-white-50 py-1">
                    <span>${item.name} <strong class="text-white">x${item.qty}</strong></span>
                    <span class="text-warning">${formatMoney(item.price * item.qty)}</span>
                  </div>
                `;
              });
              modalList.innerHTML = itemsHtml;
            }

            // Ẩn hero banner, form giỏ hàng và thanh chân trang
            const heroBanner = document.getElementById("orderHeroBanner");
            if (heroBanner) heroBanner.classList.add("d-none");

            if (orderContentWrap) orderContentWrap.classList.add("d-none");
            if (orderEmptyState) orderEmptyState.classList.add("d-none");
            if (orderBottomFooterBar) orderBottomFooterBar.classList.add("d-none");

            // Hiển thị màn hình thành công full màn hình bên trong body
            const successScreen = document.getElementById("orderSuccessScreen");
            if (successScreen) {
              successScreen.classList.remove("d-none");
            }

            // Gỡ khoảng trống đệm chân trang của body & chuyển wrapper sang chế độ compact
            document.body.classList.add("order-success-mode");
            document.body.style.paddingBottom = "0px";
            const pageWrapper = document.getElementById("orderPageWrapper");
            if (pageWrapper) {
              pageWrapper.classList.add("order-success-mode");
              pageWrapper.classList.remove("py-4", "py-lg-5");
            }

            // Cuộn mượt lên đầu trang
            window.scrollTo({ top: 0, behavior: "smooth" });

            // Xóa sạch giỏ hàng trong localStorage
            localStorage.removeItem("chingu_cart");
            cart = [];
          })
          .catch(err => {
            if (btnPlaceOrderBottom) {
              btnPlaceOrderBottom.disabled = false;
              btnPlaceOrderBottom.textContent = "Đặt Món Ngay";
            }
            alert("Có lỗi kết nối máy chủ khi lưu đơn. Vui lòng thử lại!");
          });
        }

        // Bấm nút Đặt Món Ngay ở thanh chân trang
        if (btnPlaceOrderBottom) {
          btnPlaceOrderBottom.addEventListener("click", handlePlaceOrder);
        }

        // Đồng bộ bàn ăn từ query param hoặc localStorage nếu chưa có
        const urlParams = new URLSearchParams(window.location.search);
        let tableParam = urlParams.get("table") || localStorage.getItem("chingu_table");
        if (tableParam) {
          if (!isNaN(tableParam) && !tableParam.toString().startsWith("Bàn")) {
            tableParam = "Bàn " + tableParam.toString().padStart(2, "0");
          } else if (!tableParam.toString().toLowerCase().includes("bàn")) {
            tableParam = "Bàn " + tableParam;
          }
          const tableInput = document.getElementById("orderTableNumber");
          if (tableInput && (!tableInput.value || tableInput.value === "Chưa chọn bàn")) {
            tableInput.value = tableParam;
          }
          // Cập nhật nút "Khám Phá Thực Đơn Ngay" quay về menu của đúng bàn đó
          const btnEmptyMenu = document.getElementById("btnEmptyMenu");
          if (btnEmptyMenu) {
            btnEmptyMenu.href = "index.php?pg=menu&table=" + encodeURIComponent(tableParam);
          }
        }

        // Khởi chạy khi load trang
        loadCartFromStorage();
        renderOrderPage();
      });
    </script>
  </body>
</html>
