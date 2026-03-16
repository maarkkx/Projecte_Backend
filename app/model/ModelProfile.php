<?php
require_once __DIR__ . '/../../config/db-connection.php';

function profile_user_exists(string $user): bool {
    global $conn;

    $stmt = $conn->prepare("SELECT 1 FROM users WHERE user = :u LIMIT 1");
    $stmt->execute([':u' => $user]);
    return (bool)$stmt->fetchColumn();
}

function profile_update_username(string $oldUser, string $newUser): bool {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET user = :new WHERE user = :old");
    $stmt->execute([
        ':new' => $newUser,
        ':old' => $oldUser
    ]);

    return $stmt->rowCount() > 0;
}

//get contraseña hasheada
function getPasswd(string $user): ?string {
  global $conn;
  $stmt = $conn->prepare("SELECT password FROM users WHERE user = :u LIMIT 1");
  $stmt->execute([':u' => $user]);
  $hash = $stmt->fetchColumn();
  return $hash ? (string)$hash : null;
}

/**
 * Actualiza el hash de password del usuario
 */
function updPasswd(string $user, string $newHash): bool {
  global $conn;
  $stmt = $conn->prepare("UPDATE users SET password = :p WHERE user = :u");
  $stmt->execute([':p' => $newHash, ':u' => $user]);
  return $stmt->rowCount() > 0;
}