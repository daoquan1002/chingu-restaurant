# HỆ THỐNG ĐẶT MÓN VÀ QUẢN LÝ NHÀ HÀNG CHINGU KOREAN RESTAURANT

Chingu Korean Restaurant là hệ thống website đặt món tại bàn và quản lý vận hành nhà hàng nướng & lẩu Hàn Quốc hoàn chỉnh. Dự án được xây dựng trên nền tảng PHP thuần áp dụng mô hình kiến trúc MVC (Model - View - Controller), kết hợp hệ quản trị cơ sở dữ liệu MySQL và giao diện người dùng hiện đại tối ưu cho cả thiết bị di động (Mobile) lẫn máy tính để bàn (Desktop).

---

## 1. TỔNG QUAN DỰ ÁN

Hệ thống phục vụ ba nhóm đối tượng chính với quy trình vận hành khép kín:

1. Khách hàng dùng bữa tại nhà hàng (Customer Portal):
   - Quét mã QR tại bàn để truy cập trực tiếp vào thực đơn được gắn với đúng số bàn của mình.
   - Xem danh mục món ăn, hình ảnh, giá cả, mô tả món và thêm món vào giỏ hàng thời gian thực.
   - Xác nhận đơn hàng, chọn phương thức thanh toán (Tiền mặt hoặc Chuyển khoản ngân hàng VietQR).
   - Theo dõi tiến độ chế biến và phục vụ món ăn qua 4 giai đoạn theo thời gian thực.
   - Thông báo rõ ràng khi đơn bị hủy và hướng dẫn nhận lại tiền tại quầy thu ngân nếu đã thanh toán.
   - Tra cứu lịch sử đơn hàng theo mã đơn nhanh chóng với hệ thống thông báo lỗi chuẩn xác.

2. Bộ phận Bếp và Pha chế (Kitchen Portal):
   - Giao diện đơn giản hóa, tập trung riêng cho công việc chế biến món ăn.
   - Tự động chuyển thẳng vào màn hình Quản lý đơn hàng ngay khi đăng nhập.
   - Nhận diện đơn mới tức thì qua âm thanh chuông báo và huy hiệu phát sáng.
   - Cập nhật tiến độ món ăn: Vào bếp nấu (`preparing`) -> Đã phục vụ ra bàn (`served`).

3. Ban quản lý & Thu ngân nhà hàng (Admin & Staff Portal):
   - Bảng điều khiển (Dashboard) thống kê doanh thu, số lượng đơn hàng, trạng thái bàn và món ăn bán chạy.
   - Phân quyền người dùng đa cấp độ (Role-Based Access Control - RBAC) bảo mật chặt chẽ giữa Admin, Staff và Kitchen.
   - Quản lý đơn hàng tự động làm mới ngầm sau mỗi 5 giây, bảo toàn vị trí cuộn trang của người dùng.
   - Quản lý bàn ăn và tự động sinh mã QR riêng biệt cho từng bàn, sẵn sàng in ấn đặt tại bàn.
   - Tự động đồng bộ trạng thái bàn ăn: Tự động chuyển sang "Đang phục vụ" khi có đơn mới và tự động mở lại trạng thái "Bàn trống" khi đơn hoàn tất hoặc bị hủy.
   - Quản lý danh mục món và danh sách món ăn với bộ lọc tìm kiếm tức thì theo thời gian thực.
   - Tùy chỉnh thông tin thanh toán VietQR động (chọn ngân hàng, số tài khoản, tên chủ tài khoản, mã tiền tố) kèm xem trước trực quan.
   - Quản lý tài khoản nhân viên và phân quyền vai trò chi tiết.

---

## 2. CÔNG NGHỆ SỬ DỤNG (TECH STACK)

