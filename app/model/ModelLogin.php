<?php
/**
 * @param user nombre usuario
 * @param nombre nombre
 * @param apellido apellido
 * @param correo correo de la cuenta
 * @param password contraseña
 */
function crearUsuari($user, $nombre, $apellido, $correo, $password, $conn) {
    try {
        $sql = "INSERT INTO users (user, nombre, apellido, correo, password) 
                VALUES (:user, :nombre, :apellido, :correo, :password)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":user" => $user,
            ":nombre"=> $nombre,
            ":apellido"=> $apellido,
            ":correo"=> $correo,
            ":password"=>$password
        ]);
        return "User created!";
    } catch (PDOException $e) {
        return "Error, try again";
    }
}

/**
 * @param user nombre usuario
 * @param password contraseña del usuario
 */
function loginUsuari($user, $password, $conn) {
    try {
        $sql = "SELECT * FROM `users` 
                WHERE user = :user AND password = :password 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":user"=>$user,
            ":password"=>$password
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return false;
    }
}

function getUserByOAuth($provider, $uid, $conn) {
    $stmt = $conn->prepare("
        SELECT * FROM users 
        WHERE oauth_provider = ? AND oauth_uid = ?
    ");
    $stmt->execute([$provider, $uid]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function crearUsuariOAuth($user, $email, $provider, $uid, $conn) {
    $stmt = $conn->prepare("
        INSERT INTO users (user, correo, oauth_provider, oauth_uid)
        VALUES (?, ?, ?, ?)
    ");
    return $stmt->execute([$user, $email, $provider, $uid]);
}

//crear un username diferent en cas de que existeixi ja un (oauth)
function generarUsernameUnico($username, $conn) {
    $base = $username;
    $i = 1;

    //comproven si existeix l'user, si existeix afegim un numero fins que ja no existeixi
    while (true) {
        $stmt = $conn->prepare("SELECT user FROM users WHERE user = ?");
        $stmt->execute([$username]);

        if (!$stmt->fetch()) return $username;

        $username = $base . $i;
        $i++;
    }
}

?>