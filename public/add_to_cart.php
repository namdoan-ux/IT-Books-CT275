<?php
require_once dirname(__DIR__) . '/app/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); header('Allow: POST'); exit('Method Not Allowed'); }
csrf_check();
$id = (int)($_POST['product_id'] ?? 0);
$st = $pdo->prepare("SELECT id,title,price FROM books WHERE id=? AND status='active'");
$st->execute([$id]);
$b = $st->fetch();
if ($b) {
    $_SESSION['cart'][$id] = ['id'=>$id, 'title'=>$b['title'], 'price'=>$b['price'], 'quantity'=>min(99, (int)($_SESSION['cart'][$id]['quantity'] ?? 0) + 1)];
    flash('success', 'Đã thêm giáo trình vào giỏ hàng.');
} else { flash('danger', 'Giáo trình không tồn tại hoặc đã ngừng bán.'); }
redirect('cart.php');