- Ngôn ngữ lập trình Back-End: PHP 8.x (áp dụng mô hình kiến trúc MVC thuần, chuẩn hướng đối tượng OOP).
- Kết nối cơ sở dữ liệu: PHP Data Objects (PDO) với Prepared Statements chống tấn công SQL Injection.
- Cơ sở dữ liệu: MySQL / MariaDB (Tên cơ sở dữ liệu: `chingu-restaurant`, bảng mã chuẩn `utf8mb4_unicode_ci`).
- Giao diện người dùng (Front-End):
  - Phân hệ khách hàng: Dark Luxury BBQ Style đặc trưng Hàn Quốc, tương thích mobile-first.
  - Phân hệ quản trị Admin: SB Admin kết hợp CSS mở rộng, tương thích đa độ phân giải màn hình.
  - Bootstrap 5.3 & Bootstrap Icons, FontAwesome 6.
  - JavaScript ES6+ hiện đại, Fetch API ngầm, Web Audio API phát âm thanh chuông báo đơn mới.
  - Thư viện Simple-DataTables hỗ trợ bảng biểu động.
- Dịch vụ tích hợp:
  - VietQR API: Tự động sinh mã QR thanh toán động cho từng hóa đơn theo cấu hình ngân hàng của nhà hàng.
  - QR Code Generator API: Tạo mã QR đặt món gắn liền với số bàn thực khách.

---

## 3. CẤU TRÚC THƯ MỤC DỰ ÁN

