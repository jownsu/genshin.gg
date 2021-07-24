<?php require_once("includes/Class/init.php"); ?>

<?php

if($session->is_signed_in()){
    header("location: index.php");
}

if(isset($_POST['submit'])){

    $_POST['status'] = 'Inactive';

    if($user = User::add($_POST)){
        if(is_object($user)){
            $session->set_message("<p class='green-text'>The User Registered. Wait for admin to activate your account.</p>");
            header("Refresh:0");
        }else{
            $empty_err    = $user['error']['empty'] ?? "";
            $email_err    = $user['error']['email'] ?? $empty_err;
            $username_err = $user['error']['username'] ?? $empty_err;
            $password_err = $user['error']['password'] ?? $empty_err;
            $answer_err   = $user['error']['sec_answer'] ?? $empty_err;
        }
    }else{
        $session->set_message("<p class='red-text'>There is an error adding the user</p>");
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

        <div class="signup-container ">
            <h5>Sign Up</h5>
            <form method="POST">
                <div class="row">

                    <div class="input-field col l6 s6">
                        <input type="text" name="firstname" id="firstname" value="<?= $_POST['username'] ?? '' ?>" class="<?= ( empty($_POST['firstname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                        <label for="firstname">Firstname</label>
                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                    </div>
                    
                    <div class="input-field col l6 s6">
                        <input type="text" name="lastname" id="lastname" value="<?= $_POST['lastname'] ?? '' ?>" class="<?= ( empty($_POST['lastname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                        <label for="lastname">Lastname</label>
                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field col l6 s6">
                        <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? '' ?>" class="<?= ( (empty($_POST['username']) && isset($empty_err)) || isset($user['error']['username']) ) ? 'invalid' : '' ?>">
                        <label for="username">Username</label>
                        <span class="helper-text" data-error="<?= $username_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field col l6 s6">
                        <input type="text" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" class="<?= ( (empty($_POST['email']) && isset($empty_err)) || isset($user['error']['email']) ) ? 'invalid' : '' ?>">
                        <label for="email">Email</label>
                        <span class="helper-text" data-error="<?= $email_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field col l6 s6">
                        <input type="password" name="password" id="password" class="<?= ( (empty($_POST['password']) && isset($empty_err)) || isset($user['error']['password']) ) ? 'invalid' : '' ?>">
                        <label for="password">Password</label>
                        <span class="helper-text" data-error="<?= $password_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field col l6 s6">
                        <input type="password" name="confirm_password" id="confirm_password" class="<?= ( (empty($_POST['confirm_password']) && isset($empty_err)) || isset($user['error']['password']) ) ? 'invalid' : '' ?>">
                        <label for="confirm_password">Confirm Password</label>
                        <span class="helper-text" data-error="<?= $password_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field col l12 s12">
                        <select name="security_question" id="security_question">
                            <?php foreach(SECURTY_QUESTIONS as $question): ?>
                                <option value="<?= $question ?>" <?= ( isset($_POST['security_question']) && $_POST['security_question'] == $question ) ? 'selected' : '' ?>><?= $question ?></option>
                            <?php endforeach ?>
                        </select>
                        <label for="security_question">Security Question</label>
                    </div>

                    <div class="input-field col l6 s6">
                        <input type="password" id="security_answer" name="security_answer" class="<?= ( (empty($_POST['security_answer']) && isset($empty_err)) || isset($user['error']['sec_answer']) ) ? 'invalid' : '' ?>">
                        <label for="security_answer">Security Answer</label>
                        <span class="helper-text" data-error="<?= $answer_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field col l6 s6">
                        <input type="password" id="confirm_security_answer" name="confirm_security_answer" class="<?= ( (empty($_POST['confirm_security_answer']) && isset($empty_err)) || isset($user['error']['sec_answer']) ) ? 'invalid' : '' ?>">
                        <label for="confirm_security_answer">Confirm Security Answer</label>
                        <span class="helper-text" data-error="<?= $answer_err ?? '' ?>"></span>
                    </div>


                    <?= $session->message ?? ""?>
                    <div class="col s12">
                        <input type="submit" value="Sign Up" name="submit" class="btn-small blue darken-2">
                        <p>Already Have an Account? <a href="login.php">Log in</a></p>
                    </div>

            </div>
            </form>
        </div>

</main>

<script src="js/scripts.js"></script>
<script src="js/material-inits.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</body>
</html>