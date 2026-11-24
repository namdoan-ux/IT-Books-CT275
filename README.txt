IT-BOOKS – CT275 CÔNG NGHỆ WEB
PHP 8.1+ | MySQL/MariaDB | PDO | Bootstrap 5 | XAMPP
============================================================

1. CẤU TRÚC DỰ ÁN
- public/: Document Root, chứa các trang PHP được phép truy cập, CSS, JavaScript, ảnh và upload.
- app/: mã cấu hình và hàm dùng chung; nằm ngoài Document Root, không thể truy cập trực tiếp qua HTTP.
- database.sql: tạo database và dữ liệu mẫu cho cài đặt mới.
- upgrade_database.sql: bổ sung cột metadata cho database từ phiên bản cũ (chỉ chạy một lần nếu thiếu các cột này).
- bo_sung_giao_trinh.sql: thêm danh mục và giáo trình mẫu, có kiểm tra mã để tránh thêm trùng.

2. CÀI ĐẶT TRÊN XAMPP – CÁCH NHANH
1) Giải nén thư mục IT-Books vào C:\xampp\htdocs\IT-Books.
2) Mở XAMPP Control Panel, bật Apache và MySQL.
3) Mở http://localhost/phpmyadmin, tạo/import database mới bằng database.sql.
4) Truy cập website tại: http://localhost/IT-Books/public/
5) Nếu dùng database cũ: sao lưu database trước. Không import database.sql vì file này DROP và tạo lại bảng. Chỉ chạy upgrade_database.sql nếu các cột cover_image, publisher, publish_year, pages, language, isbn, file_path, updated_at chưa tồn tại.
6) Có thể chạy bo_sung_giao_trinh.sql để thêm dữ liệu giáo trình mẫu; thao tác này không thay thế dữ liệu người dùng hiện có.

Cấu hình database mặc định trong app/config.php:
DB_HOST=127.0.0.1, DB_NAME=it_books, DB_USER=root, DB_PASS=''

3. CẤU HÌNH DOCUMENT ROOT ĐÚNG CHO CT275 (KHUYẾN NGHỊ)
Đặt DocumentRoot trỏ thẳng vào thư mục public, không trỏ vào thư mục gốc IT-Books.
Ví dụ VirtualHost Apache (sửa đường dẫn nếu XAMPP cài nơi khác):

<VirtualHost *:80>
    ServerName itbooks.local
    DocumentRoot "C:/xampp/htdocs/IT-Books/public"
    <Directory "C:/xampp/htdocs/IT-Books/public">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

- Mở C:\xampp\apache\conf\extra\httpd-vhosts.conf và thêm cấu hình trên.
- Trong C:\xampp\apache\conf\httpd.conf, bảo đảm dòng Include conf/extra/httpd-vhosts.conf được bật.
- Mở Notepad bằng quyền Administrator, sửa C:\Windows\System32\drivers\etc\hosts, thêm: 127.0.0.1 itbooks.local
- Khởi động lại Apache, truy cập http://itbooks.local.
- Nếu chưa cấu hình VirtualHost, dùng đường dẫn nhanh ở mục 2.

HTTPS/HTTP2 cục bộ: có thể cấu hình SSL VirtualHost với chứng chỉ localhost do mkcert tạo; bật mod_ssl và mod_http2 trong Apache, đặt Protocols h2 http/1.1. Không bật HTTPS công khai với chứng chỉ tự ký. Hướng dẫn này là cấu hình triển khai, cần thực hiện trên máy XAMPP thực tế.

4. TÀI KHOẢN QUẢN TRỊ MẪU
Email: admin@itbooks.local
Mật khẩu: Admin@12345
Chỉ có tài khoản này khi tạo database mới bằng database.sql. Hãy đổi mật khẩu sau lần đăng nhập đầu tiên.

