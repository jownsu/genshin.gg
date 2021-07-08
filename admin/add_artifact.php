<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){

        if($artifact = Artifact::add($_POST)){
            if(is_object($artifact)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$artifact->upload($_FILES['icon'], 'icon') ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $artifact->errors) . "</p>");
                    } 
                 }
                 $session->set_message("<p class='green-text'> Artifact $artifact->name was Added </p>");
            }else{
                $empty_err   = $artifact['error']['empty'] ?? "";
                $name_err    = $artifact['error']['name'] ?? $empty_err;
            }



        }else{
            $session->set_message("<p class='red-text'> There was an error adding the artifact </p>");
        }
    }


?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Add Artifact</h4>

                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($artifact['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="max_rarity" name="max_rarity">
                                    <option value="1" <?= ( isset($_POST['max_rarity']) && $_POST['max_rarity'] == '1' ) ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= ( isset($_POST['max_rarity']) && $_POST['max_rarity'] == '2' ) ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= ( isset($_POST['max_rarity']) && $_POST['max_rarity'] == '3' ) ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= ( isset($_POST['max_rarity']) && $_POST['max_rarity'] == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( isset($_POST['max_rarity']) && $_POST['max_rarity'] == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Max Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="two_piece_bonus" name="two_piece_bonus" value="<?= $_POST['two_piece_bonus'] ?? '' ?>" class="<?= ( empty($_POST['two_piece_bonus']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="two_piece_bonus">Two Piece Bonus</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="four_piece_bonus" name="four_piece_bonus" value="<?= $_POST['four_piece_bonus'] ?? '' ?>" class="<?= ( empty($_POST['four_piece_bonus']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="four_piece_bonus">Four Piece Bonus</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>
 
                            <div class="file-field input-field col l6">
                                    <div class="btn">
                                        <span>Icon</span>
                                        <input type="file" name="icon">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input type="text" class="file-path validate"  accept="image/*">
                                    </div>
                                </div>
                            <div class="input-field col l12">
                                <input type="submit" value="Submit" name="submit" class="btn-small green">
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