```text
chingu-restaurant/
|-- admin/                              # Phân hệ quản trị dành cho quản lý, thu ngân & bếp
|   |-- assets/                         # Tài nguyên CSS, JS dành riêng cho admin
|   |   |-- css/
|   |   |   |-- admin.css               # Phong cách bổ sung, huy hiệu, empty state, hiệu ứng sáng
|   |   |   `-- styles.css              # Giao diện nền tảng SB Admin
|   |   `-- js/                         # Script tương tác, khởi tạo datatables
|   |-- controller/                     # Các bộ điều hướng nghiệp vụ quản trị
|   |   |-- AuthController.php          # Đăng nhập, đăng xuất, phân luồng điều hướng theo vai trò
|   |   |-- CategoryController.php      # Quản lý danh mục thực đơn
|   |   |-- DashboardController.php     # Bảng điều khiển thống kê tổng quan
|   |   |-- OrderController.php         # Quản lý, duyệt đơn, làm mới ngầm, thanh toán & xóa đơn
|   |   |-- ProductController.php       # Quản lý món ăn, tìm kiếm tức thì theo từ khóa
|   |   |-- TableController.php         # Quản lý bàn ăn, mở/khóa bàn và in thẻ QR
|   |   |-- UserController.php          # Quản lý tài khoản nhân viên & cập nhật phân quyền
|   |   `-- VietqrController.php        # Cấu hình tài khoản ngân hàng thụ hưởng VietQR
|   |-- view/                           # Giao diện hiển thị các phân trang admin
|   |   |-- auth/login.php              # Màn hình đăng nhập hệ thống quản trị
|   |   |-- categories/                 # Thêm, sửa, danh sách danh mục món
|   |   |-- dashboard/index.php         # Thống kê doanh thu, đơn hàng, trạng thái bàn
|   |   |-- layouts/                    # Khung sườn chung (header, sidebar RBAC, footer)
|   |   |-- orders/                     # Danh sách đơn tự động cập nhật & chi tiết đơn
|   |   |-- products/                   # Danh sách món ăn với bộ lọc thời gian thực
|   |   |-- tables/                     # Sơ đồ bàn ăn và giao diện in ấn mã QR
|   |   |-- users/                      # Quản lý tài khoản nhân viên & ma trận phân quyền
|   |   `-- vietqr/index.php            # Tùy chỉnh thông tin tài khoản ngân hàng VietQR
|   `-- index.php                       # Điểm vào phân hệ quản trị (Kiểm soát quyền truy cập RBAC)
|
|-- config/
|   `-- vietqr.json                     # Tập tin lưu trữ cấu hình ngân hàng thanh toán VietQR
|
|-- controller/                         # Bộ điều hướng phân hệ khách hàng (Client)
|   |-- HomeController.php              # Xử lý trang chủ giới thiệu nhà hàng
|   |-- MenuController.php              # Xử lý thực đơn, nhận diện bàn qua URL
|   `-- OrderController.php             # Xử lý đặt món, thanh toán và theo dõi tiến trình
|
|-- model/                              # Lớp dữ liệu và kết nối cơ sở dữ liệu PDO
|   |-- pdo.php                         # Khởi tạo kết nối PDO an toàn
|   |-- Category.php                    # Thao tác bảng categories
|   |-- Employee.php                    # Thao tác bảng employees (nhân sự, xác thực, vai trò)
|   |-- Order.php                       # Thao tác bảng orders và order_details
|   |-- Product.php                     # Thao tác bảng products
|   `-- Table.php                       # Thao tác bảng tables
|
|-- public/                             # Tài nguyên tĩnh phục vụ khách hàng
|   |-- css/style.css                   # Định kiểu giao diện khách hàng Dark Luxury
|   |-- js/main.js                      # Giỏ hàng LocalStorage, hiệu ứng thanh điều hướng
|   |-- assets/images/                  # Logo, banner, ảnh món ăn
|   `-- uploads/                        # Thư mục lưu trữ hình ảnh tải lên từ admin
|
|-- view/                               # Giao diện phân hệ người dùng (Client)
|   |-- home.php                        # Trang chủ Landing Page nhà hàng Chingu
|   |-- menu.php                        # Thực đơn gọi món tại bàn
|   |-- order.php                       # Xác nhận đơn hàng và màn hình tạo đơn thành công
|   `-- order_status.php                # Theo dõi trạng thái đơn hàng và thanh toán VietQR
|
|-- chingu-restaurant.sql               # Sao lưu toàn bộ cấu trúc bảng và dữ liệu mẫu mới nhất
|-- index.php                           # Điểm vào ứng dụng phân hệ người dùng
`-- README.md                           # Tài liệu hướng dẫn cài đặt và sử dụng
```

---

## 4. CHI TIẾT CÁC TÍNH NĂNG VẬN HÀNH

### 4.1. Phân Quyền Vai Trò Người Dùng (RBAC Matrix)

Hệ thống thiết lập 3 cấp độ phân quyền nghiêm ngặt với bộ lọc kiểm soát ngay tại điểm vào trung tâm:

| Chức Năng / Module | Quản Trị Viên (Admin) | Thu Ngân & Phục Vụ (Staff) | Bộ Phận Bếp (Kitchen) |
| :--- | :---: | :---: | :---: |
| Xem Báo Cáo Doanh Thu & Dashboard | Cho phép | Cho phép | Bị chặn |
| Tiếp Nhận & Cập Nhật Nấu / Phục Vụ Đơn | Cho phép | Cho phép | Cho phép |
| Xác Nhận Thu Tiền & Hoàn Tất Đơn | Cho phép | Cho phép | Bị chặn |
| Xóa Vĩnh Viễn Đơn Hàng | Cho phép | Bị chặn | Bị chặn |
| Quản Lý Bàn Ăn, Mã QR & Mở Khóa Bàn | Cho phép | Cho phép | Bị chặn |
| Thêm, Sửa, Xóa Món Ăn & Thực Đơn | Cho phép | Bị chặn | Bị chặn |
| Cấu Hình Tài Khoản Ngân Hàng VietQR | Cho phép | Bị chặn | Bị chặn |
| Quản Lý Tài Khoản & Phân Quyền | Cho phép | Bị chặn | Bị chặn |

Sidebar trong phân hệ quản trị tự động ẩn/hiện các đề mục dựa trên vai trò của tài khoản đang đăng nhập, ngăn ngừa tuyệt đối việc truy cập trái phép.

### 4.2. Tự Động Làm Mới Bảng Đơn Hàng Thời Gian Thực (Không Giật Trang)

- Cơ chế gọi dữ liệu nền qua Fetch API ngầm định kỳ mỗi 5 giây.
- Lưu trữ chính xác tọa độ cuộn của trình duyệt (`window.scrollY`, `window.scrollX`) và khôi phục ngay tức thời sau khi cập nhật nội dung bảng, không làm mất vị trí đang theo dõi của nhân viên.
- Nhận diện đơn mới xuất hiện so với bộ nhớ phiên (`sessionStorage`): Tự động phát hiệu ứng viền vàng sáng (`table-row-new-order`), nhãn báo động nhấp nháy `MỚI` và phát chuông âm thanh nhẹ nhàng qua Web Audio API.
- Hỗ trợ công cụ điều khiển: Nút Tạm dừng / Tiếp tục đếm ngược và nút Làm mới ngay lập tức.

### 4.3. Quản Lý Thực Đơn & Tìm Kiếm Tức Thì

- Thanh tìm kiếm lớn cho phép nhập tên món ăn tiếng Việt hoặc tiếng Hàn, kết quả bảng dữ liệu được lọc tức thì theo từng ký tự mà không cần tải lại trang.
- Tích hợp bộ lọc phân loại theo danh mục món ăn.
- Quản lý trạng thái món: Đang bán / Hết hàng hoặc tạm ẩn.

### 4.4. Cấu Hình Thanh Toán VietQR Động

- Trang quản trị cho phép lựa chọn ngân hàng từ danh sách các ngân hàng phổ biến (MBBank, Vietcombank, Techcombank, BIDV, VietinBank, TPBank, ACB, VPBank,...).
- Thiết lập số tài khoản, tên chủ tài khoản và tiền tố nội dung chuyển khoản.
- Giao diện xem trước trực tiếp (Live Preview) mã QR được cập nhật tức thì theo từng thay đổi cấu hình.
- Đồng bộ tự động với trang thanh toán của khách hàng (`order_status.php`).

### 4.5. Chuẩn Hóa Trạng Thái Bảng Rỗng (Empty State)

- Toàn bộ các bảng dữ liệu trong hệ thống (Đơn hàng, Món ăn, Danh mục, Bàn ăn, Tài khoản, Phân quyền, Bảng điều khiển) đều được đồng bộ giao diện khi chưa có dữ liệu.
- Thiết kế căn giữa hoàn hảo với biểu tượng vector mờ tinh tế, tiêu đề thông báo nổi bật và thông tin hướng dẫn thao tác thân thiện.

---

## 5. HƯỚNG DẪN CÀI ĐẶT VÀ KHỞI CHẠY DỰ ÁN

### 5.1. Yêu Cầu Môi Trường

- Máy chủ web giả lập: XAMPP, WampServer hoặc Laragon.
- Phiên bản PHP: PHP 8.0 trở lên (khuyến nghị PHP 8.1 / 8.2).
- Cơ sở dữ liệu: MySQL 5.7+ hoặc MariaDB 10.4+.
- Trình duyệt: Chrome, Edge, Firefox, Safari.

### 5.2. Các Bước Cài Đặt Chi Tiết

#### Bước 1: Đặt mã nguồn vào máy chủ web

Sao chép toàn bộ thư mục dự án vào thư mục gốc của máy chủ web:
- Đối với XAMPP trên Windows: `C:\xampp\htdocs\chingu-restaurant`

#### Bước 2: Khởi động dịch vụ

Mở XAMPP Control Panel và kích hoạt hai dịch vụ:
- Apache (Cổng 80 / 443 hoặc cấu hình tùy chỉnh)
- MySQL (Cổng 3306)

#### Bước 3: Nạp cơ sở dữ liệu

1. Truy cập phpMyAdmin tại địa chỉ: `http://localhost/phpmyadmin`
2. Tạo mới một cơ sở dữ liệu có tên: `chingu-restaurant` với bảng mã (Collation): `utf8mb4_unicode_ci`.
3. Chọn cơ sở dữ liệu `chingu-restaurant`, bấm vào thẻ "Import" (Nhập).
4. Chọn tập tin `chingu-restaurant.sql` nằm ở thư mục gốc của dự án và bấm "Import".

