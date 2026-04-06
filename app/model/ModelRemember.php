<?php
function remember_set_cookie(string $value, int $expiresTs): void {
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    setcookie('rememberme', $value, [
        'expires'  => $expiresTs,
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax' //para bloquear la cookie
    ]);
}

/**
 * Crea token y lo guarda en BD + cookie
 */
function remember_create_token(string $user, int $days = 30, $conn): void {
    $del = $conn->prepare("DELETE FROM remember_tokens WHERE user = :u");
    $del->execute([':u' => $user]);

    $selector  = base64url_encode(random_bytes(16));
    $validator = base64url_encode(random_bytes(32));

    $validatorHash = hash('sha256', $validator);
    $expiresTs     = time() + ($days * 24 * 60 * 60);
    $expiresAt     = date('Y-m-d H:i:s', $expiresTs);

    $ins = $conn->prepare("
        INSERT INTO remember_tokens (user, selector, validator_hash, expires_at)
        VALUES (:u, :s, :h, :e)
    ");
    $ins->execute([
        ':u' => $user,
        ':s' => $selector,
        ':h' => $validatorHash,
        ':e' => $expiresAt
    ]);

    remember_set_cookie($selector . ':' . $validator, $expiresTs);
}

/**
 * Elimina token de BDD
 */
function remember_forget_current_token($conn): void {

    if (empty($_COOKIE['rememberme'])) {
        remember_clear_cookie();
        return;
    }

    $parts = explode(':', $_COOKIE['rememberme'], 2);
    if (count($parts) !== 2) {
        remember_clear_cookie();
        return;
    }

    [$selector, $validator] = $parts;

    $del = $conn->prepare("DELETE FROM remember_tokens WHERE selector = :s");
    $del->execute([':s' => $selector]);

    remember_clear_cookie();
}

/**
 * Auto-login si NO hay session y existe cookie rememberme válido
 * - valida selector + hash(validator)
 * - comprueba expires
 * - si ok: setea $_SESSION['user'] y $_SESSION['admin']
 * - rota token (seguridad)
 */
function remember_auto_login_if_needed($conn): void {
    if (isset($_SESSION['user'])) return;
    if (empty($_COOKIE['rememberme'])) return;

    $parts = explode(':', $_COOKIE['rememberme'], 2);
    if (count($parts) !== 2) {
        remember_clear_cookie();
        return;
    }

    [$selector, $validator] = $parts;
    if ($selector === '' || $validator === '') {
        remember_clear_cookie();
        return;
    }

    $stmt = $conn->prepare("
        SELECT user, validator_hash, expires_at
        FROM remember_tokens
        WHERE selector = :s
        LIMIT 1
    ");
    $stmt->execute([':s' => $selector]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        remember_clear_cookie();
        return;
    }

    // expirado?
    if (strtotime($row['expires_at']) < time()) {
        $del = $conn->prepare("DELETE FROM remember_tokens WHERE selector = :s");
        $del->execute([':s' => $selector]);
        remember_clear_cookie();
        return;
    }

    $calcHash = hash('sha256', $validator);
    if (!hash_equals($row['validator_hash'], $calcHash)) {
        // intento raro -> lo eliminamos
        $del = $conn->prepare("DELETE FROM remember_tokens WHERE selector = :s");
        $del->execute([':s' => $selector]);
        remember_clear_cookie();
        return;
    }

    // si el token esta bien carga datos usuario
    $u = $conn->prepare("SELECT user, admin FROM users WHERE user = :u LIMIT 1");
    $u->execute([':u' => $row['user']]);
    $userRow = $u->fetch(PDO::FETCH_ASSOC);

    if (!$userRow) {
        // usuario ya no existe
        $del = $conn->prepare("DELETE FROM remember_tokens WHERE selector = :s");
        $del->execute([':s' => $selector]);
        remember_clear_cookie();
        return;
    }

    $_SESSION['user']  = $userRow['user'];
    $_SESSION['admin'] = $userRow['admin'];

    // Rotación del token (recomendado)
    $newValidator = base64url_encode(random_bytes(32));
    $newHash      = hash('sha256', $newValidator);
    $newExpiresTs = time() + (30 * 24 * 60 * 60);
    $newExpiresAt = date('Y-m-d H:i:s', $newExpiresTs);

    $up = $conn->prepare("
        UPDATE remember_tokens
        SET validator_hash = :h, expires_at = :e
        WHERE selector = :s
    ");
    $up->execute([
        ':h' => $newHash,
        ':e' => $newExpiresAt,
        ':s' => $selector
    ]);

    remember_set_cookie($selector . ':' . $newValidator, $newExpiresTs);
}

/**
 * Borrar cookie rememberme
 */
function remember_clear_cookie(): void {
    setcookie('rememberme', '', [
        'expires'  => time() - 3600,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}
?>