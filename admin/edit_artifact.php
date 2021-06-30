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

            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                if( !$artifact->upload($_FILES['icon'], 'icon') ){
                    //  print_r($artifact->errors);
                     $session->set_message("<p class='red-text'>" . implode("<br>", $artifact->errors) . "</p>");
                } 
             }
            // header("location: characters.php");

            $session->set_message("<p class='green-text'>Artifact $uArtifact->name updated!</p>");
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
                                <input type="text" id="name" name="name" value="<?= $artifact->name ?>">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="max_rarity" name="max_rarity">
                                    <option value="1" <?= $artifact->max_rarity == '1' ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= $artifact->max_rarity == '2' ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= $artifact->max_rarity == '3' ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= $artifact->max_rarity == '4' ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= $artifact->max_rarity == '5' ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Max Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="two_piece_bonus" name="two_piece_bonus" value="<?= $artifact->two_piece_bonus ?>">
                                <label for="two_piece_bonus">Two Piece Bonus</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="four_piece_bonus" name="four_piece_bonus" value="<?= $artifact->four_piece_bonus ?>">
                                <label for="four_piece_bonus">Four Piece Bonus</label>
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
                                <button data-target="delete-char-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                            </div>



                        </div>
                </form>

            </div>
        </div>
    </div>

<script src="js/addMoreSkill.js"> </script>
<?php 

require_once("includes/footer.php"); 

?>
