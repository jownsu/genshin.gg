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
            if(is_object($uConsumable)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$uConsumable->upload($_FILES['icon'], 'icon') ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $uConsumable->errors) . "</p>");
                    } 
                 }
    
                $session->set_message("<p class='green-text'>Consumable $uConsumable->name updated!</p>");
                header("Refresh: 0");
            }else{
                $empty_err   = $uConsumable['error']['empty'] ?? "";
                $name_err    = $uConsumable['error']['name'] ?? $empty_err;
            }
        }else{
            $session->set_message("<p class='green-text'>There was an error updating the consumable</p>");
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
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?? $consumable->name ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($uConsumable['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="1" <?= ( ($_POST['rarity'] ?? $consumable->rarity) == '1' ) ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= ( ($_POST['rarity'] ?? $consumable->rarity) == '2' ) ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= ( ($_POST['rarity'] ?? $consumable->rarity) == '3' ) ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= ( ($_POST['rarity'] ?? $consumable->rarity) == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( ($_POST['rarity'] ?? $consumable->rarity) == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="category" name="category">
                                    <option value="Alchemy" <?= ( ($_POST['category'] ?? $consumable->category) == 'Alchemy' ) ? 'selected' : '' ?>>Alchemy</option>
                                    <option value="Food" <?= ( ($_POST['category'] ?? $consumable->category) == 'Food' ) ? 'selected' : '' ?>>Food</option>
                                </select>
                                <label>Category</label>

                            </div>
                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                    <?php foreach(CONSUMABLE_TYPES as $type): ?>
                                        <option value="<?= $type ?>" <?= ( ($_POST['type'] ?? $consumable->type) == $type) ? 'selected' : '' ?> ><?= $type ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="bonus" name="bonus" value="<?= $_POST['bonus'] ?? $consumable->bonus ?>" class="<?= ( empty($_POST['bonus']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="bonus">Bonus</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="ingredients" name="ingredients" value="<?= $_POST['ingredients'] ?? $consumable->ingredients ?>" class="<?= ( empty($_POST['ingredients']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="ingredients">Ingredients</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
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
                                <button data-target="delete-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                            </div>
                        </div>
                </form>

            </div>
        </div>
    </div>
    <div id="delete-modal" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to delete <?= $consumable->name ?>?</h5>
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
