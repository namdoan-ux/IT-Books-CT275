<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) { session_start(); }
define('DB_HOST', '127.0.0.1'); define('DB_NAME', 'it_books'); define('DB_USER', 'root'); define('DB_PASS', '');
try {
 $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES=>false
 ]);
} catch (PDOException $e) { http_response_code(500); exit('Không thể kết nối MySQL. Hãy import database.sql và kiểm tra config.php. Chi tiết: '.htmlspecialchars($e->getMessage())); }
require_once __DIR__.'/functions.php';
