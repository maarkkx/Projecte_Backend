<?php
require_once __DIR__ . '/../model/ModelObj.php';
$allowed = [1, 5, 10, 15, 20];

//agafar pagines del select:
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;

    //Comprovació si la var $perPage esta dins del rang de la array $allowed, en cas de que no canvia el valor a 5 (per evitar que l'usuari canvii el link)
if (!in_array($perPage, $allowed, true)) $perPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    //comprovació de la var $page, si es mes petit que 1 torna a la primera pagina
if ($page < 1) $page = 1;

//Calcular les pagines totals
$total = countArticles();
$totalPages = max(1, ceil($total / $perPage));

//Si l'usuari canvia la pagina no pot superar les maximes pagines
if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $perPage;


$articles = selectArticles($perPage, $offset);
?>