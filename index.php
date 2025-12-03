<?php
session_start();
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
                </ul>

                <ul class="navUl">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="user-menu">
                            <span class="user-menu-name">
                                <?= htmlspecialchars($_SESSION['user']) ?>
                            </span>
                            <ul class="user-dropdown">
                                <li><a title="Log Out" class="logoutA" href="index.php?page=logout">Log Out</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a title="Log In" class="last" href="index.php?page=login">Log In</a></li>
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
            }
    ?>
    <footer>
        <h3 className="titleAutor">Mark Gras</h3>
        <h3 className="titleProj">Projecte Backend</h3>
    </footer>
</body>
</html>
