<?php
require_once __DIR__ . '/../model/ModelObj.php';
require_once __DIR__ . '/../../config/db-connection.php';

//Ordenar
$sortOpt = $_GET['sort'] ?? 'date_desc';
switch ($sortOpt) {
    case 'title_asc':  $sortBy = 'titol';      $dir = 'ASC';  break;
    case 'title_desc': $sortBy = 'titol';      $dir = 'DESC'; break;
    case 'date_asc':   $sortBy = 'created_at'; $dir = 'ASC';  break;
    case 'date_desc':
    default:           $sortOpt = 'date_desc'; $sortBy = 'created_at'; $dir = 'DESC'; break;
}

//Cantidad por paginaa
$allowed = [1, 5, 10, 15, 20];
$perPage = isset($_GET['per_page']) && in_array((int)$_GET['per_page'], $allowed) ? (int)$_GET['per_page'] : 5;
$pageNum = isset($_GET['num']) ? max(1, (int)$_GET['num']) : 1;

//check de si es admin
$isLogged = isset($_SESSION['user']);
$isAdmin  = $isLogged && isset($_SESSION['admin']) && $_SESSION['admin'] === '1';

if ($isLogged && !$isAdmin) {
    $total = countArticlesByUser($_SESSION['user'], $conn);
} else {
    $total = countArticles($conn);
}

//Calculara las paginas
$totalPages = max(1, ceil($total / $perPage));
if ($pageNum > $totalPages) {
    $pageNum = $totalPages;
}
$offset = ($pageNum - 1) * $perPage;

//Calculo de los botones
$maxNumbers = 3;
if ($totalPages <= 10) {
    $start = 1;
    $end   = $totalPages;
} else {
    $start = max(1, $pageNum - 1);
    $end   = min($totalPages, $pageNum + 1);

    if ($start == 1) {
        $end = min($start + $maxNumbers - 1, $totalPages);
    }
    if ($end == $totalPages) {
        $start = max(1, $end - $maxNumbers + 1);
    }
}

//Conseguir los artiuclos del usuario si no es admin
if ($isLogged && !$isAdmin) {
    $articles = selectArticlesByUser($_SESSION['user'], $perPage, $offset, $sortBy, $dir, $conn);
} else {
    $articles = selectArticles($perPage, $offset, $sortBy, $dir, $conn);
}


$baseParams = [
    'page'     => 'objectes',
    'per_page' => $perPage,
    'sort'     => $sortOpt,
];

if (isset($_POST['create']) && $isLogged) {
    $user  = $_SESSION['user'];
    $title = htmlspecialchars($_POST['titol'] ?? '');
    $cos   = htmlspecialchars($_POST['cos']   ?? '');
    $msgObj = createArticle($user, $title, $cos, $conn);
}
?>