<?php require_once("includes/Class/init.php"); ?>

<?php

if($session->is_signed_in()){
    header("location: index.php");
}

if(isset($_POST['submit'])){
    $username          = $_POST['username'];
    $security_question = $_POST['security_question'];
    $security_answer   = $_POST['security_answer'];
    $new_password      = $_POST['new_password'];
    $confirm_password  = $_POST['confirm_password'];

    if(empty($username) || empty($security_question) || empty($security_answer) || empty($new_password) || empty($confirm_password)){
        $session->set_message("<p class='red-text'>Fields cannot be empty</p>");
    }else{
        $user = User::find_forgotten_user($username, $security_question, $security_answer);

        if($user){
            if($new_password != $confirm_password){
                $session->set_message("<p class='red-text'>Password not match</p>");
            }else{
                $user->set_password($new_password);
                if($user->update()){
                    $session->set_message("<p class='green-text'>Password changed successfully</p>");
                    header("Refresh:0");
                }
            }
        }else{
            $session->set_message("<p class='red-text'>Information of User not match</p>");
        }
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

        <div class="forgot-password-container">
            <h5>Forgot Password</h5>
            <form method="POST">
                <div class="input-field">
                    <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>">
                    <label for="username">Username</label>
                </div>
                <div class="input-field">
                    <select name="security_question" id="sq">
                    <?php foreach(SECURTY_QUESTIONS as $sq): ?>
                        <option value="<?= $sq ?>"><?= $sq ?></option>
                    <?php endforeach ?>
                    </select>
                    <label for="sq">Security Question</label>
                </div>
                <div class="input-field">
                    <input type="password" name="security_answer" id="security_answer">
                    <label for="security_answer">Security Answer</label>
                </div>
                <div class="input-field">
                    <input type="password" name="new_password" id="new_password">
                    <label for="new_password">New Password</label>
                </div>
                <div class="input-field">
                    <input type="password" name="confirm_password" id="confirm_password">
                    <label for="confirm_password">Confirm Password</label>
                </div>
                <p class="red-text"><?= $session->message ?? "" ?></p>
                <input type="submit" value="Change Password" class="btn blue darken-2 btnLogin" name="submit">
                <p>Already Have an Account? <a href="login.php">Log in</a></p>
            </form>
        </div>

    </div>

</main>

<script src="js/scripts.js"></script>
<script src="js/material-inits.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</body>
</html>