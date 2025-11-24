<?php
require_once __DIR__ . "/../model/ModelLogin.php";

$message = "";
$messageErr = "";
$user = "";
$name = "";
$surname = "";
$email = "";

//Crear Usuaris
if (isset($_POST['signin'])) {
    $messageErr = null;
    $message = null;
    $user     = htmlspecialchars($_POST['user']    ?? '');
    $name     = htmlspecialchars($_POST['name']    ?? '');
    $surname  = htmlspecialchars($_POST['surname'] ?? '');
    $email    = htmlspecialchars($_POST['email']   ?? '');
    $pwdPlain = htmlspecialchars($_POST['pwd']     ?? '');
    $pwdConf  = htmlspecialchars($_POST['pwdConf'] ?? '');

    // Ifs para comprobar los campos
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/u', $pwdPlain)) {
        $messageErr = "The password must meet the following requirements: <br> -8 characters <br> -1 Number <br> -1 Capital Letter"; 
    } else if ($pwdPlain !== $pwdConf) {
        $messageErr = "The passwords do not match";
    } else if ($user == '' || $name == '' || $email == '' || $pwdPlain == '') {
        $messageErr = "Fields missing";
    } else {
        $password = hash('sha256', $pwdPlain);
        $message  = crearUsuari($user, $name, $surname, $email, $password);
    }



}

//Iniciar sesion
if (isset($_POST['login'])) {
    $user     = htmlspecialchars($_POST['user'] ?? '');
    $pwdPlain = htmlspecialchars($_POST['pwd']  ?? '');

    //Comprobar los campos
    if ($user !== '' && $pwdPlain !== '') {
        $password = hash('sha256', $pwdPlain);

        $row = loginUsuari($user, $password);

        if ($row) {
            $_SESSION['user'] = $row['user'];
            $_SESSION['admin'] = $row['admin'];

            header("Location: index.php");
            exit;
        } else {
            $message = "Incorrect user or password";
        }
    } else {
        $message = "Fields missing";
    }
}
?>