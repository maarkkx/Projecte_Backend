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
                <li><a href="">Objectes</a></li>
            </ul>
            <ul class="navUl">
                <li><a class="last" href="login.php">Log In</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <div class="loginform">
            <form method="post" action="">
                <h1>Sign In</h1><br>
                <input placeholder="Usuario" type="text" name="user" id="user" class="inputs" value="<?php echo htmlspecialchars($user);?>"/><br><br>
                <input placeholder="Nombre" type="text" name="name" id="name" class="inputs" value="<?php echo htmlspecialchars($name);?>"><br><br>
                <input placeholder="Apellido" type="text" name="surname" id="surname" class="inputs" value="<?php echo htmlspecialchars($surname);?>"><br><br>
                <input placeholder="Correo Electrónico" type="email" name="email" id="email" class="inputs" value="<?php echo htmlspecialchars($email);?>"><br><br>
                <input placeholder="Password" type="password" name="pwd" id="pwd" class="inputs"><br><br>
                <input type="button" id="login" value="Log In" class="login" onclick="window.location.href='login.php'">
                <button type="submit" name="signin" id="signin" value="Sign in" class="signin">Sign In</button>
                <?php if (!empty($message)): ?>
                    <div class="msg"><br><p><?= $message ?></p></div>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>

</html>