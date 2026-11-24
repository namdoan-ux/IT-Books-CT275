# Đưa IT-Books lên GitHub (yêu cầu CT275)

1. Tạo repository mới trên GitHub, ví dụ `IT-Books`. Không chọn tạo README/.gitignore vì dự án đã có sẵn.
2. Mở Terminal tại thư mục gốc `IT-Books` (cùng cấp `README.txt`, `app/`, `public/`).
3. ZIP giữ lại lịch sử Git cục bộ. Chạy:

```bash
git remote add origin https://github.com/<ten-tai-khoan>/IT-Books.git
git branch -M main
git push -u origin main
```

4. Nếu remote `origin` đã tồn tại, chạy `git remote set-url origin https://github.com/<ten-tai-khoan>/IT-Books.git` rồi `git push -u origin main`.
5. Sau mỗi lần sửa mã nguồn:

```bash
git add .
git commit -m "Mo ta noi dung thay doi"
git push
```

Không commit mật khẩu database thật, PDF có bản quyền, ảnh cá nhân hoặc dữ liệu khách hàng. `public/uploads/` được loại khỏi Git để không đẩy tệp người dùng lên repository.
