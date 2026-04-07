<?php
require_once __DIR__ . '/config/db-connection.php';
require_once __DIR__ . '/app/controller/ControllerApiArticles.php';

header('Content-Type: application/json');

$response = getArticlesApi($conn);

echo json_encode($response);
exit(); 