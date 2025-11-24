<?php
require_once __DIR__ . '/../../config/db-connection.php';
/**
 * @param user nombre usuario
 * @param nombre nombre
 * @param apellido apellido
 * @param correo correo de la cuenta
 * @param password contraseña
 */
function crearUsuari($user, $nombre, $apellido, $correo, $password) {
    global $conn;
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
        return "Error: " . $e->getMessage();
    }
}

/**
 * @param user nombre usuario
 * @param password contraseña del usuario
 */
function loginUsuari($user, $password) {
    global $conn;
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
?>