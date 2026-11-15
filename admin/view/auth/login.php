<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Nhập Quản Trị • Chingu BBQ</title>

  <!-- Google Fonts: Be Vietnam Pro, Dancing Script, Playfair Display -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Dancing+Script:wght@600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/admin.css">

  <style>
    body {
      background: radial-gradient(circle at 50% 30%, #3d070b 0%, #170507 50%, #0d0304 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-box {
      width: 100%;
      max-width: 440px;
      background: #1a1718;
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 18px;
      padding: 35px 30px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
    }
    .brand-logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: #fff;
    }
  </style>
</head>
<body>

  <div class="login-box text-center">
    <div class="mb-3">
      <div class="brand-logo">
        <span>CHINGU <small class="fw-normal text-warning">RESTAURANT</small></span>
      </div>
      <p class="text-white-50 small mt-1">Hệ Thống Quản Lý Đặt Món & Bếp Nhà Hàng</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2 small rounded-3 mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="index.php?act=do-login" method="POST" class="text-start">
      <div class="mb-3">
        <label for="username" class="form-label text-white-50 small mb-1">Tên đăng nhập / Tài khoản</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-secondary text-white-50 border-opacity-50">
            <i class="bi bi-person-fill"></i>
          </span>
          <input
            type="text"
            class="form-control admin-input"
            id="username"
            name="username"
            placeholder="admin hoặc staff"
            required
            autofocus
          />
        </div>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label text-white-50 small mb-1">Mật khẩu</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-secondary text-white-50 border-opacity-50">
            <i class="bi bi-lock-fill"></i>
          </span>
          <input
            type="password"
            class="form-control admin-input"
            id="password"
            name="password"
            placeholder="Mật khẩu mặc định: 123456"
            required
          />
        </div>
      </div>

      <button type="submit" class="btn btn-danger w-100 py-2 rounded-pill fw-bold" style="background: linear-gradient(135deg, #b81b24, #94131b);">
        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng Nhập Hệ Thống
      </button>

      <div class="mt-4 p-2 rounded-3 text-center small text-white-50" style="background: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.1);">
        <div><strong>Tài khoản mẫu:</strong> admin / 123456 (Quản trị viên)</div>
        <div>hoặc: staff / 123456 (Nhân viên thu ngân)</div>
      </div>

      <div class="text-center mt-3">
        <a href="../index.php" class="text-white-50 small text-decoration-none">
          <i class="bi bi-arrow-left"></i> Quay lại trang chủ khách hàng
        </a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
