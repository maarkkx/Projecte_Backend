<div class="loginform">
    <form method="post" action="index.php?page=login">
        <h1>Log In</h1><br>
        <input placeholder="Username" type="text" name="user" id="user" class="user" value="<?php echo htmlspecialchars($user);?>"/><br><br>
        <input placeholder="Password" type="password" name="pwd" id="pwd" class="pwd"><br><br>

        <button type="submit" name="login" id="login" class="login">Log In</button>
        <input type="button" id="signin" value="Sign in" class="signin" onclick="window.location.href='index.php?page=signin'">
        
        <?php if (!empty($message)): ?>
            <div class="msg"><br><p><?= $message ?></p></div>
        <?php endif; ?>
    </form>
</div>