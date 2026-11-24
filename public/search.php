<?php
require_once dirname(__DIR__) . '/app/config.php'; header('Content-Type: application/json; charset=utf-8');
$q=trim($_GET['q']??'');$sql="SELECT id,title,code,author,price FROM books WHERE status='active'";$args=[];
if($q!==''){$sql.=" AND (title LIKE ? OR code LIKE ? OR author LIKE ?)";$like="%$q%";$args=[$like,$like,$like];}
$sql.=" ORDER BY title";$st=$pdo->prepare($sql);$st->execute($args);echo json_encode($st->fetchAll(),JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_SUBSTITUTE);
