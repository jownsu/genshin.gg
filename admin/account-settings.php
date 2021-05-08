<?php require_once("includes/header.php"); ?>
<?php


    if((isset($_GET['id']) && $_GET['id'] == $session->id) || $session->role == 'Admin'){
        $user = User::find_by_id($_GET['id']);
        if(!$user){
            header("location: index.php");
        }
    }else{
        header("location: index.php");
    }
        if(isset($_POST['update'])){
        $firstname         = trim($_POST['firstname']);
        $lastname          = trim($_POST['lastname']);
        $username          = trim($_POST['username']);
        $confirm_password  = trim($_POST['confirm-password']);

        if($confirm_password != $user->password){
            $session->set_message("<p class='red-text'>Invalid Password</p>");
        }else{
            $user->username           = $username;
            $user->firstname          = $firstname;
            $user->lastname           = $lastname;
    
            if($user->update()){
                header("Reload:0");
                $session->set_message("<p class='green-text'>User updated!</p>");
            }else{
                $session->set_message("<p class='red-text'>There is an error updating the user</p>");
            }
        }
    }
?>

    <div class="container">
        <h4>Account Settings</h4>
                <form method="POST">
                    <div class="row valign-wrapper">
                        <div class="col l3">
                            <a href="#modalPhotos" class="modal-trigger"><img class="user-display-picture btnModalImg" data-test="user" src="<?= $user->user_image_path() ?>" alt="pofilepicture"></a>
                        </div>
                        <div class="col l9">
                            <a href="change-password.php">Change Password</a><br>
                            <a href="change-question-answer.php">Change Security Question/Answer</a>
                        </div>                    
                    </div>
                    <div class="row">
                        <input type="hidden" name="id" id="targetId" value="<?= $user->id ?>">

                        <div class="input-field col l6 s12">
                            <input type="text" id="firstname" name="firstname" value="<?= $user->firstname ?>">
                            <label for="firstname">First Name</label>
                        </div>

                        <div class="input-field col l6 s12">
                            <input type="text" id="lastname" name="lastname" value="<?= $user->lastname ?>">
                            <label for="lastname">Last Name</label>
                        </div>

                        <div class="input-field col l12 s12">
                            <input type="text" id="username" name="username" value="<?= $user->username ?>">
                            <label for="username">Username</label>
                        </div>

                        <div class="input-field col l12 s12">
                            <input type="password" id="confirm-password" name="confirm-password">
                            <label for="confirm-password">Confirm Pasword</label>
                        </div>
                            <input type="submit" value="Update" name="update" class="btn-small green">
                            <input type="hidden" name="userId" value="<?= $user->id ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php") ?>