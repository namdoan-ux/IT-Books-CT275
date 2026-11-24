<?php require 'config.php';csrf_check();if($_SERVER['REQUEST_METHOD']!=='POST')redirect('cart.php');$action=$_POST['action']??'';$id=(int)($_POST['book_id']??0);
if($action==='add'){$st=$pdo->prepare("SELECT id,title,price,status FROM books WHERE id=?");$st->execute([$id]);$b=$st->fetch();if(!$b||$b['status']!=='active'){flash('danger','Giáo trình không tồn tại.');redirect('index.php');}$_SESSION['cart'][$id]['id']=$id;$_SESSION['cart'][$id]['title']=$b['title'];$_SESSION['cart'][$id]['price']=$b['price'];$_SESSION['cart'][$id]['quantity']=($_SESSION['cart'][$id]['quantity']??0)+1;flash('success','Đã thêm giáo trình vào giỏ hàng.');}
if($action==='update'&&isset($_SESSION['cart'][$id])){$_SESSION['cart'][$id]['quantity']=max(1,min(99,(int)$_POST['quantity']));}
if($action==='remove'){unset($_SESSION['cart'][$id]);}
if($action==='clear'){unset($_SESSION['cart']);}
redirect('cart.php');