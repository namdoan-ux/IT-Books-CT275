<?php
require 'config.php';
$id=(int)($_POST['product_id']??$_GET['product_id']??0);
if($id>0){$st=$pdo->prepare("SELECT id,title,price FROM books WHERE id=? AND status='active'");$st->execute([$id]);$b=$st->fetch();if($b){$_SESSION['cart'][$id]=['id'=>$id,'title'=>$b['title'],'price'=>$b['price'],'quantity'=>($_SESSION['cart'][$id]['quantity']??0)+1];flash('success','Đã thêm giáo trình vào giỏ hàng.');}}
redirect('cart.php');
