<?php require_once __DIR__ . '/../../config/recaptcha.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="loginform">
    <form class="form" method="post" action="index.php?page=login">
        <h1>Log In</h1>
        <?php if (!empty($message)): ?>
            <div class="msg"><br><p><?= $message ?></p></div>
        <?php endif; ?>
        <?php if (!empty($messageErr)): ?>
            <div class="msgErr"><br><p><?= $messageErr ?></p></div>
        <?php endif; ?>
        <!-- USER -->
        <div class="flex-column">
            <label for="user">User</label>
        </div>
        <div class="inputForm">
            <input type="text" id="user" name="user"
                   class="input" placeholder="Enter your User">
        </div>

        <!-- PASSWORD -->
        <div class="flex-column">
            <label for="pwd">Password</label>
        </div>
        <div class="inputForm">
            <input type="password" id="pwd" name="pwd" class="input" placeholder="Enter your Password">
        </div>

        <div class="flex-row between">
            <div>
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <span class="link">Forgot password?</span>
        </div>
        <?php if (($_SESSION['login_fails'] ?? 0) >= 3): ?>
            <div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>"></div>
        <?php endif; ?>
        <button type="submit" name="login" class="button-submit">Log In</button>

        <p class="p">Don't have an account? <input style="border: none; color: blue; background-color: transparent; cursor: pointer;" type="button" value="Sign in"  onclick="window.location.href='index.php?page=signin'"></p>

        <p class="p line">Or With</p>

        <div class="flex-row">
            <button type="button" class="btn google">
                <svg version="1.1" width="20" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path style="fill:#FBBB00;"
                        d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
                        c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644
                        c-5.317,15.501-8.215,32.141-8.215,49.456C103.821,274.792,107.225,292.797,113.47,309.408z"></path>
                    <path style="fill:#518EF8;"
                        d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
                        c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
                        c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176Z"></path>
                    <path style="fill:#28B446;"
                        d="M416.253,455.624C372.396,490.901,316.666,512,256,512
                        c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
                        c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"></path>
                    <path style="fill:#F14336;"
                        d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
                        c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
                        C318.115,0,375.068,22.126,419.404,58.936z"></path>
                </svg>
                Google
            </button>
        </div>

    </form>
</div>
