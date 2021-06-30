<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_GET['id'])){
        $weapon = Weapon::find($_GET['id']);
        if(!$weapon){
            header("location: weapons.php");
        }
    }else{
        header("location: weapons.php");
    }

    if(isset($_POST['update'])){

        if($uWeapon = Weapon::edit($weapon, $_POST)){

            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                if( !$weapon->upload($_FILES['icon'], 'icon') ){
                    //  print_r($weapon->errors);
                     $session->set_message("<p class='red-text'>" . implode("<br>", $weapon->errors) . "</p>");
                } 
             }
            // header("location: characters.php");

            $session->set_message("<p class='green-text'>Weapon $uWeapon->name updated!</p>");
        }
    }

    if(isset($_POST['delete'])){
        if($weapon->delete_weapon()){
            $session->set_message("<p class='green-text'> Weapon " . $weapon->name . " has been deleted </p>");
            header('Location: weapons.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the weapon</p>'");
        }
    }

?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Edit Weapon</h4>

                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= $weapon->name ?>">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                <?php foreach(WEAPONS as $weaponName): ?>
                                    <option value="<?= $weaponName ?>" <?= $weaponName == $weapon->type ? 'selected' : '' ?> ><?= $weaponName ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="baseAttack" name="baseAttack" value="<?= $weapon->baseAttack ?>">
                                <label for="baseAttack">Base Attack</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="subStat" name="subStat" value="<?= $weapon->subStat ?>">
                                <label for="subStat">Sub Stat</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="1" <?= $weapon->rarity == '1' ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= $weapon->rarity == '2' ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= $weapon->rarity == '3' ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= $weapon->rarity == '4' ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= $weapon->rarity == '5' ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="location" name="location">
                                    <option value="Chest" <?= $weapon->location == 'Chest' ? 'selected' : '' ?>>Chest</option>
                                    <option value="Crafting" <?= $weapon->location == 'Crafting' ? 'selected' : '' ?>>Crafting</option>
                                    <option value="BP Bounty" <?= $weapon->location == 'BP Bounty' ? 'selected' : '' ?>>BP Bounty</option>
                                    <option value="Gacha" <?= $weapon->location == 'Gacha' ? 'selected' : '' ?>>Gacha</option>
                                    <option value="Starglitter Exchange" <?= $weapon->location == 'Starglitter Exchange' ? 'selected' : '' ?>>Starglitter Exchange</option>
                                </select>
                                <label>Location</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="passiveName" name="passiveName" value="<?= $weapon->passiveName ?>">
                                <label for="passiveName">Passive Name</label>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="passiveDesc" name="passiveDesc" value="<?= $weapon->passiveDesc ?>">
                                <label for="passiveDesc">Passive Description</label>
                            </div>
                        

                            <div class="col l6 s12">
                                <img class="edit-thumbnail" src="<?= $weapon->weapon_img() ?>" alt="<?= $weapon->name ?>">
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
