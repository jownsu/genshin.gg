<?php require_once("includes/Class/init.php"); ?>

<?php

if($session->is_signed_in()){
    header("location: index.php");
}

if(isset($_POST['submit-login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::verify_user($username, $password);

    if($user){
        if($user->status != 'Active'){
            $session->set_message("<p class='red-text'>Your Account is currently not active</p>");
        }else{
            $session->login($user);
            if(isset($_GET['location'])){
                header("location:". $_GET['location']);
            }else{
                header("location: index.php");
            }
        }


    }else{
        $session->set_message("<p class='red-text'>Incorrect Username or Password</p>");
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>

<main>
    <a href="../index.php"><img src="images/genshin-logo.svg" class="logoHome" alt="logo"></a>

    <div class="bgShape"></div>

    <div class="wrapper">
        <img src="images/Paimon.png" alt="Paimon" class="paimon hide-on-med-and-down">
        <div class="login-container">
            <div class="loginform">
                <!-- <img src="images/logo.png" alt="logo" class="logo"> -->
                <div class="logo"></div>
                <h5>Log In</h5>
                <form method="POST">
                    <div class="input-field">
                        <i class="material-icons prefix">account_circle</i>  
                        <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>">
                        <label for="username">Username</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">lock</i>
                        <input type="password" id="password" name="password">
                        <label for="password">Password</label>
                    </div>
                    <a href="forgotpassword.php" class="forgotpass">Forgot Password</a>

                    <p class="red-text"><?= $session->message ?? ""?></p>
                    <input type="submit" value="login" class="btn blue darken-2 btnLogin" name="submit-login">
                </form>
                <p> Don't have an account? <a href="signup.php" class="signup">Sign up</a> </p>
            </div>
        </div>

    </div>

</main>

<script src="js/scripts.js"></script>
<script src="js/material-inits.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</body>
</html>