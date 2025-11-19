<div class="loginform">
    <form method="post" action="index.php?page=signin">
        <h1>Sign In</h1><br>
        <input placeholder="Usuario" type="text" name="user" id="user" class="inputs" value="<?php echo htmlspecialchars($user);?>"/><br><br>
        <input placeholder="Nombre" type="text" name="name" id="name" class="inputs" value="<?php echo htmlspecialchars($name);?>"><br><br>
        <input placeholder="Apellido" type="text" name="surname" id="surname" class="inputs" value="<?php echo htmlspecialchars($surname);?>"><br><br>
        <input placeholder="Correo Electrónico" type="email" name="email" id="email" class="inputs" value="<?php echo htmlspecialchars($email);?>"><br><br>
        <input placeholder="Password" type="password" name="pwd" id="pwd" class="inputs"><br><br>

        <input type="button" id="login" value="Log In" class="login" onclick="window.location.href='index.php?page=login'">
        <button type="submit" name="signin" id="signin" value="Sign in" class="signin">Sign In</button>
        <?php if (!empty($message)): ?>
            <div class="msg"><br><p><?= $message ?></p></div>
        <?php endif; ?>
    </form>
</div>