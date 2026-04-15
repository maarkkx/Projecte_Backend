<?php
require_once __DIR__ . '/../model/ModelForgotpasswd.php';
require_once __DIR__ . '/../../config/db-connection.php';

$message = "";
$messageErr = "";

$tokenValido = false;
$emailUsuario = "";

//Validar token en la url
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
    
    $resultado = validarTokenReset($conn, hash('sha256', $token));

    if ($resultado) {
        $tokenValido = true;
        $emailUsuario = $resultado['email']; 
    } else {
        $messageErr = "L'enllaç de recuperació no és vàlid o ha caducat.";
    }
} else {
    $messageErr = "No s'ha proporcionat cap token.";
}


//guardar la nova contrasenya
if (isset($_POST['submitReset']) && $tokenValido) {
    
    $password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];

    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/u', $password)) {
        $messageErr = "La contrasenya ha de tenir almenys 8 caràcters, incloure una majúscula i un número.";
    } elseif ($password !== $repeat_password) {
        $messageErr = "Les contrasenyes no coincideixen.";
    } else {
        $hashed_password = hash('sha256', $password);

        if (actualizarPasswordUsuario($conn, $emailUsuario, $hashed_password)) {
            
            borrarTokenReset($conn, $emailUsuario);
            
            $message = "La contrasenya s'ha restablert correctament. Ja pots iniciar sessió.";
            $tokenValido = false; 
        } else {
            $messageErr = "S'ha produït un error en actualitzar la contrasenya.";
        }
    }
}
?>