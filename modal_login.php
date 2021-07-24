<div id="login_modal" class="modal modalLogin">
    <div class="modal-content">
        <div class="loginform">
            <div class="logo"></div>
            <h5>Log In</h5>
            <div class="closeLogin"><i class="material-icons">close</i></div>
            <form action="<?= "admin/login.php?location=".urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" method="POST">
                
                <div class="input-field">
                    <i class="material-icons prefix">account_circle</i>  
                    <input type="text" id="username" name="username" value="">
                    <label for="username">Username</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">lock</i>
                    <input type="password" id="password" name="password">
                    <label for="password">Password</label>
                </div>
                <a href="admin/forgotpassword.php" class="forgotpass">Forgot Password</a>

                <input type="submit" value="login" class="btn-small blue darken-2 btnLogin" name="submit-login">
            </form>
            <p>Don't have an account? <a href="admin/signup.php">Sign up</a></p> 

        </div>
    </div>
</div>