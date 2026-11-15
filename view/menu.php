<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu Thực Đơn - Chingu Korean Restaurant</title>

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

    <!-- Custom CSS kế thừa từ landing page -->
    <link rel="stylesheet" href="public/css/style.css" />

    <style>
      body.mode-view-only .menu-album-card {
        cursor: default !important;
      }
      body.mode-view-only .floating-cart-bar {
        display: none !important;
      }
    </style>
  </head>
  <body class="<?= (empty($currentTable) || !empty($isTableOccupied)) ? 'mode-view-only' : 'mode-table-order' ?>">


    <!-- =========================================================================
       1. HEADER / NAVBAR CỐ ĐỊNH (CHỈ GIỮ LOGO NHÀ HÀNG)
       ========================================================================= -->
    <nav class="navbar custom-navbar">
      <div class="container d-flex align-items-center justify-content-between">
        <!-- Logo Nhà hàng Chingu -->
        <a
          class="navbar-brand text-white fw-bold d-flex align-items-center gap-2"
          href="index.php"
        >
          <span
            >CHINGU
            <small class="fw-normal text-warning">RESTAURANT</small></span
          >
        </a>

        <?php if (!empty($currentTable) && empty($isTableOccupied)): ?>
          <!-- Huy hiệu bàn ăn hiển thị trên Header khi quét QR hoặc truy cập kèm table=XX -->
          <div class="header-table-badge d-flex align-items-center">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.9rem; letter-spacing: 0.3px;">
              <span id="headerDisplayTableName"><?= htmlspecialchars($currentTable) ?></span>
            </span>
          </div>
        <?php endif; ?>
      </div>
    </nav>

    <?php if (!empty($isTableOccupied)): ?>
      <!-- MÀN HÌNH THÔNG BÁO BÀN HIỆN TẠI KHÔNG KHẢ DỤNG ĐỂ ĐẶT MÓN -->
      <main class="d-flex align-items-center justify-content-center text-center py-5" style="min-height: calc(100vh - 80px); padding-top: 90px;">
        <div class="container" style="max-width: 480px;">
          <div class="p-4 p-md-5 rounded-4 shadow-lg border border-secondary border-opacity-25" style="background: #181516;">
            <div class="mb-4">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: rgba(230, 57, 70, 0.12); border: 2px dashed rgba(230, 57, 70, 0.4);">
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 2.8rem;"></i>
              </div>
            </div>
            <h2 class="text-white fw-bold mb-3 fs-4" style="line-height: 1.4;">
              Bàn hiện tại không khả dụng để đặt món
            </h2>
            <p class="text-white-50 small mb-4">
              Bàn <strong class="text-warning"><?= htmlspecialchars($currentTable) ?></strong> hiện đang trong trạng thái phục vụ. Quý khách vui lòng liên hệ nhân viên để được hỗ trợ hoặc xem thực đơn tham khảo.
            </p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
              <a href="index.php?pg=menu" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
                <i class="bi bi-book me-1"></i> Xem thực đơn
              </a>
              <a href="index.php" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-house me-1"></i> Trang chủ
              </a>
            </div>
          </div>
        </div>
      </main>
    <?php else: ?>

    <!-- =========================================================================
       2. HERO BANNER TRANG MENU
       ========================================================================= -->
    <header class="menu-hero-header">
      <div class="container">
        <span class="badge-tag">Korean BBQ & Hotpot Dining</span>
        <h1 class="menu-hero-title">Thực Đơn Chingu</h1>
      </div>
    </header>

    <!-- =========================================================================
       3. THANH DANH MỤC FILTER (STICKY CATEGORY NAV - TẤT CẢ & TÌM KIẾM)
       ========================================================================= -->
    <div class="menu-nav-wrapper">
      <div class="container position-relative">
        <div class="menu-filter-bar position-relative d-flex align-items-center justify-content-between">
          <!-- Dropdown Danh mục: "Tất cả" (Nền đen chữ trắng) -->
          <div class="dropdown category-dropdown-wrap">
            <button
              class="btn btn-category-pill dropdown-toggle d-flex align-items-center"
              type="button"
              id="categoryDropdownBtn"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <span id="selectedCategoryText">Tất cả</span>
              <i class="bi bi-chevron-down ms-2"></i>
            </button>
            <ul
              class="dropdown-menu category-dropdown-menu shadow-lg"
              aria-labelledby="categoryDropdownBtn"
            >
              <li>
                <button
                  class="dropdown-item category-select-item active"
                  data-category="all"
                  type="button"
                >
                  Tất cả
                </button>
              </li>
              <li><hr class="dropdown-divider my-1" /></li>
              <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                  <li>
                    <button
                      class="dropdown-item category-select-item"
                      data-category="<?= htmlspecialchars($cat['slug']) ?>"
                      type="button"
                    >
                      <?= htmlspecialchars($cat['name']) ?>
                    </button>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <li><button class="dropdown-item category-select-item" data-category="bbq" type="button">Thịt Nướng K-BBQ</button></li>
                <li><button class="dropdown-item category-select-item" data-category="hotpot" type="button">Lẩu Hàn Quốc</button></li>
                <li><button class="dropdown-item category-select-item" data-category="pocha" type="button">Gà Rán & Món Pocha</button></li>
                <li><button class="dropdown-item category-select-item" data-category="drinks" type="button">Đồ Uống & Soju</button></li>
              <?php endif; ?>
            </ul>
          </div>

          <!-- Nút mở tìm kiếm tròn (Nền đen chữ trắng) -->
          <button
            class="btn btn-menu-search"
            id="btnSearchToggle"
            type="button"
            title="Tìm kiếm món ăn"
          >
            <i class="bi bi-search"></i>
          </button>

          <!-- Khung tìm kiếm full độ rộng đè lên toàn bộ thanh danh mục khi mở -->
          <div class="menu-search-overlay" id="menuSearchOverlay">
            <div class="search-overlay-inner d-flex align-items-center w-100">
              <i class="bi bi-search search-lead-icon me-2"></i>
              <input
                type="text"
                id="menuSearchInput"
                class="form-control menu-search-input-full"
                placeholder="Tìm món theo tên, nguyên liệu..."
                autocomplete="off"
              />
              <button
                class="btn btn-search-clear"
                id="btnSearchClear"
                type="button"
                title="Xóa nội dung tìm kiếm"
              >
                <i class="bi bi-x-circle-fill"></i>
              </button>
              <button
                class="btn btn-search-close ms-1"
                id="btnSearchClose"
                type="button"
                title="Đóng tìm kiếm"
              >
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- =========================================================================
       4. BODY: ALBUM THỰC ĐƠN CHI TIẾT
       ========================================================================= -->
    <main
      class="py-3 py-lg-5"
      style="background-color: #121011; min-height: 800px"
    >
      <div class="container">
        <!-- ==================== CÁC PHÂN KHU THỰC ĐƠN TỪ CƠ SỞ DỮ LIỆU ==================== -->
        <?php if (!empty($categories)): ?>
          <?php foreach ($categories as $cat): 
            $slug = $cat['slug'];
            $catProducts = $groupedProducts[$slug] ?? [];
            if (empty($catProducts)) continue;
          ?>
            <section class="menu-category-section mb-5" data-section="<?= htmlspecialchars($slug) ?>">
              <div class="menu-section-heading">
                <h3><?= htmlspecialchars($cat['name']) ?></h3>
              </div>

              <div class="row g-2 g-md-3 g-lg-4">
                <?php foreach ($catProducts as $product): ?>
                  <div class="col-6 col-md-6 col-lg-3">
                    <div class="menu-album-card" data-id="<?= $product['id'] ?>">
                      <div class="album-img-wrap">
                        <img
                          src="<?= htmlspecialchars($product['image'] ?: 'public/assets/images/logo.png') ?>"
                          alt="<?= htmlspecialchars($product['name']) ?>"
                          class="album-img"
                          loading="lazy"
                        />
                        <?php if (!empty($product['badge'])): ?>
                          <span class="album-badge bg-danger"><?= htmlspecialchars($product['badge']) ?></span>
                        <?php endif; ?>
                      </div>
                      <div class="album-body">
                        <div class="album-title-group">
                          <h4 class="album-name"><?= htmlspecialchars($product['name']) ?></h4>
                          <?php if (!empty($product['korean_name'])): ?>
                            <div class="album-korean-name"><?= htmlspecialchars($product['korean_name']) ?></div>
                          <?php endif; ?>
                        </div>
                        <p class="album-desc">
                          <?= htmlspecialchars($product['description'] ?? '') ?>
                        </p>
                        <div class="album-footer">
                          <div class="album-price"><?= number_format($product['price'], 0, ',', '.') ?> <small>đ</small></div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </main>

    <!-- =========================================================================
       5. FLYOUT CHI TIẾT MÓN ĂN (BOTTOM SHEET THEO MẪU GRABFOOD)
       ========================================================================= -->
    <div class="food-flyout-backdrop" id="foodFlyoutBackdrop"></div>
    <div
      class="food-flyout-sheet"
      id="foodFlyoutSheet"
      role="dialog"
      aria-modal="true"
      aria-hidden="true"
    >
      <!-- Ảnh món ăn & Nút điều khiển -->
      <div class="flyout-image-wrap">
        <img src="" alt="" id="flyoutImg" class="flyout-img" />
        <button
          type="button"
          class="btn-flyout-circle btn-flyout-close"
          id="btnFlyoutClose"
          aria-label="Đóng"
        >
          <i class="bi bi-x-lg"></i>
        </button>
        <div class="flyout-drag-handle"></div>
      </div>

      <!-- Nội dung chi tiết món -->
      <div class="flyout-content-scroll">
        <!-- Tên món và giá -->
        <div class="flyout-header-info">
          <div class="d-flex align-items-start justify-content-between gap-3 mb-1">
            <h2 class="flyout-title" id="flyoutTitle">Tên món ăn</h2>
            <div class="flyout-price" id="flyoutPrice">0</div>
          </div>
          <div class="flyout-korean" id="flyoutKorean"></div>
          <p class="flyout-desc" id="flyoutDesc">Mô tả món ăn</p>
        </div>

        <div class="flyout-divider"></div>

        <!-- Thêm lưu ý cho quán -->
        <div class="flyout-note-section">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <label for="flyoutNoteInput" class="flyout-section-label">Thêm lưu ý cho quán</label>
            <span class="flyout-badge-optional">Không bắt buộc</span>
          </div>
          <textarea
            id="flyoutNoteInput"
            class="form-control flyout-note-textarea"
            rows="2"
            placeholder="Việc thực hiện yêu cầu còn tùy thuộc vào khả năng của quán."
          ></textarea>
        </div>

        <!-- Bộ tăng giảm số lượng món -->
        <div class="flyout-quantity-section d-flex align-items-center justify-content-center">
          <button
            type="button"
            class="btn-qty btn-qty-minus is-disabled"
            id="btnQtyMinus"
            aria-label="Giảm số lượng"
          >
            <i class="bi bi-dash"></i>
          </button>
          <span class="qty-display" id="flyoutQtyDisplay">1</span>
          <button
            type="button"
            class="btn-qty btn-qty-plus"
            id="btnQtyPlus"
            aria-label="Tăng số lượng"
          >
            <i class="bi bi-plus"></i>
          </button>
        </div>
      </div>

      <!-- Thanh hành động dính đáy (Sticky Button) -->
      <div class="flyout-footer-action">
        <button type="button" class="btn btn-flyout-submit" id="btnFlyoutSubmit">
          Thêm vào giỏ hàng - <span id="flyoutSubmitPrice">0</span>
        </button>
      </div>
    </div>

    <!-- Toast thông báo nhỏ gọn -->
    <div class="food-toast-alert" id="foodToastAlert">
      <i class="bi bi-check-circle-fill"></i>
      <span id="foodToastText">Đã thêm món ăn thành công!</span>
    </div>

    <!-- =========================================================================
       6. THANH NÚT GIỎ HÀNG CHÂN TRANG (FLOATING CART BAR THEO MẪU)
       ========================================================================= -->
    <div class="floating-cart-bar" id="floatingCartBar">
      <div class="floating-cart-container">
        <button type="button" class="btn btn-floating-cart" id="btnOpenCart">
          <span class="cart-summary-text" id="cartSummaryText">Giỏ hàng • 1 món</span>
          <span class="cart-summary-price" id="cartSummaryPrice">0 đ</span>
        </button>
      </div>
    </div>

    <!-- =========================================================================
       7. FLYOUT GIỎ HÀNG (LIỆT KÊ MÓN ĐÃ THÊM & NÚT XÁC NHẬN ĐẶT MÓN)
       ========================================================================= -->
    <div class="cart-flyout-backdrop" id="cartFlyoutBackdrop"></div>
    <div
      class="cart-flyout-sheet"
      id="cartFlyoutSheet"
      role="dialog"
      aria-modal="true"
      aria-hidden="true"
    >
      <!-- Header của Giỏ hàng -->
      <div class="cart-flyout-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <h3 class="cart-flyout-title mb-0">Món đã chọn</h3>
          <span class="badge cart-item-count-badge" id="cartItemBadge">0 món</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button type="button" class="btn-clear-cart" id="btnClearCart" title="Xóa tất cả món">
            <i class="bi bi-trash3 me-1"></i> Xóa hết
          </button>
          <button type="button" class="btn-cart-close" id="btnCartClose" aria-label="Đóng giỏ hàng">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>

      <!-- Danh sách món ăn trong giỏ -->
      <div class="cart-items-scroll" id="cartItemsList">
        <!-- Render động bằng JavaScript -->
      </div>

      <!-- Footer Giỏ hàng: Đổi sang nút "Xác nhận đặt món" -->
      <div class="cart-flyout-footer">
        <div class="d-flex align-items-center justify-content-between cart-total-row mb-2">
          <span class="cart-total-label">Tổng cộng tạm tính:</span>
          <span class="cart-total-val" id="cartTotalVal">0 đ</span>
        </div>
        <button type="button" class="btn btn-confirm-order" id="btnConfirmOrder">
          Xác nhận đặt món - <span id="cartConfirmPrice">0 đ</span>
        </button>
      </div>
    </div>
    <?php endif; ?>

    <!-- Modal Thông Báo Đặt Món Thành Công -->
    <div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content order-success-card text-center p-4">
          <div class="order-success-icon mx-auto mb-3">
            <i class="bi bi-check2-circle text-success fs-1"></i>
          </div>
          <h4 class="text-white fw-bold mb-2">Đặt Món Thành Công!</h4>
          <p class="text-white-50 fs-6 mb-3">
            Cảm ơn bạn! Đơn gọi món của bạn đã được chuyển tới quầy bếp Chingu để chuẩn bị ngay.
          </p>
          <div class="order-summary-box text-start mb-3 p-3" id="orderSuccessItems"></div>
          <button type="button" class="btn btn-primary-gold w-100 py-2 fw-semibold" data-bs-dismiss="modal">
            Tiếp Tục Xem Thực Đơn
          </button>
        </div>
      </div>
    </div>

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS chung -->
    <script src="public/js/main.js"></script>

    <!-- Script lọc danh mục & tìm kiếm món ăn mượt mà -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const categoryItems = document.querySelectorAll(".category-select-item");
        const selectedText = document.getElementById("selectedCategoryText");
        const sections = document.querySelectorAll(".menu-category-section");

        const searchOverlay = document.getElementById("menuSearchOverlay");
        const searchToggle = document.getElementById("btnSearchToggle");
        const searchClose = document.getElementById("btnSearchClose");
        const searchInput = document.getElementById("menuSearchInput");
        const searchClear = document.getElementById("btnSearchClear");

        let activeCategory = "all";
        let searchQuery = "";

        // Hàm cập nhật hiển thị món theo category & search
        function filterMenu() {
          const query = searchQuery.trim().toLowerCase();

          sections.forEach((sec) => {
            const secCategory = sec.getAttribute("data-section");
            const matchCategory =
              activeCategory === "all" || secCategory === activeCategory;

            if (!matchCategory) {
              sec.style.display = "none";
              return;
            }

            // Kiểm tra các món bên trong section
            const cards = sec.querySelectorAll(".menu-album-card");
            let visibleCount = 0;

            cards.forEach((card) => {
              const col = card.closest('[class*="col-"]');
              const name =
                card.querySelector(".album-name")?.textContent.toLowerCase() ||
                "";
              const korean =
                card
                  .querySelector(".album-korean-name")
                  ?.textContent.toLowerCase() || "";
              const desc =
                card.querySelector(".album-desc")?.textContent.toLowerCase() ||
                "";

              const matchQuery =
                !query ||
                name.includes(query) ||
                korean.includes(query) ||
                desc.includes(query);

              if (matchQuery) {
                if (col) col.style.display = "";
                visibleCount++;
              } else {
                if (col) col.style.display = "none";
              }
            });

            // Nếu trong section có món phù hợp thì hiện section, ngược lại ẩn
            sec.style.display = visibleCount > 0 ? "block" : "none";
          });

          if (typeof window.updateNavbarAndFilter === "function") {
            window.updateNavbarAndFilter();
          }
        }

        // Bắt sự kiện chọn danh mục từ Dropdown
        categoryItems.forEach((item) => {
          item.addEventListener("click", function () {
            categoryItems.forEach((i) => i.classList.remove("active"));
            this.classList.add("active");

            activeCategory = this.getAttribute("data-category");

            // Cập nhật text hiển thị trên nút dropdown: "Tất cả" khi chọn all
            const categoryName = activeCategory === "all" ? "Tất cả" : this.textContent.trim();
            selectedText.textContent = categoryName;
            selectedText.title = categoryName;
            const dropdownBtn = document.getElementById("categoryDropdownBtn");
            if (dropdownBtn) dropdownBtn.title = categoryName;

            filterMenu();
          });
        });

        // Mở thanh tìm kiếm phủ full-width đè lên thanh filter
        if (searchToggle && searchOverlay) {
          searchToggle.addEventListener("click", function () {
            searchOverlay.classList.add("open");
            setTimeout(() => {
              searchInput.focus();
            }, 100);
          });
        }

        // Đóng thanh tìm kiếm
        function closeSearch() {
          if (!searchOverlay) return;
          searchOverlay.classList.remove("open");
          if (searchInput.value) {
            searchInput.value = "";
            searchQuery = "";
            if (searchClear) searchClear.classList.remove("visible");
            filterMenu();
          }
        }

        if (searchClose) {
          searchClose.addEventListener("click", closeSearch);
        }

        // Đóng khi nhấn phím ESC
        document.addEventListener("keydown", function (e) {
          if (e.key === "Escape" && searchOverlay.classList.contains("open")) {
            closeSearch();
          }
        });

        // Bắt sự kiện nhập từ khóa tìm kiếm
        if (searchInput) {
          searchInput.addEventListener("input", function () {
            searchQuery = this.value;
            if (searchClear) {
              if (this.value.trim().length > 0) {
                searchClear.classList.add("visible");
              } else {
                searchClear.classList.remove("visible");
              }
            }
            filterMenu();
          });
        }

        // Xóa nhanh từ khóa tìm kiếm
        if (searchClear && searchInput) {
          searchClear.addEventListener("click", function () {
            searchInput.value = "";
            searchQuery = "";
            searchClear.classList.remove("visible");
            searchInput.focus();
            filterMenu();
          });
        }

        // =====================================================================
        // XỬ LÝ FLYOUT THẺ CHI TIẾT MÓN ĂN (BOTTOM SHEET THEO MẪU GRABFOOD)
        // =====================================================================
        const flyoutBackdrop = document.getElementById("foodFlyoutBackdrop");
        const flyoutSheet = document.getElementById("foodFlyoutSheet");
        const flyoutImg = document.getElementById("flyoutImg");
        const flyoutTitle = document.getElementById("flyoutTitle");
        const flyoutKorean = document.getElementById("flyoutKorean");
        const flyoutPrice = document.getElementById("flyoutPrice");
        const flyoutDesc = document.getElementById("flyoutDesc");
        const flyoutNoteInput = document.getElementById("flyoutNoteInput");
        const flyoutQtyDisplay = document.getElementById("flyoutQtyDisplay");
        const flyoutSubmitPrice = document.getElementById("flyoutSubmitPrice");
        const btnQtyMinus = document.getElementById("btnQtyMinus");
        const btnQtyPlus = document.getElementById("btnQtyPlus");
        const btnFlyoutClose = document.getElementById("btnFlyoutClose");
        const btnFlyoutSubmit = document.getElementById("btnFlyoutSubmit");
        const foodToast = document.getElementById("foodToastAlert");
        const foodToastText = document.getElementById("foodToastText");

        let currentUnitPrice = 0;
        let currentQty = 1;
        let currentDishTitle = "";

        // Hàm định dạng số tiền (vd: 55000 -> 55.000)
        function formatPriceNumber(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Hàm trích xuất giá số từ text (vd: "289.000 đ" -> 289000)
        function extractPrice(str) {
          const digits = str.replace(/[^\d]/g, "");
          return parseInt(digits, 10) || 0;
        }

        // Cập nhật giá trên nút CTA và trạng thái nút trừ
        function updateFlyoutPricing() {
          const total = currentUnitPrice * currentQty;
          if (flyoutSubmitPrice) {
            flyoutSubmitPrice.textContent = formatPriceNumber(total);
          }
          if (flyoutQtyDisplay) {
            flyoutQtyDisplay.textContent = currentQty;
          }
          if (btnQtyMinus) {
            if (currentQty <= 1) {
              btnQtyMinus.classList.add("is-disabled");
            } else {
              btnQtyMinus.classList.remove("is-disabled");
            }
          }
        }

        // Hiển thị Toast thông báo
        let toastTimer = null;
        function showToast(message) {
          if (!foodToast) return;
          foodToastText.textContent = message;
          foodToast.classList.add("show");
          clearTimeout(toastTimer);
          toastTimer = setTimeout(() => {
            foodToast.classList.remove("show");
          }, 2600);
        }

        // Cờ cho phép đặt món (chỉ cho phép khi có tiền tố ?table=XX và bàn sẵn sàng phục vụ)
        const canOrder = <?= json_encode(!empty($currentTable) && empty($isTableOccupied)) ?>;

        let currentDishId = "";

        // Mở Flyout khi bấm vào món
        function openFlyout(card) {
          if (!canOrder) return;
          currentDishId = card.getAttribute("data-id") || "";
          const imgSrc =
            card.querySelector(".album-img")?.getAttribute("src") || "";
          const name =
            card.querySelector(".album-name")?.textContent.trim() || "";
          const korean =
            card.querySelector(".album-korean-name")?.textContent.trim() || "";
          const desc =
            card.querySelector(".album-desc")?.textContent.trim() || "";
          const priceStr =
            card.querySelector(".album-price")?.textContent.trim() || "0";

          currentUnitPrice = extractPrice(priceStr);
          currentQty = 1;
          currentDishTitle = name;
          currentDishImg = imgSrc;

          if (flyoutImg) {
            flyoutImg.src = imgSrc;
            flyoutImg.alt = name;
          }
          if (flyoutTitle) flyoutTitle.textContent = name;
          if (flyoutKorean) flyoutKorean.textContent = korean;
          if (flyoutDesc) flyoutDesc.textContent = desc;
          if (flyoutPrice)
            flyoutPrice.textContent = formatPriceNumber(currentUnitPrice);
          if (flyoutNoteInput) flyoutNoteInput.value = "";

          updateFlyoutPricing();

          if (flyoutBackdrop) flyoutBackdrop.classList.add("show");
          if (flyoutSheet) flyoutSheet.classList.add("open");
          document.body.style.overflow = "hidden";
        }

        // Đóng Flyout
        function closeFlyout() {
          if (!flyoutSheet) return;
          flyoutSheet.classList.remove("open");
          if (flyoutBackdrop) flyoutBackdrop.classList.remove("show");
          document.body.style.overflow = "";
        }

        // Bắt sự kiện click vào các thẻ món ăn (chỉ kích hoạt khi ở chế độ đặt món theo bàn)
        const foodCards = document.querySelectorAll(".menu-album-card");
        if (canOrder) {
          foodCards.forEach((card) => {
            card.style.cursor = "pointer";
            card.addEventListener("click", function () {
              openFlyout(this);
            });
          });
        } else {
          foodCards.forEach((card) => {
            card.style.cursor = "default";
          });
        }

        // Bấm nút trừ (-)
        if (btnQtyMinus) {
          btnQtyMinus.addEventListener("click", function (e) {
            e.stopPropagation();
            if (currentQty > 1) {
              currentQty--;
              updateFlyoutPricing();
            }
          });
        }

        // Bấm nút cộng (+)
        if (btnQtyPlus) {
          btnQtyPlus.addEventListener("click", function (e) {
            e.stopPropagation();
            currentQty++;
            updateFlyoutPricing();
          });
        }

        // Bấm nút đóng (x) hoặc bấm ra vùng mờ (backdrop)
        if (btnFlyoutClose) {
          btnFlyoutClose.addEventListener("click", function (e) {
            e.stopPropagation();
            closeFlyout();
          });
        }
        if (flyoutBackdrop) {
          flyoutBackdrop.addEventListener("click", closeFlyout);
        }

        // Đóng khi ấn Escape
        document.addEventListener("keydown", function (e) {
          if (e.key === "Escape") {
            if (cartFlyoutSheet && cartFlyoutSheet.classList.contains("open")) {
              closeCartFlyout();
            } else if (flyoutSheet && flyoutSheet.classList.contains("open")) {
              closeFlyout();
            }
          }
        });

        // =====================================================================
        // QUẢN LÝ GIỎ HÀNG & FLYOUT LIỆT KÊ MÓN / XÁC NHẬN ĐẶT MÓN
        // =====================================================================
        let cart = [];
        try {
          const stored = localStorage.getItem("chingu_cart");
          if (stored) {
            cart = JSON.parse(stored);
          }
        } catch (e) {
          cart = [];
        }
        let currentDishImg = "";

        const floatingCartBar = document.getElementById("floatingCartBar");
        const cartSummaryText = document.getElementById("cartSummaryText");
        const cartSummaryPrice = document.getElementById("cartSummaryPrice");

        const cartFlyoutBackdrop = document.getElementById("cartFlyoutBackdrop");
        const cartFlyoutSheet = document.getElementById("cartFlyoutSheet");
        const cartItemsList = document.getElementById("cartItemsList");
        const cartItemBadge = document.getElementById("cartItemBadge");
        const cartTotalVal = document.getElementById("cartTotalVal");
        const cartConfirmPrice = document.getElementById("cartConfirmPrice");
        const btnOpenCart = document.getElementById("btnOpenCart");
        const btnCartClose = document.getElementById("btnCartClose");
        const btnClearCart = document.getElementById("btnClearCart");
        const btnConfirmOrder = document.getElementById("btnConfirmOrder");

        // Cập nhật trạng thái hiển thị của thanh nút Giỏ hàng nổi ở chân trang
        function updateFloatingCartBar() {
          if (!canOrder) {
            if (floatingCartBar) floatingCartBar.classList.remove("visible");
            document.body.classList.remove("has-floating-cart");
            return;
          }

          try {
            localStorage.setItem("chingu_cart", JSON.stringify(cart));
          } catch (e) {}

          const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
          const totalPrice = cart.reduce(
            (sum, item) => sum + item.price * item.qty,
            0
          );

          if (totalItems > 0) {
            if (cartSummaryText)
              cartSummaryText.textContent = `Giỏ hàng • ${totalItems} món`;
            if (cartSummaryPrice)
              cartSummaryPrice.textContent = `${formatPriceNumber(totalPrice)} đ`;
            if (floatingCartBar) floatingCartBar.classList.add("visible");
            document.body.classList.add("has-floating-cart");
          } else {
            if (floatingCartBar) floatingCartBar.classList.remove("visible");
            document.body.classList.remove("has-floating-cart");
            closeCartFlyout();
          }
        }

        // Khởi tạo trạng thái thanh giỏ hàng khi tải trang
        updateFloatingCartBar();

        // Render danh sách món trong Flyout Giỏ hàng
        function renderCartItems() {
          if (!cartItemsList) return;

          const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
          const totalPrice = cart.reduce(
            (sum, item) => sum + item.price * item.qty,
            0
          );

          if (cartItemBadge) cartItemBadge.textContent = `${totalItems} món`;
          if (cartTotalVal)
            cartTotalVal.textContent = `${formatPriceNumber(totalPrice)} đ`;
          if (cartConfirmPrice)
            cartConfirmPrice.textContent = `${formatPriceNumber(totalPrice)} đ`;

          if (cart.length === 0) {
            cartItemsList.innerHTML = `
              <div class="cart-empty-state text-center py-5">
                <i class="bi bi-cart-x text-white-50 fs-1 mb-2"></i>
                <p class="text-white-50 mb-0">Chưa có món nào trong giỏ hàng</p>
              </div>
            `;
            return;
          }

          let html = "";
          cart.forEach((item) => {
            const itemSubtotal = item.price * item.qty;
            html += `
              <div class="cart-item-row" data-id="${item.id}">
                <div class="cart-item-img-wrap">
                  <img src="${item.img || 'public/assets/images/logo.png'}" alt="${item.name}" class="cart-item-img" />
                </div>
                <div class="cart-item-info">
                  <!-- HÀNG 1: Tiêu đề món & Thành tiền -->
                  <div class="cart-item-top d-flex align-items-start justify-content-between gap-2">
                    <h5 class="cart-item-name mb-0">${item.name}</h5>
                    <span class="cart-item-subtotal">${formatPriceNumber(itemSubtotal)} đ</span>
                  </div>

                  <!-- HÀNG 2: Đặt dưới hàng tiêu đề món: Nút +, - số lượng đặt ở hàng hai trước, kèm đơn giá -->
                  <div class="cart-item-bottom d-flex align-items-center justify-content-between mt-2">
                    <div class="cart-item-stepper d-flex align-items-center">
                      <button type="button" class="btn-cart-stepper btn-cart-minus" data-id="${item.id}" aria-label="Giảm số lượng">
                        <i class="bi bi-dash"></i>
                      </button>
                      <span class="cart-stepper-qty">${item.qty}</span>
                      <button type="button" class="btn-cart-stepper btn-cart-plus" data-id="${item.id}" aria-label="Tăng số lượng">
                        <i class="bi bi-plus"></i>
                      </button>
                    </div>
                    <div class="cart-item-note-or-price text-end">
                      <small class="cart-item-unitprice">${formatPriceNumber(item.price)} đ/món</small>
                    </div>
                  </div>
                  ${item.note ? `
                    <div class="cart-item-note-tag mt-1">
                      <i class="bi bi-pencil-square me-1"></i> Lưu ý: ${item.note}
                    </div>
                  ` : ''}
                </div>
              </div>
            `;
          });

          cartItemsList.innerHTML = html;

          // Bắt sự kiện tăng số lượng trong giỏ
          cartItemsList.querySelectorAll(".btn-cart-plus").forEach((btn) => {
            btn.addEventListener("click", function () {
              const id = this.getAttribute("data-id");
              const targetItem = cart.find((i) => i.id === id);
              if (targetItem) {
                targetItem.qty++;
                renderCartItems();
                updateFloatingCartBar();
              }
            });
          });

          // Bắt sự kiện giảm số lượng trong giỏ (giảm về 0 sẽ xóa món)
          cartItemsList.querySelectorAll(".btn-cart-minus").forEach((btn) => {
            btn.addEventListener("click", function () {
              const id = this.getAttribute("data-id");
              const targetItem = cart.find((i) => i.id === id);
              if (targetItem) {
                if (targetItem.qty > 1) {
                  targetItem.qty--;
                } else {
                  cart = cart.filter((i) => i.id !== id);
                }
                renderCartItems();
                updateFloatingCartBar();
              }
            });
          });
        }

        // Mở Flyout Giỏ hàng
        function openCartFlyout() {
          renderCartItems();
          if (cartFlyoutBackdrop) cartFlyoutBackdrop.classList.add("show");
          if (cartFlyoutSheet) cartFlyoutSheet.classList.add("open");
          document.body.style.overflow = "hidden";
        }

        // Đóng Flyout Giỏ hàng
        function closeCartFlyout() {
          if (cartFlyoutSheet) cartFlyoutSheet.classList.remove("open");
          if (cartFlyoutBackdrop) cartFlyoutBackdrop.classList.remove("show");
          document.body.style.overflow = "";
        }

        // Sự kiện mở / đóng Flyout Giỏ hàng
        if (btnOpenCart) {
          btnOpenCart.addEventListener("click", openCartFlyout);
        }
        if (btnCartClose) {
          btnCartClose.addEventListener("click", closeCartFlyout);
        }
        if (cartFlyoutBackdrop) {
          cartFlyoutBackdrop.addEventListener("click", closeCartFlyout);
        }

        // Xóa sạch giỏ hàng
        if (btnClearCart) {
          btnClearCart.addEventListener("click", function () {
            if (cart.length > 0) {
              cart = [];
              updateFloatingCartBar();
              closeCartFlyout();
              showToast("Đã xóa tất cả món trong giỏ hàng!");
            }
          });
        }

        // Bấm nút "Thêm vào giỏ hàng" trong thẻ chi tiết món
        if (btnFlyoutSubmit) {
          btnFlyoutSubmit.addEventListener("click", function (e) {
            e.stopPropagation();
            const note = flyoutNoteInput ? flyoutNoteInput.value.trim() : "";

            // Kiểm tra món đã có trong giỏ chưa
            const existingIndex = cart.findIndex(
              (item) => item.name === currentDishTitle && item.note === note
            );

            if (existingIndex > -1) {
              cart[existingIndex].qty += currentQty;
            } else {
              cart.push({
                id: currentDishId || ("item_" + Date.now() + "_" + Math.floor(Math.random() * 1000)),
                name: currentDishTitle,
                price: currentUnitPrice,
                qty: currentQty,
                img: currentDishImg,
                note: note,
              });
            }

            updateFloatingCartBar();
            const msg = `Đã thêm ${currentDishTitle} (x${currentQty}) vào giỏ hàng!`;
            showToast(msg);
            closeFlyout();
          });
        }

        // Bấm nút "Xác nhận đặt món" trong Flyout Giỏ hàng -> Chuyển sang trang order.php
        if (btnConfirmOrder) {
          btnConfirmOrder.addEventListener("click", function () {
            if (cart.length === 0) return;

            // Lưu dữ liệu giỏ hàng vào localStorage để trang order.php hiển thị
            try {
              localStorage.setItem("chingu_cart", JSON.stringify(cart));
              <?php if (!empty($currentTable)): ?>
                localStorage.setItem("chingu_table", <?= json_encode($currentTable) ?>);
              <?php endif; ?>
            } catch (e) {}

            closeCartFlyout();

            // Điều hướng sang trang order.php kèm thông tin bàn & cờ new=1 để đặt món mới
            const urlParams = new URLSearchParams(window.location.search);
            const tableParam = urlParams.get('table') || <?= json_encode($currentTable ?? '') ?>;
            let targetOrderUrl = "index.php?pg=order&new=1";
            if (tableParam) {
              targetOrderUrl += "&table=" + encodeURIComponent(tableParam);
            }
            window.location.href = targetOrderUrl;
          });
        }

        // Nếu ở chế độ chỉ xem menu (không có ?table=), dọn sạch bàn khỏi localStorage
        if (!canOrder) {
          try {
            localStorage.removeItem("chingu_table");
          } catch (e) {}
        }
      });
    </script>

  </body>
</html>
