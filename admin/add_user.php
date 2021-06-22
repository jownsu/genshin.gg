<?php require_once("includes/header.php"); ?>
<?php
    if(isset($_POST['submit'])){

        $firstname                = trim($_POST['firstname']);
        $lastname                 = trim($_POST['lastname']);
        $username                 = trim($_POST['username']);
        $password                 = trim($_POST['password']);
        $email                    = trim($_POST['email']);
        $birthday_month           = trim($_POST['birthday-month']);
        $birthday_day             = trim($_POST['birthday-day']);
        $birthday_year            = trim($_POST['birthday-year']);
        $gender                   = $_POST['gender'];
        $confirm_password         = trim($_POST['confirm-password']);
        $security_question        = trim($_POST['security-question']);
        $security_answer          = trim($_POST['security-answer']);
        $confirm_security_answer  = trim($_POST['confirm-security-answer']);
        $status                   = $_POST['status'];
        $role                     = $_POST['role'];

        if(empty($username) || empty($password) || empty($firstname) || empty($lastname) || empty($security_answer) || empty($email)){
            $session->set_message("<p class='red-text'>Fields cannot be empty</p>");
        }else{
            if($password != $confirm_password){
                $session->set_message("<p class='red-text'>Password not match</p>");
            }elseif($security_answer != $confirm_security_answer){
                $session->set_message("<p class='red-text'>Security answer not match</p>");
            }else{
                
                if($user = User::add($_POST)){
                    $session->set_message("<p class='green-text'> User $user->username Added </p>");
                    header('location: users.php');
                }else{
                    $session->set_message("<p class='red-text'>There is an error adding the user</p>");
                }

            }

        }
    }else{
        $firstname = "";
        $lastname = "";
        $username = "";
        $email = "";
    }
?>

    <div class="add-user-container">
        <h4>Add user</h4>
        <form method="POST">
            <div class="row">
                <div class="input-field col l6 s12">
                    <input type="text" id="firstname" name="firstname" value="<?= $firstname ?>">
                    <label for="firstname">First Name</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="text" id="lastname" name="lastname" value="<?= $lastname ?>">
                    <label for="lastname">Last Name</label>
                </div>
                
                <div class="input-field col l2 s4">
                    <select name="birthday[month]" id="birthday-month">
                        <?php foreach(MONTHS as $month): ?>
                            <option value="<?= $month ?>"><?=  $month ?></option>
                        <?php endforeach ?>
                    </select>
                    <label for="birthday-month">Birthday</label>
                </div>

                <div class="input-field col l2 s4">
                    <select name="birthday[day]" id="birthday-day">
                        <?php foreach(DAYS as $day): ?>
                            <option value="<?= $day ?>"><?= $day ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="input-field col l2 s4">
                    <select name="birthday[year]" id="birthday-year">
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

                <div class="input-field col l6 s12">
                    <select name="role" id="role">
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <label for="role">Role</label>
                </div>

                <div class="input-field col l6 s12">
                    <select name="status" id="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="status">Status</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="text" id="username" name="username" value="<?= $username ?>">
                    <label for="username">Username</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="text" id="email" name="email" value="<?= $email ?>">
                    <label for="email">Email</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="password" id="password" name="password">
                    <label for="password">Password</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="password" id="confirm-password" name="confirm-password">
                    <label for="confirm-password">Confirm Password</label>
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
    
                <input type="submit" value="Submit" name="submit" class="btn-small green">
            </div>
        </form>
    </div>


<?php require_once("includes/footer.php"); ?>
