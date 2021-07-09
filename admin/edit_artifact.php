<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_GET['id'])){
        $artifact = Artifact::find($_GET['id']);
        if(!$artifact){
            header("location: artifacts.php");
        }
    }else{
        header("location: artifacts.php");
    }

    if(isset($_POST['update'])){

        if($uArtifact = Artifact::edit($artifact, $_POST)){
            if(is_object($uArtifact)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$uArtifact->upload($_FILES['icon'], 'icon') ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $uArtifact->errors) . "</p>");
                    } 
                 }

                $session->set_message("<p class='green-text'>Artifact $uArtifact->name updated!</p>");
                header("Refresh: 0");
            }else{
                $empty_err   = $uArtifact['error']['empty'] ?? "";
                $name_err    = $uArtifact['error']['name'] ?? $empty_err;
            }
        }else{
            $session->set_message("<p class='green-text'>There was an error updating the artifact</p>");
        }
    }

    if(isset($_POST['delete'])){
        if($artifact->delete_artifact()){
            $session->set_message("<p class='green-text'> Artifact " . $artifact->name . " has been deleted </p>");
            header('Location: artifacts.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the artifact</p>'");
        }
    }

?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Edit Artifact</h4>

                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?? $artifact->name ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($uArtifact['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="max_rarity" name="max_rarity">
                                    <option value="1" <?= ( ($_POST['max_rarity'] ?? $artifact->max_rarity) == '1' ) ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= ( ($_POST['max_rarity'] ?? $artifact->max_rarity) == '2' ) ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= ( ($_POST['max_rarity'] ?? $artifact->max_rarity) == '3' ) ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= ( ($_POST['max_rarity'] ?? $artifact->max_rarity) == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( ($_POST['max_rarity'] ?? $artifact->max_rarity) == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Max Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="two_piece_bonus" name="two_piece_bonus" value="<?= $_POST['two_piece_bonus'] ?? $artifact->two_piece_bonus ?>" class="<?= ( empty($_POST['two_piece_bonus']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="two_piece_bonus">Two Piece Bonus</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="four_piece_bonus" name="four_piece_bonus" value="<?= $_POST['four_piece_bonus'] ?? $artifact->four_piece_bonus ?>" class="<?= ( empty($_POST['four_piece_bonus']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="four_piece_bonus">Four Piece Bonus</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>
 
                            <div class="col l6 s12">
                                <img class="edit-thumbnail" src="<?= $artifact->artifact_img() ?>" alt="<?= $artifact->name ?>">
                                <div class="file-field input-field">
                                        <div class="btn">
                                            <span>Icon</span>
                                            <input type="file" name="icon">
                                        </div>
                                    <div class="file-path-wrapper">
                                        <input type="text" class="file-path validate" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="input-field col l12">
                                <input type="submit" value="Update" name="update" class="btn-small green">
                                <button data-target="delete-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                            </div>



                        </div>
                </form>

            </div>
        </div>
    </div>

    <div id="delete-modal" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to delete <?= $artifact->name ?>?</h5>
        </div>
        <div class="modal-footer">
            <form method="POST">
                <input type="submit" value="Delete" name="delete" class="modal-close btn-small red">
                <a href="#!" class="modal-close btn-small blue">No</a>
            </form>
        </div>
    </div>
    
<script src="js/addMoreSkill.js"> </script>
<?php 

require_once("includes/footer.php"); 

?>
