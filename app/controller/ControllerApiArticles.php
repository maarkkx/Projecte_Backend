<?php
require_once __DIR__ . '/../model/ModelObj.php';

function getArticlesApi($conn) {
    try {
        $articles = selectArticles(null, null, 'id', 'ASC', $conn);

        return [
            'success' => true,
            'data' => $articles
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}