<?php
require_once __DIR__ . '/../model/ModelObj.php';

// 4 articles aleatoris per la portada
$featuredArticles = selectRandomArticles(4);
?>