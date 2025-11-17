<?php
require_once __DIR__ . "/../controller/ControllerLogin.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Objects</title>
    <link rel="stylesheet" href="../../resources/css/style.css" />
</head>

<body>
    <nav>
        <div class="navContainer">
            <ul class="navUl">
                <li><a class="first" href="../../index.php">Inici</a></li>
                <li><a href="objectes.php">Objectes</a></li>
            </ul>
            <ul class="navUl">
                <li><a class="last" href="login.php">Log In</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <div class="loginform">
            <form method="post" action="">
                <h1>Log In</h1><br>
                <input placeholder="Username" type="text" name="user" id="user" class="user" value="<?php echo htmlspecialchars($user);?>"/><br><br>
                <input placeholder="Password" type="password" name="pwd" id="pwd" class="pwd"><br><br>
                <button type="submit" name="login" id="login" class="login">Log In</button>
                <input type="button" id="signin" value="Sign in" class="signin" onclick="window.location.href='Signin.php'">
                <?php if (!empty($message)): ?>
                    <div class="msg"><br><p><?= $message ?></p></div>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>

</html>