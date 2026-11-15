# HỆ THỐNG ĐẶT MÓN VÀ QUẢN LÝ NHÀ HÀNG CHINGU KOREAN RESTAURANT

Chingu Korean Restaurant là hệ thống website đặt món tại bàn và quản lý vận hành nhà hàng nướng & lẩu Hàn Quốc hoàn chỉnh. Dự án được xây dựng trên nền tảng PHP thuần áp dụng mô hình kiến trúc MVC (Model - View - Controller), kết hợp hệ quản trị cơ sở dữ liệu MySQL và giao diện người dùng hiện đại tối ưu cho cả thiết bị di động (Mobile) lẫn máy tính để bàn (Desktop).

---

## 1. TỔNG QUAN DỰ ÁN

Hệ thống phục vụ hai nhóm đối tượng chính:

1. Khách hàng dùng bữa tại nhà hàng (Customer Portal):
   - Quét mã QR tại bàn để truy cập trực tiếp vào thực đơn được gắn với đúng số bàn của mình.
   - Xem danh mục món ăn, hình ảnh, giá cả, mô tả món và thêm món vào giỏ hàng thời gian thực.
   - Xác nhận đơn hàng, chọn phương thức thanh toán (Tiền mặt hoặc Chuyển khoản ngân hàng VietQR).
   - Theo dõi tiến độ chế biến và phục vụ món ăn qua 4 giai đoạn theo thời gian thực.
   - Tra cứu lịch sử đơn hàng theo mã đơn nhanh chóng với hệ thống thông báo lỗi chuẩn xác.

2. Ban quản lý và nhân viên nhà hàng (Admin & Kitchen Portal):
   - Bảng điều khiển tổng quan thống kê doanh thu, số lượng đơn hàng, trạng thái bàn và món ăn bán chạy.
   - Quản lý đơn hàng tập trung, cập nhật tiến độ đơn món (Tiếp nhận -> Vào bếp -> Ra món -> Hoàn tất / Hủy đơn).
   - Tự động đồng bộ trạng thái bàn ăn: Tự động chuyển sang "Đang phục vụ" khi có đơn mới và tự động mở lại trạng thái "Bàn trống" khi đơn hoàn tất hoặc bị hủy.
   - Quản lý bàn ăn và tự động tạo mã QR riêng biệt cho từng bàn, sẵn sàng in ấn đặt tại bàn.
   - Quản lý danh mục món và danh sách món ăn (thêm, sửa, xóa, tải lên hình ảnh, ẩn/hiện món).
   - Quản lý tài khoản nhân viên và phân quyền truy cập hệ thống.

---

## 2. CÔNG NGHỆ SỬ DỤNG (TECH STACK)

- Ngôn ngữ lập trình Back-End: PHP 8.x (không sử dụng framework ngoài, áp dụng mô hình MVC thuần).
- Kết nối cơ sở dữ liệu: PHP Data Objects (PDO) hỗ trợ bảo mật, chống lỗi SQL Injection.
- Cơ sở dữ liệu: MySQL / MariaDB (Tên cơ sở dữ liệu: `chingu-restaurant`, bảng mã `utf8mb4_unicode_ci`).
- Ngôn ngữ và thư viện Front-End:
  - HTML5 ngữ nghĩa và CSS3 tùy biến theo phong cách Dark Luxury đặc trưng của ẩm thực Hàn Quốc.
  - Bootstrap 5.3 (Grid system, Utilities, Responsive components).
  - Vanilla JavaScript ES6+ (Xử lý giỏ hàng LocalStorage, Fetch API, cập nhật DOM realtime).
  - Bootstrap Icons (Hệ thống biểu tượng vector nhẹ và đồng bộ).
- Công nghệ và API tích hợp ngoài:
  - VietQR API: Tự động tạo mã QR thanh toán ngân hàng MB Bank với đúng số tiền và nội dung đơn hàng.
  - QR Code Generator API: Sinh mã QR động cho từng số bàn để khách quét bằng camera điện thoại.

---

## 3. CẤU TRÚC THƯ MỤC DỰ ÁN

