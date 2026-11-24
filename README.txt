IT-BOOKS – (PHP + MYSQL + XAMPP)
=======================================================

1. YÊU CẦU
- XAMPP có Apache, MySQL/MariaDB và PHP 8.1 trở lên.
- Bật Apache và MySQL trong XAMPP Control Panel.

2. CÀI ĐẶT MỚI
- Giải nén thư mục IT-Books vào C:\xampp\htdocs\IT-Books
- Mở http://localhost/phpmyadmin
- Import file database.sql (chỉ dùng khi tạo database mới hoàn toàn).
- Kiểm tra config.php: DB_HOST=127.0.0.1, DB_NAME=it_books, DB_USER=root, DB_PASS=''
- Truy cập http://localhost/IT-Books/

3. NẾU ĐANG DÙNG DATABASE IT_BOOKS TỪ BẢN TRƯỚC (QUAN TRỌNG)
- Sao lưu database it_books trong phpMyAdmin trước.
- KHÔNG import lại database.sql vì file này tạo lại bảng và có thể xóa dữ liệu cũ.
- Chỉ import file upgrade_database.sql một lần để bổ sung các cột ảnh bìa, nhà xuất bản, năm xuất bản, số trang, ngôn ngữ, ISBN và đường dẫn PDF.
- Nếu trước đây chưa thêm kho giáo trình mở rộng, có thể import bo_sung_giao_trinh.sql. File này thêm theo mã sách, tránh chèn trùng mã đã có.

4. TÀI KHOẢN QUẢN TRỊ MẶC ĐỊNH (chỉ khi database được tạo từ database.sql)
Email: admin@itbooks.local
Mật khẩu: Admin@12345
Đăng nhập tại http://localhost/IT-Books/auth.php. Tài khoản role=admin sẽ được chuyển đến admin.php.

5. CHỨC NĂNG
- Trang chủ (index.php) được thiết kế riêng như trang giới thiệu IT-Books, có banner, thống kê, danh mục, giáo trình mới và liên kết khám phá.
- Kho giáo trình (books.php) là trang riêng, có tìm kiếm theo tên/mã/tác giả/nhà xuất bản, lọc danh mục, sắp xếp và phân trang (12 giáo trình/trang).
- Thẻ giáo trình trong kho hiển thị ảnh bìa, tên, mã học phần, tác giả, nhà xuất bản, năm xuất bản và giá.
- Trang chi tiết có mô tả và bảng thông tin xuất bản, ISBN, số trang, ngôn ngữ, file PDF.
- Admin thêm/sửa giáo trình, tải ảnh bìa JPG/PNG/WEBP (tối đa 5MB), tải tài liệu PDF (tối đa 25MB), quản lý đơn hàng, thành viên và cộng đồng.
- Giao diện chung được làm mới theo phong cách cửa hàng trực tuyến: thanh thông tin, điều hướng rõ ràng, nút giỏ hàng, menu tài khoản, footer nhiều cột và bố cục responsive cho điện thoại.
- Giỏ hàng, đặt hàng, lịch sử đơn hàng và cộng đồng theo các chức năng của bản nền.
- Tệp tải lên được lưu trong uploads; PHP bị chặn thực thi trong thư mục uploads.

6. LƯU Ý
- Ảnh bìa mặc định là ảnh minh họa cục bộ. Muốn dùng bìa sách thực tế, quản trị viên tải ảnh đúng cuốn sách lên trong trang Admin.
- Chỉ tải lên tài liệu mà bạn có quyền phân phối. Chức năng tải PDF là lưu trữ/hiển thị tệp do quản trị viên cung cấp, không tự tìm sách trên Internet.
- Bootstrap, Font Awesome và Google Fonts sử dụng CDN nên cần Internet để hiển thị đầy đủ. Nội dung PHP/MySQL vẫn chạy cục bộ.
- Môi trường tạo gói không có XAMPP/MySQL của máy bạn, vì vậy đã kiểm tra cú pháp PHP và cấu trúc gói, chưa thể xác nhận kiểm thử runtime trên chính máy Windows của bạn.
