<?php
require_once __DIR__ . '/../model/ModelObj.php';
require_once __DIR__ . '/../model/ModelApiArticles.php';

function articles($conn) {
    $articles = selectArticles(null, null, 'id', 'ASC', $conn);
    return getArticlesApi($articles);
}
