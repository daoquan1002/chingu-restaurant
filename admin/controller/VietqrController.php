<?php

class VietqrController {
    private $configFile;

    public function __construct() {
        $this->configFile = __DIR__ . '/../../config/vietqr.json';
    }

    /**
     * Lấy cấu hình VietQR hiện tại
     */
    private function getConfig() {
        $defaultConfig = [
            'bank_id' => 'MB',
            'bank_name' => 'MBBank - Ngân hàng Quân Đội',
            'account_no' => '0987654321',
            'account_name' => 'CHINGU RESTAURANT',
            'template' => 'compact2',
            'prefix' => 'CG'
        ];

        if (file_exists($this->configFile)) {
            $data = json_decode(file_get_contents($this->configFile), true);
            if (is_array($data)) {
                return array_merge($defaultConfig, $data);
            }
        }
        return $defaultConfig;
    }

    /**
     * Danh sách các ngân hàng phổ biến được hỗ trợ bởi VietQR
     */
    public static function getSupportedBanks() {
        return [
            ['id' => 'MB', 'name' => 'MBBank - Ngân hàng Quân Đội', 'short' => 'MB'],
            ['id' => 'VCB', 'name' => 'Vietcombank - Ngân hàng Ngoại Thương', 'short' => 'VCB'],
            ['id' => 'TCB', 'name' => 'Techcombank - Ngân hàng Kỹ Thương', 'short' => 'TCB'],
            ['id' => 'ICB', 'name' => 'VietinBank - Ngân hàng Công Thương', 'short' => 'ICB'],
            ['id' => 'BIDV', 'name' => 'BIDV - Ngân hàng Đầu Tư và Phát Triển', 'short' => 'BIDV'],
            ['id' => 'ACB', 'name' => 'ACB - Ngân hàng Á Châu', 'short' => 'ACB'],
            ['id' => 'VPB', 'name' => 'VPBank - Ngân hàng Việt Nam Thịnh Vượng', 'short' => 'VPB'],
            ['id' => 'TPB', 'name' => 'TPBank - Ngân hàng Tiên Phong', 'short' => 'TPB'],
            ['id' => 'STB', 'name' => 'Sacombank - Ngân hàng Sài Gòn Thương Tín', 'short' => 'STB'],
            ['id' => 'VIB', 'name' => 'VIB - Ngân hàng Quốc Tế', 'short' => 'VIB'],
            ['id' => 'SHB', 'name' => 'SHB - Ngân hàng Sài Gòn - Hà Nội', 'short' => 'SHB'],
            ['id' => 'HDB', 'name' => 'HDBank - Ngân hàng Phát Triển TP.HCM', 'short' => 'HDB'],
            ['id' => 'OCB', 'name' => 'OCB - Ngân hàng Phương Đông', 'short' => 'OCB'],
            ['id' => 'MSB', 'name' => 'MSB - Ngân hàng Hàng Hải', 'short' => 'MSB'],
            ['id' => 'SEAB', 'name' => 'SeABank - Ngân hàng Đông Nam Á', 'short' => 'SEAB'],
            ['id' => 'LPB', 'name' => 'LPBank - Ngân hàng Lộc Phát', 'short' => 'LPB']
        ];
    }

    /**
     * Trang xem và chỉnh sửa cấu hình VietQR
     */
    public function index() {
        $config = $this->getConfig();
        $banks = self::getSupportedBanks();
        $msg = $_SESSION['admin_msg'] ?? '';
        $error = $_SESSION['admin_error'] ?? '';
        unset($_SESSION['admin_msg'], $_SESSION['admin_error']);

        include_once __DIR__ . '/../view/vietqr/index.php';
    }

    /**
     * Cập nhật thông tin tài khoản ngân hàng & VietQR
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bankId = trim($_POST['bank_id'] ?? 'MB');
            $accountNo = trim($_POST['account_no'] ?? '');
            $accountName = strtoupper(trim($_POST['account_name'] ?? ''));
            $template = trim($_POST['template'] ?? 'compact2');
            $prefix = strtoupper(trim($_POST['prefix'] ?? 'CG'));

            if (empty($accountNo) || empty($accountName)) {
                $_SESSION['admin_error'] = 'Số tài khoản và Tên chủ tài khoản không được để trống!';
            } else {
                // Tìm tên đầy đủ của ngân hàng
                $banks = self::getSupportedBanks();
                $bankName = 'Ngân hàng ' . $bankId;
                foreach ($banks as $b) {
                    if ($b['id'] === $bankId) {
                        $bankName = $b['name'];
                        break;
                    }
                }

                $newConfig = [
                    'bank_id' => $bankId,
                    'bank_name' => $bankName,
                    'account_no' => $accountNo,
                    'account_name' => $accountName,
                    'template' => $template,
                    'prefix' => $prefix
                ];

                $dir = dirname($this->configFile);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                file_put_contents($this->configFile, json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $_SESSION['admin_msg'] = 'Đã cập nhật cấu hình tài khoản VietQR thành công!';
            }
        }
        header('Location: index.php?act=vietqr');
        exit;
    }
}
?>