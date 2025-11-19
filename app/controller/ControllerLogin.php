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
    $pwdPlain = htmlspecialchars($_POST['pwd']     ?? '');

    if ($user !== '' && $name !== '' && $email !== '' && $pwdPlain !== '') {
        $password = hash('sha256', $pwdPlain);
        $message  = crearUsuari($user, $name, $surname, $email, $password);
    } else {
        $message = "Falten camps per omplir.";
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