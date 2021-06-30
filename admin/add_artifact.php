<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){


        if($artifact = Artifact::add($_POST)){
            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
               if( !$artifact->upload($_FILES['icon'], 'icon') ){
                    // print_r($artifact->errors);
                    $session->set_message("<p class='red-text'>" . implode("<br>", $artifact->errors) . "</p>");
               } 
            }
    
            $session->set_message("<p class='green-text'> Artifact $artifact->name was Added </p>");
            header('location: add_artifact.php');
        }else{
            // print_r($artifact->get_errors());
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
                                <input type="text" id="name" name="name">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="max_rarity" name="max_rarity">
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                                <label>Max Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="two_piece_bonus" name="two_piece_bonus">
                                <label for="two_piece_bonus">Two Piece Bonus</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="four_piece_bonus" name="four_piece_bonus">
                                <label for="four_piece_bonus">Four Piece Bonus</label>
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
