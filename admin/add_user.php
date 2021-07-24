<?php require_once("includes/header.php"); ?>
<?php
    if(isset($_POST['submit'])){

        if($user = User::add($_POST)){
            if(is_object($user)){
                $session->set_message("<p class='green-text'> $user->role $user->username  was added </p>");
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

    <div class="add-user-container">
        <h4>Add user</h4>
        <form method="POST">
            <div class="row">
                <div class="input-field col l6 s12">
                    <input type="text" id="firstname" name="firstname" value="<?= $_POST['firstname'] ?? '' ?>" class="<?= ( empty($_POST['firstname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                    <label for="firstname">First Name</label>
                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l6 s12">
                    <input type="text" id="lastname" name="lastname" value="<?= $_POST['lastname'] ?? '' ?>" class="<?= ( empty($_POST['lastname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                    <label for="lastname">Last Name</label>
                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l6 s12">
                    <select name="role" id="role">
                        <option value="User"  <?= ( isset($_POST['role']) && $_POST['role'] == 'User' ) ? 'selected' : '' ?>>User</option>
                        <option value="Admin" <?= ( isset($_POST['role']) && $_POST['role'] == 'Admin' ) ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <label for="role">Role</label>
                </div>

                <div class="input-field col l6 s12">
                    <select name="status" id="status">
                        <option value="Active"   <?= ( isset($_POST['status']) && $_POST['status'] == 'Active' ) ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= ( isset($_POST['status']) && $_POST['status'] == 'Inactive' ) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    <label for="status">Status</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>" class="<?= ( (empty($_POST['username']) && isset($empty_err)) || isset($user['error']['username']) ) ? 'invalid' : '' ?>">
                    <label for="username">Username</label>
                    <span class="helper-text" data-error="<?= $username_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l6 s12">
                    <input type="text" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" class="<?= ( (empty($_POST['email']) && isset($empty_err)) || isset($user['error']['email']) ) ? 'invalid' : '' ?>">
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="<?= $email_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l6 s12">
                    <input type="password" id="password" name="password" value="<?= $_POST['password'] ?? '' ?>" class="<?= ( (empty($_POST['password']) && isset($empty_err)) || isset($user['error']['password']) ) ? 'invalid' : '' ?>">
                    <label for="password">Password</label>
                    <span class="helper-text" data-error="<?= $password_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l6 s12">
                    <input type="password" id="confirm-password" name="confirm_password" value="<?= $_POST['confirm_password'] ?? '' ?>" class="<?= ( (empty($_POST['confirm_password']) && isset($empty_err)) || isset($user['error']['password']) ) ? 'invalid' : '' ?>">
                    <label for="confirm-password">Confirm Password</label>
                    <span class="helper-text" data-error="<?= $password_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l12 s12">
                    <select name="security_question" id="security-question">
                        <?php foreach(SECURTY_QUESTIONS as $question): ?>
                            <option value="<?= $question ?>" <?= ( isset($_POST['security_question']) && $_POST['security_question'] == $question ) ? 'selected' : '' ?> ><?= $question ?></option>
                        <?php endforeach ?>
                    </select>
                    <label for="security-question">Security Question</label>
                </div>

                <div class="input-field col l6 s12">
                    <input type="password" id="security-answer" name="security_answer" value="<?= $_POST['security_answer'] ?? '' ?>" class="<?= ( (empty($_POST['security_answer']) && isset($empty_err)) || isset($user['error']['sec_answer']) ) ? 'invalid' : '' ?>">
                    <label for="security-answer">Security Answer</label>
                    <span class="helper-text" data-error="<?= $answer_err ?? '' ?>"></span>
                </div>

                <div class="input-field col l6 s12">
                    <input type="password" id="confirm-security-answer" name="confirm_security_answer" value="<?= $_POST['confirm_security_answer'] ?? '' ?>" class="<?= ( (empty($_POST['confirm_security_answer']) && isset($empty_err)) || isset($user['error']['sec_answer']) ) ? 'invalid' : '' ?>">
                    <label for="confirm-security-answer">Confirm Security Answer</label>
                    <span class="helper-text" data-error="<?= $answer_err ?? '' ?>"></span>
                </div>
    
                <input type="submit" value="Submit" name="submit" class="btn-small green">
            </div>
        </form>
    </div>


<?php require_once("includes/footer.php"); ?>
