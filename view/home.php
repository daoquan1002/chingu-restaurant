<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chingu Restaurant - Ẩm Thực Nướng & Lẩu Hàn Quốc</title>

    <!-- Google Fonts: Be Vietnam Pro, Dancing Script (chữ nghệ thuật như ảnh mẫu), Playfair Display -->
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

    <!-- Custom CSS (Tối ưu chuyên sâu cho màn hình dọc) -->
    <link rel="stylesheet" href="public/css/style.css" />
  </head>
  <body>
    <!-- =========================================================================
       NÚT LIÊN HỆ NỔI CỐ ĐỊNH (GÓC PHẢI MÀN HÌNH)
       ========================================================================= -->
    <div class="floating-contact">
      <a
        href="tel:0901234567"
        class="floating-btn btn-phone"
        title="Gọi Hotline Đặt Bàn"
      >
        <i class="bi bi-telephone-fill"></i>
      </a>
      <a
        href="tel:0901234567"
        class="floating-btn btn-chat"
        title="Gọi Điện Hỗ Trợ"
      >
        <i class="bi bi-chat-dots-fill"></i>
      </a>
    </div>

    <!-- =========================================================================
       1. HEADER / LOGO NHÀ HÀNG
       ========================================================================= -->
    <nav class="navbar custom-navbar">
      <div class="container">
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
      </div>
    </nav>

    <!-- =========================================================================
       2. HERO SECTION: LẨU KIMCHI HẢI SẢN & BÒ MỸ
       ========================================================================= -->
    <header id="hero" class="hero-section">
      <div class="container hero-container position-relative">
        <div class="row align-items-center">
          <!-- Cột trái: Tiêu đề & Thông điệp chính -->
          <div class="col-lg-6 col-xl-5 text-start hero-text-col">
            <div class="hero-subtitle mb-2">Chingu Korean Restaurant</div>
            <h1 class="hero-title">
              Lẩu Kimchi <br />
              <span class="highlight text-gold-highlight">Bò Mỹ & Hải Sản</span>
            </h1>
            <p class="hero-desc mb-4">
              Trải nghiệm ẩm thực xứ Kim Chi nguyên bản cùng nồi lẩu hải sản
              chua cay bùng nổ, bò Mỹ thượng hạng kết hợp sốt Gochujang bí
              truyền chuẩn vị Seoul.
            </p>
            <div class="d-flex gap-3 align-items-center hero-cta-group">
              <a
                href="index.php?pg=menu"
                class="btn btn-primary-custom text-uppercase"
                >Khám Phá Menu</a
              >
              <a
                href="tel:0901234567"
                class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center justify-content-center"
              >
                <i class="bi bi-telephone text-warning me-2"></i> 0901 234 567
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Đĩa món ăn dính mép dưới phải màn hình (dia.png trong public/assets) -->
      <div class="hero-dish-corner">
        <img
          src="public/assets/images/dia.png"
          onerror="this.onerror=null; this.src='public/assets/dia.png';"
          alt="Đĩa món ăn Chingu Restaurant"
          class="hero-dish-img"
        />
      </div>
    </header>

    <!-- =========================================================================
       3. SECTION 1: MÓN NỔI BẬT / ZIGZAG (NỀN ĐỎ)
       ========================================================================= -->
    <section id="dac-sac" class="section-red">
      <div class="container">
        <!-- Khối Zigzag 1: Mâm Thịt Nướng BBQ (Ảnh trên/trái - Chữ dưới/phải) -->
        <div class="row align-items-center gy-4 mb-4 mb-lg-5 pb-lg-4">
          <div class="col-lg-6">
            <div class="food-img-card shadow">
              <img
                src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80"
                alt="Mâm thịt nướng BBQ Hàn Quốc"
                class="img-fluid rounded food-img w-100"
              />
            </div>
          </div>
          <div class="col-lg-6 ps-lg-5 text-center text-lg-start">
            <span class="badge-tag">Hương Vị Seoul Bí Truyền</span>
            <h2 class="section-handwriting-title">Chingu Restaurant</h2>
            <p class="text-white opacity-90">
              Trong tiếng Hàn, "Chingu" (친구) mang ý nghĩa là những người bạn
              thân thương. Chingu Restaurant ra đời với mong muốn trở thành chốn
              sum vầy lý tưởng, nơi bạn cùng người thân thưởng thức trọn vẹn
              phong vị K-BBQ nướng than hoa xèo xèo thơm nức.
            </p>
            <p class="text-white opacity-90 mb-0">
              Từng lát thịt ba chỉ bò Mỹ cao cấp được tẩm ướp cùng sốt ủ từ hoa
              quả tươi và mật ong tự nhiên, giữ trọn độ mọng nước mềm tan khi
              nướng trên bếp than hồng.
            </p>
          </div>
        </div>

        <!-- Khối Zigzag 2: Lẩu Tokbokki Phô Mai (Ảnh trên - Chữ dưới trên màn hình dọc) -->
        <div
          class="row align-items-center gy-4 flex-column-reverse flex-lg-row"
        >
          <div class="col-lg-6 pe-lg-5 text-center text-lg-start">
            <span class="badge-tag">Món Lẩu Quốc Dân Hàn Quốc</span>
            <h2 class="section-handwriting-title">Lẩu Tokbokki Phô Mai</h2>
            <p class="text-white opacity-90">
              Hương vị bùng nổ của nồi lẩu Tokbokki ngập tràn bánh gạo dẻo dai,
              chả cá Busan thơm mềm, mì tôm ramen và xúc xích phô mai béo ngậy.
              Nước sốt sánh sệt đỏ óng ánh mang vị cay nồng chuẩn vị xứ lạnh.
            </p>
            <p class="text-white opacity-90 mb-0">
              Lớp phô mai Mozzarella kéo sợi vàng óng tan chảy phủ đều lên trên,
              tạo nên trải nghiệm ẩm thực kích thích mọi giác quan.
            </p>
          </div>
          <div class="col-lg-6">
            <div class="food-img-card shadow">
              <img
                src="https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=800&q=80"
                alt="Nồi lẩu Tokbokki phô mai kéo sợi"
                class="img-fluid rounded food-img w-100"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ĐƯỜNG RÁCH GIẤY: Chuyển từ Nền Đỏ sang Nền Đen Than -->
    <div class="torn-divider" style="background-color: var(--primary-red)">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path
          d="M0,0 L40,50 L90,10 L160,60 L230,20 L310,70 L400,20 L480,65 L570,15 L660,60 L750,25 L840,70 L920,20 L1010,60 L1100,15 L1200,60 L1200,120 L0,120 Z"
          fill="#181516"
        ></path>
      </svg>
    </div>

    <!-- =========================================================================
       4. SECTION 2: BẾP TRƯỞNG & NGHỆ THUẬT ẨM THỰC (NỀN ĐEN SẪM)
       ========================================================================= -->
    <section id="bep-truong" class="section-dark">
      <div class="container">
        <div class="row align-items-center gy-4 gy-lg-5">
          <!-- Cột trái: Tâm huyết & Ảnh phụ chế biến -->
          <div class="col-lg-6 pe-lg-5 text-center text-lg-start">
            <span class="badge-tag">Bếp Trưởng K-Food Master</span>
            <h2 class="text-white fw-bold mb-3">
              Nghệ Thuật Lên Men & Gia Vị Chuẩn Hàn
            </h2>
            <p class="text-white-50">
              "Ẩm thực Hàn Quốc là sự cân bằng tuyệt mỹ giữa âm dương ngũ hành.
              Tại Chingu Restaurant, chúng tôi kiên định nhập khẩu trực tiếp các
              loại gia vị then chốt như tương ớt Gochujang, dầu mè nguyên chất
              và kim chi lên men đủ 21 ngày để giữ trọn linh hồn ẩm thực Hàn."
            </p>
            <p class="text-gold-highlight fst-italic mb-4">
              - Park Min Woo • Bếp trưởng điều hành Chingu Restaurant
            </p>

            <!-- Ảnh phụ nhỏ bếp trưởng đang nêm nếm gia vị -->
            <div class="chef-sub-img shadow rounded overflow-hidden">
              <img
                src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=700&q=80"
                alt="Bếp trưởng chế biến gia vị"
                class="img-fluid w-100 object-fit-cover"
                style="max-height: 220px"
              />
            </div>
          </div>

          <!-- Cột phải: Chân dung Bếp Trưởng (Không có nút video) -->
          <div class="col-lg-6">
            <div class="chef-portrait-card shadow-lg rounded overflow-hidden">
              <img
                src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=800&q=80"
                alt="Chân dung Bếp Trưởng Park Min Woo"
                class="img-fluid w-100 chef-img"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ĐƯỜNG RÁCH GIẤY: Chuyển từ Nền Đen sang Nền Đỏ -->
    <div class="torn-divider" style="background-color: var(--charcoal-black)">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path
          d="M0,0 L35,45 L80,15 L140,55 L210,20 L280,60 L360,25 L430,70 L520,30 L610,65 L700,20 L790,60 L870,30 L950,75 L1040,25 L1120,60 L1200,0 L1200,120 L0,120 Z"
          fill="#b81b24"
        ></path>
      </svg>
    </div>

    <!-- =========================================================================
       5. SECTION 3: MÓN NHẬU ĐƯỜNG PHỐ POCHA & GÀ RÁN (NỀN ĐỎ)
       ========================================================================= -->
    <section id="mon-nhau" class="section-red">
      <div class="container">
        <!-- Món 1: Gà Rán Sốt Cay Yangnyeom -->
        <div class="row align-items-center gy-4 mb-4 mb-lg-5 pb-lg-4">
          <div class="col-lg-6">
            <div class="food-img-card shadow">
              <img
                src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=800&q=80"
                alt="Gà rán sốt cay ngọt Yangnyeom Hàn Quốc"
                class="img-fluid rounded food-img w-100"
              />
            </div>
          </div>
          <div class="col-lg-6 ps-lg-5 text-center text-lg-start">
            <h2 class="section-handwriting-title">Gà Rán Yangnyeom</h2>
            <p class="text-white opacity-90">
              Lớp da gà chiên giòn rụm hai lần theo công thức độc quyền, bên
              trong thịt mềm mọng đẫm nước thịt. Phủ đẫm lớp sốt đỏ chua ngọt
              cay nồng đặc trưng, thơm phức mùi tỏi ớt và mật ong.
            </p>
            <p class="text-white opacity-90 mb-0">
              Món ăn khoái khẩu kinh điển trong văn hóa "Chimaek" (Gà rán & Bia
              tươi) của giới trẻ Hàn Quốc.
            </p>
          </div>
        </div>

        <!-- Món 2: Món Nhậu Quán Lều Pocha & Soju -->
        <div
          class="row align-items-center gy-4 flex-column-reverse flex-lg-row"
        >
          <div class="col-lg-6 pe-lg-5 text-center text-lg-start">
            <h2 class="section-handwriting-title">Mồi Nhậu Chuẩn K-Pocha</h2>
            <p class="text-white opacity-90">
              Bộ sưu tập các món nhậu lai rai đậm vị cùng ly rượu Soju cay nồng:
              Bạch tuộc xào cay Nakji Bokkeum giòn sần sật, Canh chả cá Odeng
              nước dùng củ cải ngọt thanh, Chân gà rút xương sốt cay xé lưỡi...
            </p>
            <p class="text-white opacity-90 mb-0">
              Mang không khí của những quán lều Pocha ven đường phố Seoul sôi
              động và ấm áp ngay về bàn ăn của bạn.
            </p>
          </div>
          <div class="col-lg-6">
            <div class="food-img-card shadow">
              <img
                src="https://images.unsplash.com/photo-1617093727343-374698b1b08d?auto=format&fit=crop&w=800&q=80"
                alt="Món nhậu K-Pocha thơm ngon"
                class="img-fluid rounded food-img w-100"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
       6. SECTION 4: 4 GIÁ TRỊ CỐT LÕI (NỀN ĐỎ - LƯỚI 2x2 TRÊN MOBILE DỌC)
       ========================================================================= -->
    <section
      id="cam-ket"
      class="section-red pt-2 pb-5 border-top border-white border-opacity-10"
    >
      <div class="container">
        <div class="row g-2 g-md-4">
          <!-- Cột 1 -->
          <div class="col-6 col-lg-3">
            <div class="feature-item">
              <div class="feature-icon-wrapper">
                <i class="bi bi-shield-check"></i>
              </div>
              <h4 class="feature-title">Bò Mỹ Thượng Hạng</h4>
              <p class="feature-desc">
                Thịt ba chỉ, dẻ sườn nhập khẩu đạt chuẩn USDA mềm mọng.
              </p>
            </div>
          </div>

          <!-- Cột 2 -->
          <div class="col-6 col-lg-3">
            <div class="feature-item">
              <div class="feature-icon-wrapper">
                <i class="bi bi-fire"></i>
              </div>
              <h4 class="feature-title">Sốt Ướp Chuẩn Seoul</h4>
              <p class="feature-desc">
                Công thức sốt ủ hoa quả tự nhiên bí truyền thơm lừng.
              </p>
            </div>
          </div>

          <!-- Cột 3 -->
          <div class="col-6 col-lg-3">
            <div class="feature-item">
              <div class="feature-icon-wrapper">
                <i class="bi bi-patch-check"></i>
              </div>
              <h4 class="feature-title">Banchan Thả Ga</h4>
              <p class="feature-desc">
                Miễn phí 8+ món ăn kèm: kimchi chua giòn, củ cải vàng.
              </p>
            </div>
          </div>

          <!-- Cột 4 -->
          <div class="col-6 col-lg-3">
            <div class="feature-item">
              <div class="feature-icon-wrapper">
                <i class="bi bi-heart-pulse"></i>
              </div>
              <h4 class="feature-title">Nướng Tận Bàn</h4>
              <p class="feature-desc">
                Đội ngũ nhân viên thân thiện, nhiệt tình nướng chuẩn độ chín.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
       7. SECTION 5: MOSAIC GALLERY, LIÊN HỆ ĐẶT BÀN & GIỜ PHỤC VỤ
       ========================================================================= -->
    <section
      id="khong-gian"
      class="py-4 py-lg-5"
      style="background-color: #0b090a"
    >
      <div class="container">
        <div class="row g-3">
          <!-- Khối 1: Banner Đứng Bên Trái -->
          <div class="col-lg-4">
            <div class="grid-brand-tall">
              <div class="grid-brand-badge">
                <h3 class="fw-bold mb-1 fs-4">Chingu Restaurant</h3>
                <small class="text-white-50">Korean BBQ & Hotpot Dining</small>
              </div>
              <div class="my-3 rounded overflow-hidden shadow">
                <img
                  src="https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80"
                  alt="Món ăn đặc sản Chingu"
                  class="img-fluid w-100 object-fit-cover"
                  style="max-height: 280px"
                />
              </div>
              <div class="text-white-50 small">
                Cùng bạn bè nâng ly Soju nồng nàn và tận hưởng không gian K-Vibe
                sôi động.
              </div>
            </div>
          </div>

          <!-- Khối 2: Cụm Bên Phải (Ảnh tiệc lớn + Ô Liên hệ + Ô Giờ mở cửa) -->
          <div class="col-lg-8">
            <div class="row g-3">
              <!-- Hàng trên: Ảnh Không gian tiệc khách hàng sum họp -->
              <div class="col-12">
                <div
                  class="rounded overflow-hidden shadow"
                  style="max-height: 260px"
                >
                  <img
                    src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=80"
                    alt="Không gian nhà hàng ấm cúng sang trọng"
                    class="img-fluid w-100 object-fit-cover"
                    style="height: 240px"
                  />
                </div>
              </div>

              <!-- Hàng dưới Cột 1: Hộp Liên Hệ / Đặt Bàn Nền Đỏ -->
              <div class="col-md-6" id="dat-ban">
                <div class="grid-contact-box rounded shadow">
                  <i class="bi bi-telephone-outbound fs-2 mb-2"></i>
                  <h4 class="fw-bold text-uppercase mb-2 fs-5">
                    Đặt Bàn Nhận Ưu Đãi
                  </h4>
                  <p class="small mb-2 opacity-90">
                    Giảm ngay 10% khi đặt bàn trước cho nhóm từ 4 người
                  </p>
                  <div class="fs-4 fw-bold text-warning mb-3">0901 234 567</div>
                  <a
                    href="tel:0901234567"
                    class="btn btn-light text-danger fw-bold px-4 py-2 w-100"
                    >GỌI ĐẶT BÀN NGAY</a
                  >
                </div>
              </div>

              <!-- Hàng dưới Cột 2: Bảng Giờ Phục Vụ Nền Trắng -->
              <div class="col-md-6">
                <div class="grid-hours-box rounded">
                  <h4 class="fw-bold mb-3 d-flex align-items-center gap-2 fs-5">
                    <i class="bi bi-clock-history text-danger"></i> Giờ Phục Vụ
                  </h4>
                  <table class="table-hours">
                    <tbody>
                      <tr>
                        <td>Thứ Hai</td>
                        <td>10:30 - 23:00</td>
                      </tr>
                      <tr>
                        <td>Thứ Ba</td>
                        <td>10:30 - 23:00</td>
                      </tr>
                      <tr>
                        <td>Thứ Tư</td>
                        <td>10:30 - 23:00</td>
                      </tr>
                      <tr>
                        <td>Thứ Năm</td>
                        <td>10:30 - 23:00</td>
                      </tr>
                      <tr>
                        <td>Thứ Sáu</td>
                        <td>10:30 - 23:30</td>
                      </tr>
                      <tr>
                        <td>Thứ Bảy</td>
                        <td>10:30 - 24:00</td>
                      </tr>
                      <tr>
                        <td>Chủ Nhật</td>
                        <td>10:30 - 24:00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- =========================================================================
       8. FOOTER: CHÂN TRANG
       ========================================================================= -->
    <footer class="site-footer">
      <div class="container">
        <div class="row g-4">
          <!-- Cột 1: Thông tin thương hiệu Chingu -->
          <div class="col-lg-4 col-md-6">
            <div class="footer-logo">
              <a
                class="navbar-brand text-white fw-bold d-flex align-items-center gap-2"
                href="#"
              >
                <span
                  >CHINGU
                  <small class="fw-normal text-warning">RESTAURANT</small></span
                >
              </a>
            </div>
            <p class="text-white-50 mb-3">
              Hương vị thịt nướng than hoa K-BBQ và lẩu Kimchi chuẩn vị Seoul.
              Nơi gắn kết tình bạn, sum họp gia đình với ẩm thực trọn vị truyền
              thống Hàn Quốc.
            </p>
            <div
              class="d-flex gap-3 justify-content-center justify-content-lg-start"
            >
              <a href="#" class="text-white-50 fs-5"
                ><i class="bi bi-facebook"></i
              ></a>
              <a href="#" class="text-white-50 fs-5"
                ><i class="bi bi-instagram"></i
              ></a>
              <a href="#" class="text-white-50 fs-5"
                ><i class="bi bi-tiktok"></i
              ></a>
              <a href="#" class="text-white-50 fs-5"
                ><i class="bi bi-geo-alt"></i
              ></a>
            </div>
          </div>

          <!-- Cột 2: Địa chỉ & Liên hệ -->
          <div class="col-lg-4 col-md-6 text-start">
            <h5 class="footer-heading">Hệ Thống Chi Nhánh</h5>
            <ul class="footer-links">
              <li>
                <i class="bi bi-geo-alt text-warning me-2"></i> CN1: 88 Phố
                K-Town, Quận 7, TP. HCM
              </li>
              <li>
                <i class="bi bi-geo-alt text-warning me-2"></i> CN2: 126 Đường
                Trung Hòa, Cầu Giấy, Hà Nội
              </li>
              <li>
                <i class="bi bi-telephone text-warning me-2"></i> Hotline: 0901
                234 567
              </li>
              <li>
                <i class="bi bi-envelope text-warning me-2"></i>
                info@chingurestaurant.vn
              </li>
            </ul>
          </div>

          <!-- Cột 3 & 4 gộp thành 2 cột 6 trên mobile dọc -->
          <div class="col-6 col-lg-2 text-start">
            <h5 class="footer-heading">Menu K-Food</h5>
            <ul class="footer-links">
              <li><a href="index.php?pg=menu">Lẩu Kimchi</a></li>
              <li><a href="index.php?pg=menu">Thịt Nướng BBQ</a></li>
              <li><a href="index.php?pg=menu">Lẩu Tokbokki</a></li>
              <li><a href="index.php?pg=menu">Gà Rán Yangnyeom</a></li>
              <li><a href="index.php?pg=menu">Rượu Soju & Đồ Uống</a></li>
            </ul>
          </div>

          <div class="col-6 col-lg-2 text-start">
            <h5 class="footer-heading">Dịch Vụ</h5>
            <ul class="footer-links">
              <li><a href="tel:0901234567">Đặt Bàn Online</a></li>
              <li><a href="tel:0901234567">Ưu Đãi 10%</a></li>
              <li><a href="tel:0901234567">Phòng VIP K-Style</a></li>
              <li><a href="tel:0901234567">Hotline CSKH</a></li>
            </ul>
          </div>
        </div>

        <!-- Bản quyền -->
        <div class="footer-bottom text-center">
          <div>
            © 2026 Chingu Korean Restaurant. Tất cả các quyền được bảo lưu.
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="public/js/main.js"></script>
  </body>
</html>
