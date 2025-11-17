<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creació Objectes</title>
    <link rel="stylesheet" href="../../../resources/css/style.css"/>
</head>
<body>
    <nav>
        <div class="navContainer">
            <ul class="navUl">
                <li><a class="first" href="../../../index.php">Inici</a></li>
                <li><a href="../objectes.php">Objectes</a></li>
            </ul>

            <ul class="navUl">
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="user-menu">
                        <span class="user-menu-name">
                            <?= htmlspecialchars($_SESSION['user']) ?>
                        </span>
                        <ul class="user-dropdown">
                            <li><a href="../logout.php">Log Out</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a class="last" href="../login.php">Log In</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main>

    </main>
</body>
</html>