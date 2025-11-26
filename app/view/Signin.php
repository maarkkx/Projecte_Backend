<div class="loginform">
    <form method="post" action="index.php?page=signin" class="formSign">
        <div class="divForm">
        <h1>Sign In</h1><br>
            <div class="username">
                <input placeholder="Usuario" type="text" name="user" id="user" class="inputs" value="<?php echo htmlspecialchars($user);?>"/>
            </div>

            <div class="name">
                <input placeholder="Nombre" type="text" name="name" id="name" class="inputs" value="<?php echo htmlspecialchars($name);?>">
                <input placeholder="Apellido" type="text" name="surname" id="surname" class="inputs" value="<?php echo htmlspecialchars($surname);?>">
            </div>
            <div class="correo">
                <input placeholder="Correo Electrónico" type="email" name="email" id="email" class="inputs" value="<?php echo htmlspecialchars($email);?>">
            </div>

            <div class="password">
                <input placeholder="Password" type="password" name="pwd" id="pwd" class="inputs">
                <input placeholder="Password Confirmation" type="password" name="pwdConf" id="pwd" class="inputs">
            </div>

            <div class="btns">
                <input type="button" id="login" value="Log In" class="login" onclick="window.location.href='index.php?page=login'">
                <button type="submit" name="signin" id="signin" value="Sign in" class="signin">Sign In</button>
            </div>

            <?php if (!empty($message)): ?>
                <div class="msg"><br><p><?= $message ?></p></div>
            <?php endif; ?>
            <?php if (!empty($messageErr)): ?>
                <div class="msgErr"><br><p><?= $messageErr ?></p></div>
            <?php endif; ?>
        </div>
    </form>
</div>