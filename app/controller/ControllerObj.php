<?php
require_once __DIR__ . '/../model/ModelObj.php';

$allowed = [1, 5, 10, 15, 20];

//Cantidad por pagina
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
if (!in_array($perPage, $allowed, true)) {
    $perPage = 5;
}

//num pag
$pageNum = isset($_GET['num']) ? (int)$_GET['num'] : 1;
if ($pageNum < 1) {
    $pageNum = 1;
}

//Guardar si esta logueado
$isLogged = isset($_SESSION['user']);
$isAdmin  = $isLogged && isset($_SESSION['admin']) && $_SESSION['admin'] === '1';

if ($isLogged && !$isAdmin) {
    //Contar articulos del usuario logueado
    $total = countArticlesByUser($_SESSION['user']);
} else {
    //contar todos los articulos
    $total = countArticles();
}

$totalPages = max(1, ceil($total / $perPage));
if ($pageNum > $totalPages) {
    $pageNum = $totalPages;
}

$offset = ($pageNum - 1) * $perPage;

if ($isLogged && !$isAdmin) {
    //obtener todos los articulos del usuario si esta logueado
    $articles = selectArticlesByUser($_SESSION['user'], $perPage, $offset);
} else {
    //obtener todos los articulos
    $articles = selectArticles($perPage, $offset);
}
?>
