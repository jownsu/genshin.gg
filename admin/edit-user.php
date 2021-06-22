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
        $username          = trim($_POST['username']);
        $firstname         = trim($_POST['firstname']);
        $lastname          = trim($_POST['lastname']);
        $email             = trim($_POST['email']);
        $birthday_month    = trim($_POST['birthday-month']);
        $birthday_day      = trim($_POST['birthday-day']);
        $birthday_year     = trim($_POST['birthday-year']);
        $gender            = $_POST['gender'];
        $role              = $_POST['role'];
        $status            = $_POST['status'];

        $user->username           = $username;
        $user->firstname          = $firstname;
        $user->lastname           = $lastname;
        $user->email              = $email;
        $user->gender             = $gender;
        $user->set_birthday($birthday_month, $birthday_day, $birthday_year);
        $user->status             = $status;
        $user->role               = $role;

        if($user->update()){
            header("location: users.php");
            $session->set_message("<p class='green-text'>User updated!</p>");
        }else{
            $session->set_message("<p class='red-text'>There is an error updating the user</p>");
        }
    }

    if(isset($_POST['reset'])){
        $user->set_password($user->username);
        if($user->update()){
            $session->set_message("<p class='green-text'>Password Resetted to his/her username</p>");
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
                                    <option value="Active">Active</option>
                                    <option value="Inactive" <?= $user->status == 'Inactive' ? 'selected' : ''?>>Inactive</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                            <div class="input-field">
                                <select name="role" id="role">
                                    <option value="User">User</option>
                                    <option value="Admin" <?= $user->role == 'Admin' ? 'selected' : ''?>>Admin</option>
                                </select>
                                <label for="role">Role</label>
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                        <input type="hidden" name="id" id="targetId" value="<?= $user->user_id ?>">

                        <div class="input-field col l6 s12">
                            <input type="text" id="firstname" name="firstname" value="<?= $user->firstname ?>">
                            <label for="firstname">First Name</label>
                        </div>

                        <div class="input-field col l6 s12">
                            <input type="text" id="lastname" name="lastname" value="<?= $user->lastname ?>">
                            <label for="lastname">Last Name</label>
                        </div>

                        <div class="input-field col l6 s12">
                            <input type="text" id="username" name="username" value="<?= $user->username ?>">
                            <label for="username">Username</label>
                        </div>
                        
                        <div class="input-field col l6 s12">
                            <input type="text" id="email" name="email" value="<?= $user->email ?>">
                            <label for="email">Email</label>
                        </div>
                        
                        <?php $birthday = $user->get_birthday(); ?>
                        <div class="input-field col l2 s4">
                            <select name="birthday-month" id="birthday-month">
                                <?php foreach(MONTHS as $month): ?>
                                    <option value="<?= $month ?>" <?= $month == $birthday[0] ? 'Selected' : '' ?>><?=  $month ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="release-date-month">Birthday</label>
                        </div>

                        <div class="input-field col l2 s4">
                            <select name="birthday-day" id="birthday-day">
                                <?php foreach(DAYS as $day): ?>
                                    <option value="<?= $day ?>" <?= $day == $birthday[1] ? 'Selected' : '' ?>><?= $day ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="input-field col l2 s4">
                            <select name="birthday-year" id="birthday-year">
                                <?php foreach(B_YEARS as $year): ?>
                                    <option value="<?= $year ?>" <?= $year == $birthday[2] ? 'Selected' : '' ?>><?= $year ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="input-field col l6 s12">
                            <select name="gender" id="gender">
                                <option value="Male" <?= $user->gender == 'Male' ? 'Selected' : '' ?>>Male</option>
                                <option value="Female" <?= $user->gender == 'Female' ? 'Selected' : '' ?>>Female</option>
                                <option value="Secret" <?= $user->gender == 'Secret' ? 'Selected' : '' ?>>Secret</option>
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