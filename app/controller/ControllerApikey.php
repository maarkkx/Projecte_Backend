<?php
require_once __DIR__ . '/../../config/api.php';
require_once __DIR__ . '/../../config/db-connection.php';
require_once __DIR__ . '/../model/ModelApikey.php';

$message = '';
$messageErr = '';

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

if (isset($_POST['generate_api_key'])) {
    try {
        $user = $_SESSION['user'];

        //Mirar si ya tiene una api key guardada en la BD
        $existingApiKey = getApiKey($conn, $user);

        if (!empty($existingApiKey['api_key_hash'])) {
            $messageErr = 'You already have an Api Key';
        } else {
            $apiFirst = FIRST_PART_API_KEY;
            $apiMid = random_int(0, 100000);
            $apiLast = $user;

            $apikey = $apiFirst . $apiMid . $apiLast;
            $hashApiKey = hash('sha256', $apikey);

            $check = saveApiKey($hashApiKey, $conn, $user);

            if ($check) {
                $_SESSION['api_key'] = $apikey;
                $message = 'Api Key created successfully. Your Api Key: ' . $apikey;

            } else {
                throw new Exception('Error creating api key');
            }
        }
    } catch (Exception $e) {
        $messageErr = "Error: " . $e->getMessage();
    }
}
?>