5. CÁC TRANG VÀ NGHIỆP VỤ
- Trang chủ: public/index.php.
- Kho giáo trình: public/books.php (tìm kiếm, lọc danh mục, sắp xếp, phân trang).
- Chi tiết giáo trình: public/book.php.
- Đăng nhập/đăng ký: public/auth.php.
- Giỏ hàng và đặt hàng: cart.php, checkout.php.
- Tài khoản, lịch sử và chi tiết đơn hàng: profile.php, orders.php, order_detail.php.
- Cộng đồng: community.php.
- Quản trị: admin.php (tổng quan, giáo trình, đơn hàng, thành viên, bài đăng).
Website có hơn 6 trang kết xuất PHP và có liên kết điều hướng giữa các trang.

6. ĐỐI CHIẾU TIÊU CHÍ CT275
- Bootstrap 5: sử dụng lưới responsive, navbar, cards, forms, tables, alerts, badges, pagination và dropdown; giao diện thích ứng màn hình nhỏ.
- PHP + PDO: truy vấn dùng Prepared Statements; các bảng users, categories, books, orders, order_items, posts có quan hệ khóa ngoại; các nghiệp vụ có đọc/thêm/sửa/ẩn dữ liệu.
- Tổ chức mã nguồn: public là Document Root; app nằm ngoài public; PHP dùng require_once cho bootstrap/hàm dùng chung. Không dùng framework hoàn chỉnh. Dự án hiện không khai báo class nên không cần autoload PSR-4; nếu bổ sung class/thư viện Composer trong báo cáo cần triển khai autoload PSR-4 tương ứng.
- XSS: nội dung xuất ra HTML đi qua htmlspecialchars thông qua hàm e().
- SQL Injection: PDO Prepared Statements và tham số giữ chỗ.
- CSRF: token session được kiểm tra trong các thao tác POST; thao tác thay đổi giỏ hàng/đăng xuất không dùng GET.
- IDOR: trang chi tiết đơn hàng giới hạn theo user_id của tài khoản đang đăng nhập; trang quản trị yêu cầu role admin.
- Chứng thực: mật khẩu lưu bằng password_hash và kiểm tra bằng password_verify; session được tái tạo khi đăng nhập.
- Upload: admin tải ảnh JPG/PNG/WEBP (tối đa 5MB) và PDF (tối đa 25MB); kiểm tra MIME bằng Fileinfo, tên tệp ngẫu nhiên; thư mục upload chặn thực thi script.
- HTTP caching: trang chi tiết giáo trình dùng ETag, Last-Modified và phản hồi 304 Not Modified; .htaccess cấu hình cache cho CSS/JS/ảnh và nén nội dung nếu module Apache được bật.
- SSE: admin_events.php gửi số lượng đơn chờ xử lý theo Server-Sent Events; dashboard admin nhận cập nhật trực tiếp bằng EventSource.
- Web server: public/.htaccess tắt directory listing, đặt security headers, cache tài nguyên tĩnh và nén nội dung. Cần kiểm tra module Apache/HTTPS/HTTP2 trên máy trình diễn.

7. CẤU HÌNH UPLOAD PHP
Nếu tải file lớn bị lỗi, mở php.ini trong XAMPP và đặt tối thiểu:
upload_max_filesize=25M
post_max_size=30M
max_execution_time=120
Sau đó khởi động lại Apache. Cần bật extension=fileinfo.

8. KIỂM THỬ VÀ GIỚI HẠN
- Gói đã được kiểm tra cú pháp PHP bằng php -l, cấu trúc thư mục và các cấu hình tĩnh.
- Môi trường đóng gói không có MySQL/PDO MySQL và không có XAMPP Windows; vì vậy chưa thể xác nhận kết nối DB, upload, SSE hoặc HTTPS trên máy của bạn. Cần chạy thử theo mục 2/3 và chụp ảnh minh chứng cho báo cáo/vấn đáp.
- Bootstrap và Font Awesome tải từ CDN, cần Internet để hiển thị đầy đủ.
- Chỉ tải lên PDF/ảnh mà bạn có quyền sử dụng và phân phối.
