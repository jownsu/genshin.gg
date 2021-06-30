<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_GET['id'])){
        $consumable = Consumable::find($_GET['id']);
        if(!$consumable){
            header("location: artifacts.php");
        }
    }else{
        header("location: artifacts.php");
    }

    if(isset($_POST['update'])){

        if($uConsumable = Consumable::edit($consumable, $_POST)){

            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                if( !$consumable->upload($_FILES['icon'], 'icon') ){
                    //  print_r($consumable->errors);
                     $session->set_message("<p class='red-text'>" . implode("<br>", $consumable->errors) . "</p>");
                } 
             }
    
            // header("location: characters.php");

            $session->set_message("<p class='green-text'>Consumable $uConsumable->name updated!</p>");
        }
    }

    if(isset($_POST['delete'])){
        if($consumable->delete_consumable()){
            $session->set_message("<p class='green-text'> Consumable " . $consumable->name . " has been deleted </p>");
            header('Location: consumables.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the consumable</p>'");
        }
    }

?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Edit Consumables</h4>

                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= $consumable->name ?>">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="1" <?= $consumable->rarity == '1' ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= $consumable->rarity == '2' ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= $consumable->rarity == '3' ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= $consumable->rarity == '4' ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= $consumable->rarity == '5' ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="category" name="category">
                                    <option value="Alchemy" <?= $consumable->category == 'Alchemy' ? 'selected' : '' ?>>Alchemy</option>
                                    <option value="Food" <?= $consumable->category == 'Food' ? 'selected' : '' ?>>Food</option>
                                </select>
                                <label>Category</label>

                            </div>
                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                    <option value="Potion" <?= $consumable->type == 'Potion' ? 'selected' : '' ?>>Potion</option>
                                    <option value="Oil" <?= $consumable->type == 'Oil' ? 'selected' : '' ?>>Oil</option>
                                    <option value="Stats Boost" <?= $consumable->type == 'Stats Boost' ? 'selected' : '' ?>>Stats Boost</option>
                                    <option value="Heal Food" <?= $consumable->type == 'Heal Food' ? 'selected' : '' ?>>Heal Food</option>
                                    <option value="Revive Food" <?= $consumable->type == 'Revive Food' ? 'selected' : '' ?>>Revive Food</option>
                                    <option value="Stamina Food" <?= $consumable->type == 'Stamina Food' ? 'selected' : '' ?>>Stamina Food</option>
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="bonus" name="bonus" value="<?= $consumable->bonus ?>">
                                <label for="bonus">Bonus</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="ingredients" name="ingredients" value="<?= $consumable->ingredients ?>">
                                <label for="ingredients">Ingredients</label>
                            </div>

                            <div class="col l6 s12">
                                <img class="edit-thumbnail" src="<?= $consumable->consumables_img() ?>" alt="<?= $consumable->name ?>">
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