#### Bước 4: Kiểm tra cấu hình kết nối Database

Tập tin kết nối được lưu tại `model/pdo.php`:

```php
function pdo_get_connection() {
    $dburl = "mysql:host=localhost;dbname=chingu-restaurant;charset=utf8mb4";
    $username = 'root';
    $password = ''; // Mặc định trên XAMPP để trống
    ...
}
```

Nếu MySQL trên máy tính của bạn sử dụng mật khẩu hoặc cổng khác, vui lòng điều chỉnh các biến trên cho phù hợp.

---

## 6. THÔNG TIN ĐĂNG NHẬP HỆ THỐNG MẪU

| Vai Trò | Tên Đăng Nhập | Mật Khẩu | Quyền Hạn Chính |
| :--- | :--- | :--- | :--- |
| **Quản Trị Viên (Admin)** | `admin` | `123456` | Toàn quyền kiểm soát, cấu hình VietQR, thực đơn, phân quyền & xóa đơn |
| **Thu Ngân (Staff)** | `staff` | `123456` | Bảng điều khiển, quản lý bàn ăn, in QR, duyệt đơn & thu ngân thanh toán |
| **Bếp Nấu (Kitchen)** | `kitchen` | `123456` | Giao diện tinh gọn, tiếp nhận đơn, cập nhật trạng thái nấu & phục vụ |

