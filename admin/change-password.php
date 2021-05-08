<?php require_once("includes/header.php"); ?>
<?php


    if(isset($session->id)){
        $user = User::find_by_id($session->id);
        if(!$user){
            header("location: index.php");
        }
    }else{
        header("location: index.php");
    }

    if(isset($_POST['update'])){
        $current_password = trim($_POST['current-password']);
        $new_password     = trim($_POST['new-password']);
        $confirm_password = trim($_POST['confirm-password']);
        
        if((!password_verify($current_password, $user->password)) || ($new_password != $confirm_password)){
            $session->set_message("<p class='red-text'>Password not match</p>");
        }else{
            $user->set_password($new_password);

            if($user->update()){
                $session->set_message("<p class='green-text'>Password updated!</p>");
            }else{
                $session->set_message("<p class='red-text'>There is an error updating the password</p>");
            }
        }
    }
?>

    <div class="container">
        <h4>Change Password</h4>
                <form method="POST">
                        <div class="input-field">
                            <input type="password" id="current-password" name="current-password">
                            <label for="current-password">Current Password</label>
                        </div>

                        <div class="input-field">
                            <input type="password" id="new-password" name="new-password">
                            <label for="new-password">New Password</label>
                        </div>

                        <div class="input-field">
                            <input type="password" id="confirm-password" name="confirm-password">
                            <label for="confirm-password">Confirm Password</label>
                        </div>
                        <input type="submit" value="Change Password" name="update" class="btn-small green">
                </form>
            </div>
        </div>
    </div>

<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php") ?>