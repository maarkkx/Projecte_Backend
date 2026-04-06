<?php
require_once __DIR__ . '/../../config/db-connection.php';

function guardarTokenReset($conn, $email, $token) {
    $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));
    
    //borrar els tokens antics del correo
    $del = $conn->prepare("DELETE FROM password_resets WHERE email = :e");
    $del->execute([':e' => $email]);

    //Creem el nou token
    $ins = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (:e, :t, :ex)");
    return $ins->execute([
        ':e' => $email,
        ':t' => $token,
        ':ex' => $expires
    ]);
}

function validarTokenReset($db, $token) {
    $stmt = $db->prepare("SELECT email FROM password_resets WHERE token = :t AND expires_at > NOW() LIMIT 1");
    $stmt->execute([':t' => $token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function actualizarPasswordUsuario($conn, $email, $hashed_password) {
    $stmt = $conn->prepare("UPDATE users SET password = :p WHERE correo = :e");
    return $stmt->execute([
        ':p' => $hashed_password,
        ':e' => $email
    ]);
}

// 4. Borrar el token para que no se pueda volver a usar
function borrarTokenReset($conn, $email) {
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = :e");
    return $stmt->execute([':e' => $email]);
}