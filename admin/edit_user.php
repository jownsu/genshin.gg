<?php require_once("includes/header.php"); ?>
<?php


    if((isset($_GET['id']) && $_GET['id'] == $session->id) || $session->role == 'Admin'){
        $user = User::find($_GET['id']);
        if(!$user){
            header("location: users.php");
        }
    }else{
        header("location: users.php");
    }

    if(isset($_POST['update'])){

        if($uUser = User::edit($user, $_POST)){
            if(is_object($uUser)){
                $session->set_message("<p class='green-text'>$uUser->username updated!</p>");
                header("Refresh:0");
            }else{
                $empty_err    = $uUser['error']['empty'] ?? "";
                $email_err    = $uUser['error']['email'] ?? $empty_err;
                $username_err = $uUser['error']['username'] ?? $empty_err;
            }



        }else{
            $session->set_message("<p class='red-text'>There is an error updating the user</p>");
        }
    }

    if(isset($_POST['reset'])){
        $newPass = "pass_" . date("Y");
        $user->set_password($newPass);
        if($user->update()){
            $session->set_message("<p class='green-text'>Password Resetted to $newPass</p>");
        }else{
            $session->set_message("<p class='red-text'>There is an error resetting the password</p>");
        }
    }

    if(isset($_POST['delete'])){
        if($user->delete()){
            $session->set_message("<p class='green-text'> User " . $user->username . " has been deleted </p>");
            header('Location: users.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the user</p>'");
        }
    }
?>

    <div class="add-user-container">
        <h4>Edit user</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col l3 m6 s6">
                            <a href="#modalPhotos" class="modal-trigger"><img class="user-display-picture btnModalImg" data-test="user" src="<?= $user->user_image_path() ?>" alt="pofilepicture"></a>
                        </div>
                        <div class="col l3 m3 offset-l2 s3">
                            <div class="input-field">
                                <select name="status" id="status">
                                    <option value="Active" <?= ( ($_POST['status'] ?? $user->status) == 'Active' ) ? 'selected' : '' ?>>Active</option>
                                    <option value="Inactive" <?= ( ($_POST['status'] ?? $user->status) == 'Inactive' ) ? 'selected' : '' ?>>Inactive</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                            <div class="input-field">
                                <select name="role" id="role">
                                    <option value="User" <?= ( ($_POST['role'] ?? $user->role) == 'User' ) ? 'selected' : '' ?>>User</option>
                                    <option value="Admin" <?= ( ($_POST['role'] ?? $user->role) == 'Admin' ) ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <label for="role">Role</label>
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                        <input type="hidden" name="id" id="targetId" value="<?= $user->user_id ?>">

                        <div class="input-field col l6 s12">
                            <input type="text" id="firstname" name="firstname" value="<?= $_POST['firstname'] ?? $user->firstname ?>" class="<?= ( empty($_POST['firstname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                            <label for="firstname">First Name</label>
                            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                        </div>

                        <div class="input-field col l6 s12">
                            <input type="text" id="lastname" name="lastname" value="<?= $_POST['lastname'] ?? $user->lastname ?>" class="<?= ( empty($_POST['lastname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                            <label for="lastname">Last Name</label>
                            <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                        </div>

                        <div class="input-field col l6 s12">
                            <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? $user->username ?>" class="<?= ( (empty($_POST['username']) && isset($empty_err)) || isset($uUser['error']['username']) ) ? 'invalid' : '' ?>">
                            <label for="username">Username</label>
                            <span class="helper-text" data-error="<?= $username_err ?? '' ?>"></span>
                        </div>
                        
                        <div class="input-field col l6 s12">
                            <input type="text" id="email" name="email" value="<?= $_POST['email'] ?? $user->email ?>" class="<?= ( (empty($_POST['email']) && isset($empty_err)) || isset($uUser['error']['email']) ) ? 'invalid' : '' ?>">
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="<?= $email_err ?? '' ?>"></span>
                        </div>
                        
                        <?php $birthday = $user->get_birthday(); ?>
                        <div class="input-field col l2 s4">
                            <select name="birthday[month]" id="birthday-month">
                                <?php foreach(MONTHS as $month): ?>
                                    <option value="<?= $month ?>" <?= ( ($_POST['birthday']['month'] ?? $birthday[0]) == $month) ? 'selected' : '' ?>><?=  $month ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="release-date-month">Birthday</label>
                        </div>

                        <div class="input-field col l2 s4">
                            <select name="birthday[day]" id="birthday-day">
                                <?php foreach(DAYS as $day): ?>
                                    <option value="<?= $day ?>" <?= ( ($_POST['birthday']['day'] ?? $birthday[1]) == $day) ? 'selected' : '' ?>><?= $day ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="input-field col l2 s4">
                            <select name="birthday[year]" id="birthday-year">
                                <?php foreach(B_YEARS as $year): ?>
                                    <option value="<?= $year ?>" <?= ( ($_POST['birthday']['year'] ?? $birthday[2]) == $year) ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="input-field col l6 s12">
                            <select name="gender" id="gender">
                                <option value="Male" <?= ($_POST['gender'] ?? $user->gender) == 'Male' ? 'Selected' : '' ?>>Male</option>
                                <option value="Female" <?= ($_POST['gender'] ?? $user->gender) == 'Female' ? 'Selected' : '' ?>>Female</option>
                                <option value="Secret" <?= ($_POST['gender'] ?? $user->gender) == 'Secret' ? 'Selected' : '' ?>>Secret</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                            <input type="submit" value="Update" name="update" class="btn-small green">
                            <button data-target="delete-user-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                        <br>
                        <a href="#modalReset" class="modal-trigger btn-small orange" id="btnResetPass">Reset Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalReset" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to reset password </h5>
        </div>
        <div class="modal-footer">
            <form method="POST">
                <input type="submit" value="Reset" name="reset" class="modal-close btn-small red">
                <a href="#!" class="modal-close btn-small blue">No</a>
            </form>
        </div>
    </div>

    <div id="delete-user-modal" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to delete <?= $user->username ?>?</h5>
        </div>
        <div class="modal-footer">
            <form method="POST">
                <input type="submit" value="Delete" name="delete" class="modal-close btn-small red">
                <a href="#!" class="modal-close btn-small blue">No</a>
            </form>
        </div>
    </div>

<script src="js/resetPass.js"></script>
<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php") ?>