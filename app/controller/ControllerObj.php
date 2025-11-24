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

// Info de sesión
$isLogged = isset($_SESSION['user']);
$isAdmin  = $isLogged && isset($_SESSION['admin']) && $_SESSION['admin'] === '1';

// 1) Calcular total de artículos para la paginación
if ($isLogged && !$isAdmin) {
    // usuario normal -> solo sus artículos
    $total = countArticlesByUser($_SESSION['user']);
} else {
    // no logeado o admin -> ve todos
    $total = countArticles();
}

$totalPages = max(1, ceil($total / $perPage));
if ($pageNum > $totalPages) {
    $pageNum = $totalPages;
}

$offset = ($pageNum - 1) * $perPage;

// 2) Obtener lista de artículos
if ($isLogged && !$isAdmin) {
    // usuario normal
    $articles = selectArticlesByUser($_SESSION['user'], $perPage, $offset);
} else {
    // admin o invitado
    $articles = selectArticles($perPage, $offset);
}
?>
