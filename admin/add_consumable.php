<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){


        if($consumable = Consumable::add($_POST)){
            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
               if( !$consumable->upload($_FILES['icon'], 'icon') ){
                    // print_r($consumable->errors);
                    $session->set_message("<p class='red-text'>" . implode("<br>", $consumable->errors) . "</p>");
               } 
            }
    
            $session->set_message("<p class='green-text'> Consumable $consumable->name was Added </p>");
            header('location: add_consumable.php');
        }else{
            // print_r($consumable->get_errors());
            $session->set_message("<p class='red-text'> There was an error adding the consumable </p>");
        }
    }


?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Add Consumables</h4>

                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="category" name="category">
                                    <option value="Alchemy">Alchemy</option>
                                    <option value="Food">Food</option>
                                </select>
                                <label>Category</label>

                            </div>
                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                    <option value="Potion">Potion</option>
                                    <option value="Oil">Oil</option>
                                    <option value="Stats Boost">Stats Boost</option>
                                    <option value="Heal Food">Heal Food</option>
                                    <option value="Revive Food">Revive Food</option>
                                    <option value="Stamina Food">Stamina Food</option>
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="bonus" name="bonus">
                                <label for="bonus">Bonus</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="ingredients" name="ingredients">
                                <label for="ingredients">Ingredients</label>
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
