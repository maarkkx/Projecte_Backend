<?php
require_once __DIR__ . '/../../config/db-connection.php';
require_once __DIR__ . '/../model/ModelProfile.php';

$message = '';
$messageErr = '';

$passMessage = '';
$passMessageErr = '';

$success = false;

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$currentUser = $_SESSION['user'];

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

//Minimos requisitos pa la password
function checkPasswd(string $pwd): bool
{
    if (strlen($pwd) < 8) return false;
    if (!preg_match('/[0-9]/', $pwd)) return false;
    if (!preg_match('/[A-Z]/', $pwd)) return false;
    return true;
}

//--------------------------------------------
//--------------Cambiar username--------------
//--------------------------------------------
if (isset($_POST['update_profile'])) {

    $csrf = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $messageErr = "Petición no válida.";
    } else {

        $newUser = trim($_POST['new_user'] ?? '');

        if ($newUser === '') {
            $messageErr = "El usuario no puede estar vacío.";
        } elseif ($newUser === $currentUser) {
            $messageErr = "El nombre de usuario no puede ser el mismo que el actual.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $newUser)) { //Comprobar que el usuario cimple con la regex
            $messageErr = "Usuario inválido. Usa 3-20 caracteres: letras, números o _";
        } elseif (profile_user_exists($newUser, $conn)) {
            $messageErr = "Ese usuario ya existe. Elige otro.";
        } else {
            if (profile_update_username($currentUser, $newUser, $conn)) {
                $_SESSION['user'] = $newUser; //cambia el user en la sesion al nuevo
                $currentUser = $newUser;

                session_regenerate_id(true);
                $_SESSION['csrf_token'] = bin2hex(random_bytes(16));

                $success = true;
                $message = "Usuario actualizado correctamente.";
            } else {
                $messageErr = "No se pudo actualizar el usuario.";
            }
        }
    }
}

//-----------------------------------
//----------Cambiar Passw------------
//-----------------------------------
if (isset($_POST['change_password'])) {

    $csrf = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $passMessageErr = "Petición no válida.";
    } else {
        //get passwords de los campos
        $currentPwd = (string)($_POST['current_password'] ?? '');
        $newPwd     = (string)($_POST['new_password'] ?? '');
        $confirmPwd = (string)($_POST['confirm_password'] ?? '');

        //check de que los campos no estan vacios
        if ($currentPwd === '' || $newPwd === '' || $confirmPwd === '') {
            $passMessageErr = "Faltan campos.";
        
        //check que la contraseña nueva y el cofnmiration coincidan
        } elseif ($newPwd !== $confirmPwd) {
            $passMessageErr = "Las nuevas contraseñas no coinciden.";

        //check de la regex
        } elseif (!checkPasswd($newPwd)) {
            $passMessageErr = "Contraseña inválida: mínimo 8 caracteres, 1 número y 1 mayúscula.";
        } else {

            $storedHash = getPasswd($currentUser, $conn);
            if ($storedHash === null) {
                $passMessageErr = "No se encontró el usuario.";
            } else {

                $currentHash = hash('sha256', $currentPwd);

                //comprobacion de uqe las contraseñas coinciden antes de hacer el cambio
                if (!hash_equals($storedHash, $currentHash)) {
                    $passMessageErr = "La contraseña actual no es correcta.";
                } else {

                    $newHash = hash('sha256', $newPwd);
                    
                    //check de que la contraseña antigua no coincida con la nueva
                    if (hash_equals($storedHash, $newHash)) {
                        $passMessageErr = "La nueva contraseña no puede ser igual que la actual.";
                    } else {

                        if (updPasswd($currentUser, $newHash, $conn)) {

                            session_regenerate_id(true);
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(16));

                            $passMessage = "Contraseña actualizada correctamente.";
                        } else {
                            $passMessageErr = "No se pudo actualizar la contraseña.";
                        }
                    }
                }
            }
        }
    }
}
