<?php
require_once __DIR__ . '/../model/ModelForgotpasswd.php';
require_once __DIR__ . '/../../config/mail.php';

if (isset($_POST['requestReset'])) {
    $email = htmlspecialchars($_POST['email']);
    
    //Generar token
    $token = bin2hex(random_bytes(32));

    
    //guardar token a la bd
    if (guardarTokenReset($conn, $email, hash('sha256', $token))) {
        
        //crear l'enllaç
        $enlace = "http://localhost/practiques/backend/Projecte/index.php?page=reset_password&token=" . $token;
        
        //enviar el mail
        if (enviarEmailRecuperacion($email, $enlace)) {
            $message = "S'ha enviat un correu de recuperació.";
        } else {
            $messageErr = "Error enviant l'email.";
        }
    }
}