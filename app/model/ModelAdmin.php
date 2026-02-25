<?php
require_once __DIR__ . '/../../config/db-connection.php';

/**
 * Devuelve una array co ntodos los admins
 * @return array
 */
function getAllUsersAdmin(): array {
    global $conn;

    $sql = "SELECT user, nombre, apellido, correo, admin
            FROM users
            ORDER BY admin DESC, user ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Borra solo usuarios que NO son admin (admin='0')
 */
function deleteUserAdmin(string $userToDelete): bool {
    global $conn;

    $sql = "DELETE FROM users
            WHERE user = :u
              AND admin = '0'";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':u' => $userToDelete]);

    return $stmt->rowCount() > 0;
}
?>