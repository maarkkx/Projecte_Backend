<?php
require_once __DIR__ . '/../model/ModelObj.php';

$allowed = [1, 5, 10, 15, 20];

// Cantidad por página
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
if (!in_array($perPage, $allowed, true)) {
    $perPage = 5;
}

// Número de página (usamos "num" para no chocar con page=objectes/login/etc)
$pageNum = isset($_GET['num']) ? (int)$_GET['num'] : 1;
if ($pageNum < 1) {
    $pageNum = 1;
}

$total = countArticles();
$totalPages = max(1, ceil($total / $perPage));

if ($pageNum > $totalPages) {
    $pageNum = $totalPages;
}

$offset = ($pageNum - 1) * $perPage;

// obtenemos artículos
$articles = selectArticles($perPage, $offset);
?>