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
}else{
    $username = "";
    $password = "";
    $email = "";
}

if(isset($_POST['submit-signup'])){
    $firstname                = trim($_POST['firstname']);
    $lastname                 = trim($_POST['lastname']);
    $username                 = trim($_POST['r-username']);
    $password                 = trim($_POST['r-password']);    
    $confirm_password         = trim($_POST['confirm-password']);
    $email                    = trim($_POST['email']);
    $birthday_month           = $_POST['birthday-month'];
    $birthday_day             = $_POST['birthday-day'];
    $birthday_year            = $_POST['birthday-year'];
    $gender                   = $_POST['gender'];
    $security_question        = trim($_POST['security-question']);
    $security_answer          = trim($_POST['security-answer']);
    $confirm_security_answer  = trim($_POST['confirm-security-answer']);

    if(empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirm_password)){
        $session->set_message("<p class='red-text'>Fields cannot be empty</p>");
    }else{
        if($password != $confirm_password){
            $session->set_message("<p class='red-text'>Password not match</p>");
        }elseif($security_answer != $confirm_security_answer){
            $session->set_message("<p class='red-text'>Security answer not match</p>");
        }else{
            $user = new User();
    
            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->username = $username;
            $user->set_password($password); 
            $user->email              = $email;
            $user->gender             = $gender;
            $user->set_birthday($birthday_month, $birthday_day, $birthday_year);
            $user->security_question = $security_question;
            $user->set_security_answer($security_answer);
            $user->role = "User";
            $user->status = "Inactive";
    
            if($user->create()){
                $session->set_message("<p class='green-text'>The User Registered. Wait for admin to activate your account.  </p>");
            }else{
                $session->set_message("<p class='red-text'>There was an Error creating the user</p>");
            }
        }
    }
}else{
    $firstname = "";
    $lastname = "";
    $email = "";
}

if(isset($_POST['submit-changepassword'])){
    $username          = $_POST['username'];
    $security_question = $_POST['security_question'];
    $security_answer   = $_POST['security_answer'];
    $new_password      = $_POST['new_password'];
    $confirm_password  = $_POST['confirm_password'];

    if(empty($username) || empty($security_question) || empty($security_answer) || empty($new_password) || empty($confirm_password)){
        $session->set_message("<p class='red-text'>Fields cannot be empty</p>");
    }else{
        if($new_password != $confirm_password){
            $session->set_message("<p class='red-text'>Password not match</p>");
        }else{
            $user = User::find_forgotten_user($username, $security_question, $security_answer);

            if($user){
                $user->set_password($new_password);
                if($user->update()){
                    $session->set_message("<p class='green-text'>Password changed successfully</p>");
                    header("Location: login.php");
                }
            }else{
                $session->set_message("<p class='red-text'>Information of User not match</p>");
            }
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
        <div class="login-container <?= (isset($_GET['signup']) || isset($_GET['forgotpassword'])) ? 'hide' : ''?>">
            <div class="loginform">
                <!-- <img src="images/logo.png" alt="logo" class="logo"> -->
                <div class="logo"></div>
                <h5>Log In</h5>
                <form method="POST">
                    <div class="input-field">
                        <i class="material-icons prefix">account_circle</i>  
                        <input type="text" id="username" name="username" value="<?= $username ?>">
                        <label for="username">Username</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">lock</i>
                        <input type="password" id="password" name="password">
                        <label for="password">Password</label>
                    </div>
                    <p class="red-text"><?= $session->message[0] ?? ""?></p>
                    <input type="submit" value="login" class="btn blue darken-2 btnLogin" name="submit-login">
                </form>
                <a href="login.php?forgotpassword" class="forgotpass">Forgot Password</a>
                <a href="login.php?signup" class="toggleForm btn-small green darken-2">Sign up</a>
            </div>
        </div>

        <div class="signup-container <?= isset($_GET['signup']) ? '' : 'hide'?>">
            <h5>Sign Up</h5>
            <form method="POST">
                <div class="row">

                    <div class="input-field col l6">
                        <input type="text" name="firstname" id="firstname" value="<?= $firstname ?>">
                        <label for="firstname">Firstname</label>
                    </div>
                    
                    <div class="input-field col l6">
                        <input type="text" name="lastname" id="lastname" value="<?= $lastname ?>">
                        <label for="lastname">Lastname</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input type="text" name="r-username" id="r-username" value="<?= $username ?>">
                        <label for="r-username">Username</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input type="text" id="email" name="email" value="<?= $email ?>">
                        <label for="email">Email</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input type="password" name="r-password" id="r-password">
                        <label for="r-password">Password</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input type="password" name="confirm-password" id="confirm-password">
                        <label for="confirm-password">Confirm Password</label>
                    </div>

                    <div class="input-field col l2 s4">
                        <select name="birthday-month" id="birthday-month">
                            <?php foreach(MONTHS as $month): ?>
                                <option value="<?= $month ?>"><?=  $month ?></option>
                            <?php endforeach ?>
                        </select>
                        <label for="release-date-month">Birthday</label>
                    </div>

                    <div class="input-field col l2 s4">
                        <select name="birthday-day" id="birthday-day">
                            <?php foreach(DAYS as $day): ?>
                                <option value="<?= $day ?>"><?= $day ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="input-field col l2 s4">
                        <select name="birthday-year" id="birthday-year">
                            <?php foreach(B_YEARS as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="input-field col l6 s12">
                        <select name="gender" id="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Secret">Secret</option>
                        </select>
                        <label for="gender">Gender</label>
                    </div>

                    <div class="input-field col l12 s12">
                        <select name="security-question" id="security-question">
                            <?php foreach(SECURTY_QUESTIONS as $question): ?>
                                <option value="<?= $question ?>"><?= $question ?></option>
                            <?php endforeach ?>
                        </select>
                        <label for="security-question">Security Question</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input type="password" id="security-answer" name="security-answer">
                        <label for="security-answer">Security Answer</label>
                    </div>

                    <div class="input-field col l6 s12">
                        <input type="password" id="confirm-security-answer" name="confirm-security-answer">
                        <label for="confirm-security-answer">Confirm Security Answer</label>
                    </div>


                    <?= $session->message[0] ?? ""?>

                    <input type="submit" value="Sign Up" name="submit-signup" class="btn-small blue darken-2">
                    <p>Already Have an Account? <a href="login.php">Log in</a></p>
            </div>
            </form>
        </div>

            <div class="forgot-password-container <?= isset($_GET['forgotpassword']) ? '' : 'hide'?>">
                <h5>Forgot Password</h5>
                <form method="POST">
                    <div class="input-field">
                        <input type="text" id="username" name="username" value="<?= $username ?>">
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
                    <p class="red-text"><?= $session->message[0] ?? "" ?></p>
                    <input type="submit" value="Change Password" class="btn blue darken-2 btnLogin" name="submit-changepassword">
                    <a href="login.php">Login</a>
                </form>
            </div>
        </div>

</main>

<script src="js/scripts.js"></script>
<script src="js/material-inits.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
</body>
</html>