```text
WEBDA/
|-- admin/                              # Phân hệ quản trị dành cho quản lý & nhân viên
|   |-- assets/                         # Tài nguyên CSS, JS, hình ảnh dành riêng cho admin
|   |   |-- css/admin.css               # Giao diện trang quản trị
|   |   |-- js/admin.js                 # Xử lý tương tác AJAX, biểu đồ, cập nhật trạng thái
|   |-- controller/                     # Các bộ điều hướng dành riêng cho admin
|   |   |-- AuthController.php          # Đăng nhập, đăng xuất, kiểm tra quyền truy cập
|   |   |-- CategoryController.php      # Quản lý danh mục món ăn
|   |   |-- DashboardController.php     # Bảng điều khiển thống kê tổng quan
|   |   |-- OrderController.php         # Quản lý, lọc và cập nhật tiến độ đơn hàng
|   |   |-- ProductController.php       # Quản lý sản phẩm (thêm, sửa, xóa món)
|   |   |-- TableController.php         # Quản lý bàn ăn và sinh mã QR
|   |-- view/                           # Giao diện hiển thị trang quản trị
|   |   |-- auth/login.php              # Form đăng nhập hệ thống
|   |   |-- categories/                 # Giao diện danh mục
|   |   |-- dashboard/index.php         # Giao diện Dashboard thống kê
|   |   |-- layouts/                    # Khung bố cục chung (header, sidebar, footer)
|   |   |-- orders/                     # Giao diện danh sách đơn và chi tiết đơn hàng
|   |   |-- products/                   # Giao diện danh sách và form sản phẩm
|   |   |-- tables/                     # Giao diện lưới bàn ăn và quản lý mã QR
|   `-- index.php                       # Điểm vào duy nhất (Single Entry Point) của admin
|
|-- controller/                         # Bộ điều hướng phân hệ người dùng (Client)
|   |-- HomeController.php              # Xử lý trang chủ, đặt bàn và liên hệ
|   |-- MenuController.php              # Xử lý thực đơn, nhận diện bàn qua tham số URL
|   `-- OrderController.php             # Xử lý đặt món, lưu đơn, theo dõi trạng thái đơn
|
|-- model/                              # Lớp dữ liệu và thao tác Database (PDO)
|   |-- pdo.php                         # Khởi tạo kết nối PDO và các hàm truy vấn cơ sở
|   |-- Category.php                    # Truy vấn và cập nhật bảng categories
|   |-- Employee.php                    # Truy vấn và xác thực nhân viên bảng employees
|   |-- Order.php                       # Xử lý đơn hàng (orders) và chi tiết đơn (order_details)
|   |-- Product.php                     # Thao tác danh sách sản phẩm (products)
|   `-- Table.php                       # Quản lý trạng thái và thông tin bàn ăn (tables)
|
|-- public/                             # Thư mục tài nguyên tĩnh công khai
|   |-- css/style.css                   # Tập tin định kiểu toàn diện của website khách hàng
|   |-- js/main.js                      # Xử lý logic giao diện, sticky header, giỏ hàng
|   |-- assets/images/                  # Hình ảnh logo, banner, hình ảnh món ăn
|   `-- uploads/                        # Thư mục chứa hình ảnh món ăn tải lên từ admin
|
|-- view/                               # Giao diện phân hệ người dùng (Client)
|   |-- home.php                        # Trang chủ Landing Page giới thiệu nhà hàng
|   |-- menu.php                        # Trang thực đơn chọn món, giỏ hàng tại bàn
|   |-- order.php                       # Trang xác nhận đơn hàng và màn hình tạo đơn thành công
|   `-- order_status.php                # Trang theo dõi tiến độ bếp phục vụ và thanh toán VietQR
|
|-- chingu-restaurant.sql               # Tập tin sao lưu toàn bộ cấu trúc và dữ liệu cơ sở dữ liệu
|-- index.php                           # Điểm vào khởi đầu hệ thống phân hệ Client (Routing)
`-- README.md                           # Tài liệu hướng dẫn dự án
```

---

## 4. CÁC TÍNH NĂNG NỔI BẬT CỦA HỆ THỐNG

### 4.1. Quy Trình Đặt Món Thông Minh Tại Bàn (QR Ordering)
- Khách hàng quét mã QR tại bàn (ví dụ: `index.php?pg=menu&table=Bàn%2002`).
- Hệ thống tự động ghi nhận số bàn vào session và giữ nguyên ngữ cảnh bàn trong suốt hành trình đặt món.
- Kiểm tra tình trạng bàn: Nếu bàn đang ở trạng thái "Đang phục vụ", hệ thống tự động thông báo bàn hiện không khả dụng để đặt món nhằm tránh trường hợp gọi món chồng chéo.
- Giỏ hàng thời gian thực: Lưu trữ trên LocalStorage giúp khách hàng không bị mất món đã chọn khi đổi trang hoặc tải lại trang.
- Màn hình tạo đơn thành công tích hợp ngẫu nhiên mã đơn chuẩn (`#CG-XXXX`), tên khách, số bàn, danh sách món, tổng thanh toán và nút xem trạng thái.
- Cơ chế lưu Session đơn hàng: Khi khách hàng tải lại (reload) trang xác nhận đơn, hệ thống không bị chuyển hướng hay mất dữ liệu mà vẫn giữ nguyên màn hình đơn hàng vừa tạo.

