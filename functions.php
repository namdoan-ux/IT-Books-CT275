<?php
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'); }
function redirect(string $url): never { header('Location: '.$url); exit; }
function flash(string $type,string $message): void { $_SESSION['flash']=['type'=>$type,'message'=>$message]; }
function csrf_token(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf_check(): void { if($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf']??'', $_POST['csrf']??'')){ http_response_code(403); exit('Yêu cầu không hợp lệ (CSRF).'); } }
function user(): ?array { return $_SESSION['user']??null; }
function require_login(): void { if(!user()){ flash('warning','Vui lòng đăng nhập để tiếp tục.'); redirect('auth.php'); } }
function require_admin(): void { require_login(); if((user()['role']??'')!=='admin'){ http_response_code(403); exit('Bạn không có quyền truy cập khu vực quản trị.'); } }
function money($n): string { return number_format((float)$n,0,',','.').'đ'; }
function header_html(string $title='IT-Books'): void {
 $u=user(); $count=array_sum(array_column($_SESSION['cart']??[],'quantity'));
 echo '<!doctype html><html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#102747"><meta name="description" content="IT-Books - Kho giáo trình Công nghệ thông tin. Tra cứu, khám phá và đặt mua tài liệu học tập."><title>'.e($title).' | IT-Books</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"><link href="style.css" rel="stylesheet"></head><body>';
 echo '<div class="topline"><div class="container d-flex justify-content-between align-items-center"><span><i class="fa-solid fa-graduation-cap me-2"></i>Không gian học tập dành cho sinh viên CNTT</span><span class="d-none d-md-inline"><i class="fa-solid fa-shield-halved me-2"></i>Tra cứu tài liệu nhanh chóng, tiện lợi</span></div></div>';
 echo '<nav class="navbar navbar-expand-lg navbar-dark site-nav sticky-top"><div class="container"><a class="navbar-brand fw-bold fs-3" href="index.php"><span class="brand-mark"><i class="fa-solid fa-book-open"></i></span> IT-<span>Books</span></a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Mở menu"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav me-auto ms-lg-4"><li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li><li class="nav-item"><a class="nav-link" href="books.php">Kho giáo trình</a></li><li class="nav-item"><a class="nav-link" href="community.php">Cộng đồng</a></li>'.($u&&$u['role']==='admin'?'<li class="nav-item"><a class="nav-link" href="admin.php">Quản trị</a></li>':'').'</ul><div class="nav-actions d-flex gap-2 align-items-center"><a class="btn btn-cart btn-sm" href="cart.php"><i class="fa-solid fa-bag-shopping me-1"></i><span class="d-none d-sm-inline">Giỏ hàng</span> <span class="cart-count">'.$count.'</span></a>';
 if($u){ echo '<div class="dropdown"><button class="btn btn-nav-user btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="fa-regular fa-user me-1"></i>'.e($u['name']).'</button><ul class="dropdown-menu dropdown-menu-end shadow border-0"><li><a class="dropdown-item" href="profile.php"><i class="fa-regular fa-id-card me-2 text-primary"></i>Tài khoản</a></li><li><a class="dropdown-item" href="orders.php"><i class="fa-solid fa-box me-2 text-primary"></i>Đơn hàng</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Đăng xuất</a></li></ul></div>'; } else echo '<a class="btn btn-nav-login btn-sm" href="auth.php">Đăng nhập <i class="fa-solid fa-arrow-right ms-1"></i></a>';
 echo '</div></div></div></nav><main class="container page-shell">';
 if(!empty($_SESSION['flash'])) { $f=$_SESSION['flash']; unset($_SESSION['flash']); echo '<div class="alert alert-'.e($f['type']).' alert-dismissible fade show mt-3 shadow-sm">'.e($f['message']).'<button class="btn-close" data-bs-dismiss="alert"></button></div>'; }
}
function footer_html(): void { echo '</main><footer class="site-footer mt-5"><div class="container py-5"><div class="row g-4"><div class="col-lg-5"><a class="footer-brand" href="index.php"><i class="fa-solid fa-book-open me-2"></i>IT-Books</a><p class="footer-desc mt-3">Không gian tra cứu và chia sẻ giáo trình Công nghệ thông tin. Hỗ trợ sinh viên tìm tài liệu phù hợp cho từng học phần.</p></div><div class="col-6 col-lg-2"><h6>Khám phá</h6><a href="index.php">Trang chủ</a><a href="books.php">Kho giáo trình</a><a href="community.php">Cộng đồng</a></div><div class="col-6 col-lg-2"><h6>Tài khoản</h6><a href="auth.php">Đăng nhập</a><a href="profile.php">Thông tin cá nhân</a><a href="orders.php">Đơn hàng</a></div><div class="col-lg-3"><h6>IT-Books</h6><p class="footer-desc mb-2"><i class="fa-solid fa-book-open me-2"></i>Học tập và phát triển</p><p class="footer-desc"><i class="fa-solid fa-laptop-code me-2"></i>Công nghệ thông tin</p></div></div><div class="footer-bottom mt-4 pt-3 d-flex flex-wrap justify-content-between gap-2"><span>© '.date('Y').' IT-Books. All rights reserved.</span><span>Thiết kế dành cho cộng đồng học tập CNTT</span></div></div></footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script src="main.js"></script></body></html>'; }

function upload_book_file(string $field, string $kind, ?string $current = null): ?string {
    if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return $current;
    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Tệp tải lên bị lỗi.');
    $max = $kind === 'cover' ? 5 * 1024 * 1024 : 25 * 1024 * 1024;
    if ($file['size'] > $max) throw new RuntimeException($kind === 'cover' ? 'Ảnh bìa tối đa 5MB.' : 'Tài liệu PDF tối đa 25MB.');
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = $kind === 'cover' ? ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'] : ['application/pdf'=>'pdf'];
    if (!isset($allowed[$mime])) throw new RuntimeException($kind === 'cover' ? 'Ảnh bìa chỉ nhận JPG, PNG hoặc WEBP.' : 'Tài liệu chỉ nhận định dạng PDF.');
    $dir = __DIR__ . '/uploads/' . ($kind === 'cover' ? 'covers' : 'books');
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) throw new RuntimeException('Không thể tạo thư mục lưu tệp.');
    $name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) throw new RuntimeException('Không thể lưu tệp tải lên.');
    return 'uploads/' . ($kind === 'cover' ? 'covers' : 'books') . '/' . $name;
}
function book_cover(?string $path, int $id = 0): string {
    $path = trim((string)$path);
    return $path !== '' ? $path : ($id > 0 ? 'cover.php?id=' . $id : 'assets/covers/default.svg');
}
