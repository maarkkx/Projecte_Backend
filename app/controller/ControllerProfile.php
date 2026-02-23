<?php
require_once __DIR__ . '/../model/ModelProfile.php';

$message = '';
$success = false;

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$currentUser = $_SESSION['user'];

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

if (isset($_POST['update_profile'])) {
    $csrf = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $messageErr = "Petición no válida.";
    } else {
        $newUser = trim($_POST['new_user'] ?? '');

        if ($newUser === '') {
            $messageErr  = "El usuario no puede estar vacío.";
        } elseif ($newUser === $currentUser) {
            $messageErr = "El nombre de usuario no puede ser el mismo que el actual.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $newUser)) {
            $messageErr = "Usuario inválido. Usa 3-20 caracteres: letras, números o _";
        } elseif (profile_user_exists($newUser)) {
            $messageErr = "Ese usuario ya existe. Elige otro.";
        } else {
            if (profile_update_username($currentUser, $newUser)) {
                // Actualiza sesión
                $_SESSION['user'] = $newUser;
                $currentUser = $newUser;

                // Seguridad extra
                session_regenerate_id(true);
                $_SESSION['csrf_token'] = bin2hex(random_bytes(16));

                $success = true;
                $message = "Usuario actualizado correctamente.";
            } else {
                $messageErr = "No se pudo actualizar el usuario.";
            }
        }
    }
}