---

## 7. DANH MỤC CÁC ĐƯỜNG DẪN URL QUAN TRỌNG

### Phân hệ Khách hàng (Customer Site):
- Trang chủ giới thiệu: `index.php?pg=home`
- Thực đơn chọn món tại bàn: `index.php?pg=menu&table=Bàn%2001`
- Xác nhận đơn & gửi món: `index.php?pg=order&table=Bàn%2001`
- Theo dõi đơn & mã QR thanh toán: `index.php?pg=order-status&code=CG-XXXX`
- Tra cứu đơn hàng theo mã: `index.php?pg=order-status`

### Phân hệ Quản trị (Admin Portal):
- Đăng nhập hệ thống: `admin/index.php?act=login`
- Bảng điều khiển (Dashboard): `admin/index.php?act=dashboard`
- Quản lý đơn hàng: `admin/index.php?act=orders`
- Chi tiết đơn hàng: `admin/index.php?act=order-detail&id=X`
- Quản lý bàn ăn & mã QR: `admin/index.php?act=tables`
- Danh sách món ăn: `admin/index.php?act=products`
- Danh mục thực đơn: `admin/index.php?act=categories`
- Cấu hình thanh toán VietQR: `admin/index.php?act=vietqr`
- Quản lý tài khoản nhân viên: `admin/index.php?act=users`
- Ma trận & Cập nhật phân quyền: `admin/index.php?act=roles`
- Đăng xuất an toàn: `admin/index.php?act=logout`

---

## 8. CAM KẾT CHẤT LƯỢNG MÃ NGUỒN

- Kiến trúc MVC thuần: Tách biệt rõ ràng giữa Controller xử lý logic, Model tương tác cơ sở dữ liệu và View giao diện người dùng.
- Bảo mật: Sử dụng Prepared Statements qua PDO ngăn chặn SQL Injection; phân quyền nhiều lớp bảo vệ toàn bộ các endpoint; mã hóa mật khẩu an toàn với thuật toán `password_hash()`.
- Trải nghiệm người dùng: Đồng bộ giao diện Dark Luxury Hàn Quốc, hỗ trợ hiển thị tối ưu trên thiết bị di động, thao tác thời gian thực không làm gián đoạn người dùng.
