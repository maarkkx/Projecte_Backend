<?php
require_once __DIR__ . '/../model/ModelObj.php';

// comprobar id
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: index.php?page=objectes");
    exit;
}

$id = (int)$_GET['id'];

// cargar artículo
$article = getArticleById($id);
if (!$article) {
    $error = "Object not found.";
    return;
}

// comprobar permisos
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === '1';
if (!isset($_SESSION['user']) ||
    (!$isAdmin && $_SESSION['user'] !== $article['user'])) {

    $error = "You do not have permission to edit this article.";
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // borrar
    if (isset($_POST['delete'])) {
        if (deleteArticle($id)) {
            header("Location: index.php?page=objectes");
            exit;
        } else {
            $error = "Error deleting the object.";
        }
    }

    // guardar cambios
    if (isset($_POST['save'])) {
        $titol = $_POST['titol'] ?? '';
        $cos   = $_POST['cos'] ?? '';

        if (updateArticle($id, $titol, $cos)) {
            header("Location: index.php?page=objectes");
            exit;
        } else {
            $error = "Error updating the object.";
        }
    }
}
