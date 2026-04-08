<?php
require_once __DIR__ . '/config/db-connection.php';
session_start();

// timeout (no rememeber)
$IDLE_TIMEOUT = 30 * 60; //30 mins

if (isset($_SESSION['user'])) {
    $now = time();

    if (isset($_SESSION['last_activity']) && ($now - $_SESSION['last_activity']) > $IDLE_TIMEOUT) {
        session_unset();
        session_destroy();
        session_start();
    } else {
        $_SESSION['last_activity'] = $now;
    }
} else {
    // aunque no esté logueado, inicializamos para evitar warnings
    $_SESSION['last_activity'] = time();
}

require_once __DIR__ . '/app/model/ModelRemember.php';
remember_auto_login_if_needed($conn);
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Objects</title>
    <link rel="stylesheet" href="resources/css/generic.css">
    <link rel="stylesheet" href="resources/css/footer.css">
    <!--CSS personalitzat per cada pàgina-->
    <link rel="stylesheet" href="resources/css/<?= $page ?>.css">

    <link href="https://fonts.cdnfonts.com/css/pokemon-solid" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    //Barra navegació a totes les pagines
    $navClass = ($page === 'objectes') ? 'navObj' : '';
    ?>
    <div class="navigation">
        <nav class="<?= $navClass ?>">
            <div class="navContainer">
                <ul class="navUl">
                    <li><a title="Main Page" class="first" href="index.php">Home</a></li>
                    <li><a title="Objects Page" href="index.php?page=objectes">Objects</a></li>
                    <li><a title="Api Key" href="index.php?page=apikey">Api</a></li>
                </ul>
                <ul class="navUl">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === '1'): ?>
                            <li><a title="Admin" href="index.php?page=admin">Admin</a></li>
                        <?php endif; ?>
                        <li><a title="Profile" class="" href="index.php?page=profile">Profile</a></li>
                        </li>
                        </li>
                        <li class="user-menu">
                            <span class="user-menu-name">
                                <?= htmlspecialchars($_SESSION['user']) ?>
                            </span>
                            <ul class="user-dropdown">
                                <li><a title="Log Out" class="logoutA" href="index.php?page=logout">Log Out</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a title="Access" class="last" href="index.php?page=login">Log In</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
    <?php
    //enrutador, selecciona el contingut del main segons la pagina
    switch ($page) {

        case 'objectes':
            require __DIR__ . '/app/controller/ControllerObj.php';
            echo '<main class="mainObj">';
            require __DIR__ . '/app/view/objectes.php';
            echo '</main>';
            break;

        case 'login':
            require __DIR__ . '/app/controller/ControllerLogin.php';
            echo '<main class="mainLogin">';
            require __DIR__ . '/app/view/Login.php';
            echo '</main>';
            break;

        case 'signin':
            require __DIR__ . '/app/controller/ControllerLogin.php';
            echo '<main class="mainSignin">';
            require __DIR__ . '/app/view/Signin.php';
            echo '</main>';
            break;

        case 'crear':
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?page=login");
                exit;
            }
            require __DIR__ . '/app/controller/ControllerObj.php';
            echo '<main class="mainObj">';
            require __DIR__ . '/app/view/vistacrud/viewinsertar.php';
            echo '</main>';
            break;

        case 'logout':
            require_once __DIR__ . '/app/model/ModelRemember.php';
            remember_forget_current_token($conn);

            session_unset();
            session_destroy();
            header("Location: index.php");
            exit;

        case 'home':
        default:
            require __DIR__ . '/app/controller/ControllerHome.php';
            echo '<main class="mainHome">';
            require __DIR__ . '/app/view/home.php';
            echo '</main>';
            break;

        case 'editar':
            // només usuaris loguejats
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?page=login");
                exit;
            }

            require __DIR__ . '/app/controller/ControllerEditArticle.php';
            echo '<main class="mainObj">';
            require __DIR__ . '/app/view/vistacrud/vieweditar.php';
            echo '</main>';
            break;

        case 'profile':
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?page=login");
                exit;
            }

            require __DIR__ . '/app/controller/ControllerProfile.php';
            echo '<main class="mainObj">';
            require __DIR__ . '/app/view/editProfile.php';
            echo '</main>';
            break;

        case 'admin':
            //Solo admins
            if (!isset($_SESSION['user']) || !isset($_SESSION['admin']) || $_SESSION['admin'] !== '1') {
                header("Location: index.php?page=home");
                exit;
            }

            require __DIR__ . '/app/controller/ControllerAdmin.php';

            echo '<main class="mainObj">';
            require __DIR__ . '/app/view/admin.php';
            echo '</main>';
            break;

        case '403':
            http_response_code(403);
            require __DIR__ . '/app/view/errors/403.php';
            break;

        case 'forgot':
            require __DIR__ . '/app/controller/ControllerForgot.php';
            require __DIR__ . '/app/view/forgot.php';
            break;

        case 'reset_password':
            require_once __DIR__ . '/app/controller/ControllerReset.php';
            require __DIR__ . '/app/view/reset_password.php';
            break;

        case 'oauth_github':
            require __DIR__ . '/app/controller/ControllerOauth.php';
            break;
        
        case 'apikey':
            if (!isset($_SESSION['user'])) {
                header("Location: index.php?page=login");
                exit;
            }
            require __DIR__ . '/app/view/apikey.php';
            break;
    }


    ?>
    <footer>
        <h3 className="titleAutor">Mark Gras</h3>
        <h3 className="titleProj">Projecte Backend</h3>
    </footer>
</body>

</html>