<?php
require_once __DIR__ . "/../model/ModelLogin.php";
require_once __DIR__ . '/../model/ModelRecaptcha.php';
require_once __DIR__ . '/../../config/recaptcha.php';

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
if (!isset($_SESSION['login_fails'])) {
    $_SESSION['login_fails'] = 0;
}

try {
    if (isset($_POST['login'])) {


        $maxIntentos = 3;
        $verificar = true;

        if ($_SESSION['login_fails'] >= $maxIntentos) {
            $token = $_POST['g-recaptcha-response'] ?? '';
            $verificar = verificarRecaptcha($token, RECAPTCHA_SECRET_KEY);

            if (!$verificar) {
                $messageErr = "Confirma el reCAPTCHA.";
                throw new Exception("Captcha incorrecto");
            }
        }

        $user     = htmlspecialchars($_POST['user'] ?? '');
        $pwdPlain = htmlspecialchars($_POST['pwd']  ?? '');

        if ($_SESSION['login_fails'] > 3 || !$verificar) {
            throw new Exception("Error login");
        }

        if ($user !== '' && $pwdPlain !== '') {
            $password = hash('sha256', $pwdPlain);

            $row = loginUsuari($user, $password);

            if ($row) {
                $_SESSION['login_fails'] = 0;

                $_SESSION['user']  = $row['user'];
                $_SESSION['admin'] = $row['admin'];

                require_once __DIR__ . '/../model/ModelRemember.php';

                if (!empty($_POST['remember'])) {
                    remember_create_token($row['user'], 30);
                } else {
                    remember_forget_current_token();
                }

                header("Location: index.php");
                exit;
            } else {
                $messageErr = "Incorrect user or password";
                $_SESSION['login_fails']++;
            }
        } else {
            $messageErr = "Fields missing";
            $_SESSION['login_fails']++;
        }
    }
} catch (Exception $e) {
    if (empty($messageErr)) $messageErr = "Error login";
}
