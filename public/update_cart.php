<?php
require_once dirname(__DIR__) . '/app/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); header('Allow: POST'); exit('Method Not Allowed'); }
csrf_check();
$action = $_POST['action'] ?? 'update';
$id = (int)($_POST['id'] ?? 0);
if ($action === 'remove') unset($_SESSION['cart'][$id]);
elseif ($action === 'clear') unset($_SESSION['cart']);
elseif (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['quantity'] = max(1, min(99, (int)($_POST['quantity'] ?? 1)));
redirect('cart.php');
