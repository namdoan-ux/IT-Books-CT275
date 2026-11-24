<?php
require 'config.php';$action=$_GET['action']??'';$id=(int)($_POST['product_id']??$_GET['id']??0);
if($action==='remove')unset($_SESSION['cart'][$id]);elseif($action==='clear')unset($_SESSION['cart']);elseif($_SERVER['REQUEST_METHOD']==='POST'&&isset($_SESSION['cart'][$id]))$_SESSION['cart'][$id]['quantity']=max(1,min(99,(int)($_POST['quantity']??1)));
redirect('cart.php');
