<?php
require_once __DIR__ . "/../model/ModelLogin.php";

$message = "";
$messageErr = "";
$user = "";
$name = "";
$surname = "";
$email = "";

if (isset($_POST['signin'])) {
    $messageErr = null;
    $message = null;
    $user     = htmlspecialchars($_POST['user']    ?? '');
    $name     = htmlspecialchars($_POST['name']    ?? '');
    $surname  = htmlspecialchars($_POST['surname'] ?? '');
    $email    = htmlspecialchars($_POST['email']   ?? '');
    $pwdPlain = htmlspecialchars($_POST['pwd']     ?? '');
    $pwdConf  = htmlspecialchars($_POST['pwdConf'] ?? '');

    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/u', $pwdPlain)) {
        $messageErr = "La contrasenya ha de complir els requisits: <br> -8 Caràcters <br> -1 Número <br> -1 Majúscula"; 
    } else if ($pwdPlain !== $pwdConf) {
        $messageErr = "Les contrasenyes no coincideixen";
    } else if ($user == '' || $name == '' || $email == '' || $pwdPlain == '') {
        $messageErr = "Falten camps per omplir.";
    } else {
        $password = hash('sha256', $pwdPlain);
        $message  = crearUsuari($user, $name, $surname, $email, $password);
    }



}


if (isset($_POST['login'])) {
    $user     = htmlspecialchars($_POST['user'] ?? '');
    $pwdPlain = htmlspecialchars($_POST['pwd']  ?? '');

    if ($user !== '' && $pwdPlain !== '') {
        $password = hash('sha256', $pwdPlain);

        $row = loginUsuari($user, $password);

        if ($row) {
            $_SESSION['user'] = $row['user'];
            $_SESSION['admin'] = $row['admin'];

            header("Location: index.php");
            exit;
        } else {
            $message = "Usuari o contrasenya incorrecte";
        }
    } else {
        $message = "Has d'omplir tots els camps.";
    }
}
?>