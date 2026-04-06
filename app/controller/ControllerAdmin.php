<?php
require_once __DIR__ . '/../model/ModelAdmin.php';
require_once __DIR__ . '/../../config/db-connection.php';

$message = "";
$messageErr = "";

$currentUser = $_SESSION['user'];

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

//eliminar usuario
if (isset($_POST['delete_user'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $messageErr = "Invalid request.";
    } else {
        $userToDelete = trim($_POST['delete_user'] ?? '');

        if ($userToDelete === '') {
            $messageErr = "Fields missing";
        } elseif ($userToDelete === $currentUser) {
            $messageErr = "You can't delete yourself.";
        } else {
            if (deleteUserAdmin($userToDelete, $conn)) {
                $message = "User deleted successfully.";
            } else {
                $messageErr = "You can't delete administrators (or user not found).";
            }
        }
    }
}

$users = getAllUsersAdmin($conn);