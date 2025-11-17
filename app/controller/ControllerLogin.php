<?php
require_once __DIR__ . "/../model/ModelLogin.php";

$message = "";
$user = "";
$name = "";
$surname = "";
$email = "";

if (isset($_POST['signin'])) {
    $message = null;
    $user     = htmlspecialchars($_POST['user']    ?? '');
    $name     = htmlspecialchars($_POST['name']    ?? '');
    $surname  = htmlspecialchars($_POST['surname'] ?? '');
    $email    = htmlspecialchars($_POST['email']   ?? '');
    $password = hash('sha256', htmlspecialchars($_POST['pwd']     ?? ''));

    if ($user !== '' && $name !== '' && $email !== '' && $password !== '') {
        $message = crearUsuari($user, $name, $surname, $email, $password);
    } else {
        $message = "Falten camps per omplir.";
    }
}


if (isset($_POST['login'])) {
    $message = null;
    $user = htmlspecialchars(($_POST['user'] ?? ''));
    $password = hash('sha256', htmlspecialchars(($_POST['pwd'] ?? '')));
    if ($user !== '' && $password !== '') {
        $message = loginUsuari($user, $password);
    } else {
        $message = "Has de omplir tots els camps";
    }
}
?>