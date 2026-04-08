<?php

require_once __DIR__ . '/config/db-connection.php';
require_once __DIR__ . '/app/controller/ControllerApiArticles.php';
require_once __DIR__ . '/app/model/ModelApikey.php';

header('Content-Type: application/json');

$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

if (empty($authHeader) && function_exists('getallheaders')) {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
}

if (empty($authHeader)) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Authorization header required'
    ]);
    exit();
}

if (!preg_match('/Bearer\s+(.+)/i', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid Authorization format'
    ]);
    exit();
}

$apiKey = trim($matches[1]);
$user = getUserByApiKey($conn, $apiKey);

if (!$user) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid API key'
    ]);
    exit();
}

$response = getArticlesApi($conn);
echo json_encode($response);
exit();