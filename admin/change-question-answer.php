<?php require_once("includes/header.php"); ?>
<?php


    if(isset($session->id)){
        $user = User::find($session->id);
        if(!$user){
            header("location: index.php");
        }
    }else{
        header("location: index.php");
    }

    if(isset($_POST['update'])){
        $security_question = trim($_POST['security-question']);
        $security_answer   = trim($_POST['new-answer']);
        $confirm_password  = trim($_POST['confirm-password']);

        if(!password_verify($confirm_password, $user->password)){
            $session->set_message("<p class='red-text'>Password not match</p>");
        }else{
            $user->security_question = $security_question;
            $user->set_security_answer($security_answer);

            if($user->update()){
                $session->set_message("<p class='green-text'>Security Question/Answer updated!</p>");
            }else{
                $session->set_message("<p class='red-text'>There is an error updating the security question/answer</p>");
            }
        }
    }
?>

    <div class="container">
        <h4>Change Question/Answer</h4>
                <form method="POST">
                        <div class="input-field col l12 s12">
                            <select name="security-question" id="security-question">
                                <?php foreach(SECURTY_QUESTIONS as $question): ?>
                                    <option value="<?= $question ?>" <?= $question == $user->security_question ? 'selected' : '' ?>><?= $question ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="security-question">Security Question</label>
                        </div>

                        <div class="input-field">
                            <input type="password" id="new-answer" name="new-answer">
                            <label for="new-answer">New Security Answer</label>
                        </div>

                        <div class="input-field">
                            <input type="password" id="confirm-password" name="confirm-password">
                            <label for="confirm-password">Confirm Password</label>
                        </div>
                        <input type="submit" value="Change Security Question/Answer" name="update" class="btn-small green">
                </form>
            </div>
        </div>
    </div>

<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php") ?>