/**
 * Main JavaScript cho Chingu Korean Restaurant
 */

document.addEventListener('DOMContentLoaded', function () {
  const navbar = document.querySelector('.custom-navbar');
  const filterNav = document.querySelector('.menu-nav-wrapper');
  const ctaBanner = document.getElementById('menuCtaBanner') || document.querySelector('.menu-cta-banner');

  // 1. Đồng bộ Navbar và Thanh Filter (Khoảng cách về chính xác 0px & Xử lý cuộn tới Banner CTA)
  function updateNavbarAndFilter() {
    if (!navbar) return;

    // Lấy chiều cao thực tế chính xác của navbar
    const navHeight = navbar.offsetHeight;
    document.documentElement.style.setProperty('--current-navbar-height', navHeight + 'px');

    if (filterNav) {
      // 1. Khoảng cách giữa mép đáy Navbar và mép đỉnh Filter Nav bằng chính xác 0px
      filterNav.style.top = navHeight + 'px';

      // 2. Khi cuộn tới banner kêu gọi đặt bàn: Thanh filter không còn dính vào navbar mà bị cuộn đi
      if (ctaBanner) {
        const bannerRect = ctaBanner.getBoundingClientRect();
        const filterHeight = filterNav.offsetHeight;
        
        // Lấy margin-top của banner để điểm tiếp xúc bắt đầu tự nhiên ngay khi kết thúc danh mục món
        const bannerStyle = window.getComputedStyle(ctaBanner);
        const bannerMarginTop = parseFloat(bannerStyle.marginTop) || 0;
        
        // Vị trí mép trên thực tế của banner (tính từ khoảng đệm trên của banner)
        const bannerEffectiveTop = bannerRect.top - bannerMarginTop;
        // Điểm dính của filter (ngay dưới navbar: navHeight + filterHeight)
        const stickyBottom = navHeight + filterHeight;

        if (bannerEffectiveTop < stickyBottom) {
          // Banner đã chạm đáy thanh filter: đẩy filter trôi lên trên theo cuộn trang (không còn dính vào navbar)
          const pushUp = stickyBottom - bannerEffectiveTop;
          filterNav.style.transform = `translateY(-${pushUp}px)`;
          filterNav.classList.add('filter-scrolled-away');

          // Nếu đã cuộn vượt qua hoàn toàn phạm vi filter, ẩn đi để tối ưu render
          if (pushUp >= filterHeight + navHeight + 30) {
            filterNav.style.visibility = 'hidden';
          } else {
            filterNav.style.visibility = 'visible';
          }
        } else {
          // Khi ở vùng thực đơn: bám dính chắc chắn sát mép đáy navbar (khoảng cách = 0px)
          filterNav.style.transform = 'translateY(0)';
          filterNav.style.visibility = 'visible';
          filterNav.classList.remove('filter-scrolled-away');
        }
      }
    }
  }

  // Cho phép các trang hoặc sự kiện khác gọi lại hàm đồng bộ
  window.updateNavbarAndFilter = updateNavbarAndFilter;

  // 2. Hiệu ứng đổi kiểu Navbar khi cuộn trang
  function handleNavbarScroll() {
    if (navbar) {
      if (window.scrollY > 20) {
        navbar.classList.add('navbar-scrolled');
      } else {
        navbar.classList.remove('navbar-scrolled');
      }
    }
    updateNavbarAndFilter();
  }

  window.addEventListener('scroll', handleNavbarScroll, { passive: true });
  window.addEventListener('resize', updateNavbarAndFilter);
  window.addEventListener('orientationchange', updateNavbarAndFilter);

  // Khởi tạo ngay khi DOM sẵn sàng và dự phòng sau khi font/ảnh render
  handleNavbarScroll();
  setTimeout(updateNavbarAndFilter, 100);
  setTimeout(updateNavbarAndFilter, 300);

  // 3. Tự động đóng navbar trên Mobile khi click vào một liên kết menu
  const navLinks = document.querySelectorAll('.custom-navbar .nav-link');
  const navCollapse = document.getElementById('mainNavbar');
  if (navCollapse) {
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
        if (bsCollapse) {
          bsCollapse.hide();
        }
      });
    });

    // Cập nhật lại vị trí filter khi menu collapse đóng/mở
    navCollapse.addEventListener('hidden.bs.collapse', updateNavbarAndFilter);
    navCollapse.addEventListener('shown.bs.collapse', updateNavbarAndFilter);
  }
});
