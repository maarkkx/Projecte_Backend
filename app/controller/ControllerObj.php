<?php
require_once __DIR__ . '/../model/ModelObj.php';

$allowed = [1, 5, 10, 15, 20];

$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
if (!in_array($perPage, $allowed, true)) {
    $perPage = 5;
}

$pageNum = isset($_GET['num']) ? (int)$_GET['num'] : 1;
if ($pageNum < 1) {
    $pageNum = 1;
}

if (isset($_SESSION['user'])) {
    $currentUser = $_SESSION['user'];
    $total = countArticlesByUser($currentUser);
} else {
    $total = countArticles();
}

$totalPages = max(1, ceil($total / $perPage));

if ($pageNum > $totalPages) {
    $pageNum = $totalPages;
}

$offset = ($pageNum - 1) * $perPage;

if (isset($_SESSION['user'])) {
    $articles = selectArticlesByUser($currentUser, $perPage, $offset);
} else {
    $articles = selectArticles($perPage, $offset);
}

$message = "";
$title = "";
$cos = "";

if (isset($_POST['create'])) {
    $title = htmlspecialchars($_POST['titol'] ?? '');
    $cos = htmlspecialchars($_POST['cos'] ?? '');
    $userCreator = $_SESSION['user'] ?? '';

    if ($title !== '' && $cos !== '') {
       $message = createArticle($userCreator, $title, $cos);
    }
}
?>