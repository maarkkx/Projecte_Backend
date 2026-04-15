<?php
function getArticlesApi($articles) {
    try {
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
?>