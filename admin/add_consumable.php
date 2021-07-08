<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){


        if($consumable = Consumable::add($_POST)){
            if(is_object($consumable)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$consumable->upload($_FILES['icon'], 'icon') ){
                         // print_r($consumable->errors);
                         $session->set_message("<p class='red-text'>" . implode("<br>", $consumable->errors) . "</p>");
                    } 
                 }
         
                 $session->set_message("<p class='green-text'> Consumable $consumable->name was Added </p>");
            }else{
                $empty_err   = $consumable['error']['empty'] ?? "";
                $name_err    = $consumable['error']['name'] ?? $empty_err;
            }

        }else{
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
                                <input type="text" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($consumable['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="1" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '1' ) ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '2' ) ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '3' ) ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="category" name="category">
                                    <option value="Alchemy" <?= ( isset($_POST['category']) && $_POST['category'] == 'Alchemy' ) ? 'selected' : '' ?>>Alchemy</option>
                                    <option value="Food" <?= ( isset($_POST['category']) && $_POST['category'] == 'Food' ) ? 'selected' : '' ?>>Food</option>
                                </select>
                                <label>Category</label>

                            </div>
                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                    <?php foreach(CONSUMABLE_TYPES as $type): ?>
                                        <option value="<?= $type ?>" <?= ( isset($_POST['type']) && $_POST['type'] == $type ) ? 'selected' : '' ?>><?= $type ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="bonus" name="bonus" value="<?= $_POST['bonus'] ?? '' ?>" class="<?= ( empty($_POST['bonus']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="bonus">Bonus</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="ingredients" name="ingredients" value="<?= $_POST['ingredients'] ?? '' ?>" class="<?= ( empty($_POST['ingredients']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="ingredients">Ingredients</label>
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
