<?php

require_once __DIR__ . '/config/db-connection.php';
require_once __DIR__ . '/app/controller/ControllerApiArticles.php';
require_once __DIR__ . '/app/model/ModelApikey.php';

header('Content-Type: application/json');

function obtenerBearerToken(): ?string
{
    $authorizationHeader = null;

    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        $authorizationHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
    }

    if ($authorizationHeader === null && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
    }

    if (!$authorizationHeader || stripos($authorizationHeader, 'Bearer ') !== 0) {
        return null;
    }

    $token = trim(substr($authorizationHeader, 7));
    return $token !== '' ? $token : null;
}

$apiKey = obtenerBearerToken();

if ($apiKey === null) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Authorization Bearer token required'
    ]);
    exit();
}

$user = getUserByApiKey($conn, $apiKey);

if (!$user) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid API key'
    ]);
    exit();
}

$response = articles($conn);
echo json_encode($response);
exit();