### 4.2. Theo Dõi Đơn Hàng & Thanh Toán Tự Động (Real-time Tracking & VietQR)
- Thanh tiến trình 4 bước theo dõi đơn hàng thời gian thực:
  - Bước 1: Tiếp nhận đơn hàng.
  - Bước 2: Vào bếp chế biến.
  - Bước 3: Ra món / Phục vụ tại bàn.
  - Bước 4: Hoàn tất đơn hàng.
- Tích hợp VietQR: Tự động sinh mã QR động chứa đúng thông tin tài khoản ngân hàng, chính xác số tiền cần thanh toán và mã nội dung chuyển khoản theo mã đơn.
- Tự động làm mới trang mỗi 15 giây để đồng bộ tiến độ chế biến từ nhà bếp.
- Tra cứu đơn hàng: Cho phép khách hàng nhập mã đơn để kiểm tra tình trạng. Hệ thống tự động báo lỗi rõ ràng nếu nhập sai mã hoặc đơn không tồn tại, kèm viền đỏ cảnh báo và hỗ trợ chuẩn hóa mã có hoặc không có dấu thăng (#).

### 4.3. Quản Trị Hệ Thống & Tự Động Giải Phóng Bàn Ăn
- Chuyển trạng thái đơn hàng nhanh chóng, trực quan trong giao diện quản trị Admin.
- Tự động giải phóng bàn: Khi đơn hàng được quản trị viên đánh dấu là "Hoàn tất" hoặc "Hủy đơn", bàn ăn gắn liền với đơn hàng đó sẽ tự động được mở lại thành trạng thái "Bàn trống" để sẵn sàng đón lượt khách tiếp theo.
- Quản lý và in mã QR: Cho phép ban quản lý thêm bàn mới và tạo mã QR đặt món tự động cho từng bàn chỉ với một thao tác.

---

## 5. HƯỚNG DẪN CÀI ĐẶT VÀ KHỞI CHẠY DỰ ÁN

### 5.1. Yêu Cầu Hệ Thống
- Hệ điều hành: Windows 10/11, macOS hoặc Linux.
- Phần mềm máy chủ giả lập: XAMPP, WampServer hoặc Laragon hỗ trợ PHP 8.0 trở lên và MySQL 5.7+ / MariaDB 10.4+.
- Trình duyệt web hiện đại: Google Chrome, Microsoft Edge, Mozilla Firefox hoặc Safari.

### 5.2. Các Bước Thực Hiện

#### Bước 1: Sao chép mã nguồn vào máy chủ web
- Với XAMPP trên hệ điều hành Windows, sao chép toàn bộ thư mục dự án vào đường dẫn:
  `C:\xampp\htdocs\WEBDA`
  (hoặc thư mục htdocs tương ứng trên môi trường phát triển của bạn).

#### Bước 2: Khởi động dịch vụ máy chủ
- Mở bảng điều khiển XAMPP Control Panel.
- Bấm nút "Start" cho hai dịch vụ:
  - Apache (Web Server)
  - MySQL (Database Server)

#### Bước 3: Khởi tạo và nạp cơ sở dữ liệu MySQL
1. Mở trình duyệt web và truy cập vào giao diện quản lý cơ sở dữ liệu phpMyAdmin:
   `http://localhost/phpmyadmin`
2. Tạo một cơ sở dữ liệu mới:
   - Tên cơ sở dữ liệu: `chingu-restaurant`
   - Bảng mã (Collation): `utf8mb4_unicode_ci` hoặc `utf8mb4_general_ci`
   - Bấm nút "Create" (Tạo).
3. Nạp dữ liệu từ tập tin SQL:
   - Chọn cơ sở dữ liệu `chingu-restaurant` vừa tạo ở danh sách bên trái.
   - Chọn thẻ "Import" (Nhập) trên thanh công cụ.
   - Bấm nút "Choose File" (Chọn tập tin) và trỏ tới tập tin `chingu-restaurant.sql` nằm ở thư mục gốc của dự án (`WEBDA/chingu-restaurant.sql`).
   - Cuộn xuống dưới cùng và bấm nút "Import" để hoàn tất nạp cấu trúc bảng và dữ liệu khởi tạo.

#### Bước 4: Kiểm tra cấu hình kết nối cơ sở dữ liệu
Tập tin kết nối PDO đã được thiết lập sẵn tại đường dẫn `WEBDA/model/pdo.php`:
```php
function pdo_get_connection() {
    $dburl = "mysql:host=localhost;dbname=chingu-restaurant;charset=utf8mb4";
    $username = 'root';
    $password = ''; // Mật khẩu mặc định của XAMPP để trống
    ...
}
```
Nếu máy chủ MySQL của bạn có thiết lập mật khẩu riêng, vui lòng thay đổi giá trị của biến `$password` cho tương ứng.

#### Bước 5: Truy cập và sử dụng hệ thống

1. Dành cho khách hàng (Customer Site):
   - Trang chủ: `http://localhost/WEBDA/index.php` (hoặc `http://localhost:3000/index.php`)
   - Thực đơn chọn món tại bàn: `http://localhost/WEBDA/index.php?pg=menu&table=Bàn%2001`
   - Tra cứu trạng thái đơn hàng: `http://localhost/WEBDA/index.php?pg=order-status`

2. Dành cho quản trị viên và nhân viên (Admin Portal):
   - Đường dẫn đăng nhập: `http://localhost/WEBDA/admin/index.php`
   - Tài khoản quản trị viên (Admin):
     - Tên đăng nhập: `admin`
     - Mật khẩu: `123456`
   - Tài khoản nhân viên thu ngân / phục vụ (Staff):
     - Tên đăng nhập: `staff`
     - Mật khẩu: `123456`

---

## 6. DANH SÁCH CÁC TRANG VÀ ĐỊA CHỈ URL CHÍNH

| Chức Năng | Đường Dẫn URL | Mô Tả |
| :--- | :--- | :--- |
| Trang chủ | `index.php?pg=home` | Giới thiệu nhà hàng, không gian ẩm thực, set menu tiêu biểu |
| Thực đơn tổng | `index.php?pg=menu` | Danh sách toàn bộ món ăn có phân chia tab danh mục |
| Thực đơn tại bàn | `index.php?pg=menu&table=Bàn%20XX` | Thực đơn kèm số bàn phục vụ được gắn theo mã QR |
| Xác nhận đơn | `index.php?pg=order&table=Bàn%20XX` | Kiểm tra giỏ hàng, điền thông tin và xác nhận đặt món |
| Theo dõi đơn | `index.php?pg=order-status&code=CG-XXXX` | Tiến trình bếp phục vụ, mã VietQR thanh toán và chi tiết món |
| Tra cứu đơn | `index.php?pg=order-status` | Form tra cứu đơn hàng theo mã bất kỳ có kiểm tra lỗi |
| Đăng nhập Admin | `admin/index.php?act=login` | Form xác thực dành cho nhân viên và ban quản lý |
| Dashboard Admin | `admin/index.php?act=dashboard` | Thống kê doanh thu, đơn hàng, lượng khách và món bán chạy |
| Quản lý đơn hàng | `admin/index.php?act=orders` | Danh sách đơn, lọc trạng thái, cập nhật tiến độ bếp |
| Quản lý bàn & QR | `admin/index.php?act=tables` | Sơ đồ bàn, trạng thái bàn và bộ tạo mã QR động |
| Quản lý món ăn | `admin/index.php?act=products` | Danh sách món ăn, thêm mới, sửa giá, tải ảnh món |
| Quản lý danh mục | `admin/index.php?act=categories` | Quản lý nhóm món (Thịt nướng, Lẩu, Đồ uống,...) |

---

## 7. QUY ƯỚC VÀ CAM KẾT MÃ NGUỒN

- Toàn bộ mã nguồn PHP được tổ chức rõ ràng theo tiêu chuẩn kiến trúc MVC, tách biệt rành mạch giữa xử lý nghiệp vụ (Controller), truy vấn dữ liệu (Model) và hiển thị giao diện (View).
- Các câu lệnh truy vấn cơ sở dữ liệu đều thực thi thông qua phương thức Prepared Statement của PDO để phòng chống triệt để các lỗ hổng bảo mật như SQL Injection.
- Giao diện tuân thủ quy chuẩn thiết kế Dark Luxury: bảng màu ấm tương phản cao, mang đậm hơi thở ẩm thực nướng & lẩu xứ Hàn, phông chữ tiếng Việt Be Vietnam Pro sắc nét, tạo cảm giác dễ chịu và không gây mỏi mắt trong môi trường nhà hàng.
