<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Đăng Nhập Quản Trị • Chingu Korean Restaurant</title>

    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card card-login shadow-lg border-0 mt-5">
                                <div class="card-header bg-dark text-white text-center py-4 border-bottom border-secondary border-opacity-25">
                                    <h3 class="fw-bold mb-0">
                                        <span>CHINGU <small class="fw-normal text-warning">RESTAURANT</small></span>
                                    </h3>
                                    <div class="small text-white-50 mt-1">Cổng Quản Trị & Vận Hành Nhà Hàng</div>
                                </div>
                                <div class="card-body p-4">
                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger py-2 small rounded mb-3" role="alert">
                                            <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($error) ?>
                                        </div>
                                    <?php endif; ?>

                                    <form action="index.php?act=do-login" method="POST">
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control rounded-3"
                                                id="inputUsername"
                                                type="text"
                                                name="username"
                                                placeholder="Tên đăng nhập"
                                                required
                                                autofocus
                                            />
                                            <label for="inputUsername"><i class="fas fa-user text-muted me-1"></i> Tên đăng nhập / Tài khoản</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control rounded-3"
                                                id="inputPassword"
                                                type="password"
                                                name="password"
                                                placeholder="Mật khẩu"
                                                required
                                            />
                                            <label for="inputPassword"><i class="fas fa-lock text-muted me-1"></i> Mật khẩu</label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRemember" type="checkbox" checked />
                                            <label class="form-check-label text-muted small" for="inputRemember">Ghi nhớ phiên đăng nhập này</label>
                                        </div>

                                        <div class="d-grid mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary py-2 fw-bold rounded-3">
                                                <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập Quản Trị
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
