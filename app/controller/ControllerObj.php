<?php
require_once __DIR__ . '/../model/ModelObj.php';
$sortOpt = $_GET['sort'] ?? 'date_desc';

switch ($sortOpt) {
    case 'title_asc':
        $sortBy = 'titol';
        $dir    = 'ASC';
        break;
    case 'title_desc':
        $sortBy = 'titol';
        $dir    = 'DESC';
        break;
    case 'date_asc':
        $sortBy = 'created_at';
        $dir    = 'ASC';
        break;
    case 'date_desc':
    default:
        $sortOpt = 'date_desc';
        $sortBy  = 'created_at';
        $dir     = 'DESC';
        break;
}

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
    $articles = selectArticlesByUser($_SESSION['user'], $perPage, $offset, $sortBy, $dir);
} else {
    $articles = selectArticles($perPage, $offset, $sortBy, $dir);
}

if (isset($_POST['create'])) {
    $msgObj = null;
    $user = $_SESSION['user'];
    $title = htmlspecialchars($_POST['titol']    ?? '');
    $cos = htmlspecialchars($_POST['cos']    ?? '');

    $msgObj = createArticle($user, $title, $cos);
}
?>