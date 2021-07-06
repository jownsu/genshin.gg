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
            if(is_object($uWeapon)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$uWeapon->upload($_FILES['icon'], 'icon') ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $uWeapon->errors) . "</p>");
                    } 
                 }
    
                $session->set_message("<p class='green-text'>Weapon $uWeapon->name updated!</p>");
                header("Refresh:0");
            }else{
                $empty_err   = isset($uWeapon['error']['empty']) ? $uWeapon['error']['empty'] : "";
                $name_err    = isset($uWeapon['error']['name']) ? $uWeapon['error']['name'] : $empty_err;
                $baseATK_err = isset($uWeapon['error']['baseATK']) ? $uWeapon['error']['baseATK'] : $empty_err;
            }
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
                                <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : $weapon->name ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($uWeapon['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>

                            </div>

                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                <?php foreach(WEAPONS as $weaponName): ?>
                                    <option value="<?= $weaponName ?>" <?= ( (isset($_POST['type']) ? $_POST['type'] : $weapon->type) == $weaponName) ? 'selected' : '' ?> ><?= $weaponName ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="baseAttack" name="baseAttack" value="<?= isset($_POST['baseAttack']) ? $_POST['baseAttack'] : $weapon->baseAttack ?>" class="<?= ( (empty($_POST['baseAttack']) && isset($empty_err)) || isset($uWeapon['error']['baseATK']) ) ? 'invalid' : '' ?>">
                                <label for="baseAttack">Base Attack</label>
                                <span class="helper-text" data-error="<?= $baseATK_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="subStat" name="subStat" value="<?= isset($_POST['subStat']) ? $_POST['subStat'] : $weapon->subStat ?>" class="<?= ( empty($_POST['subStat']) && isset($empty_err) ) ? 'invalid' : '' ?>" >
                                <label for="subStat">Sub Stat</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="1" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $weapon->rarity) == '1' ) ? 'selected' : '' ?>>1 Star</option>
                                    <option value="2" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $weapon->rarity) == '2' ) ? 'selected' : '' ?>>2 Star</option>
                                    <option value="3" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $weapon->rarity) == '3' ) ? 'selected' : '' ?>>3 Star</option>
                                    <option value="4" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $weapon->rarity) == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $weapon->rarity) == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="location" name="location">
                                    <?php foreach(WEAPON_LOCATIONS as $location): ?>
                                        <option value="<?= $location ?>" <?= ( $location == (isset($_POST['location']) ? $_POST['location'] : $weapon->location) ) ? 'selected' : '' ?> ><?= $location ?></option>
                                    <?php endforeach ?> 
                                </select>
                                <label>Location</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="passiveName" name="passiveName" value="<?= isset($_POST['passiveName']) ? $_POST['passiveName'] : $weapon->passiveName ?>" class="<?= ( empty($_POST['passiveName']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="passiveName">Passive Name</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="passiveDesc" name="passiveDesc" value="<?= isset($_POST['passiveDesc']) ? $_POST['passiveDesc'] : $weapon->passiveDesc ?>" class="<?= ( empty($_POST['passiveDesc']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="passiveDesc">Passive Description</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
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
                                <button data-target="delete-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                            </div>

                        </div>
                </form>

            </div>
        </div>
    </div>
    <div id="delete-modal" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to delete <?= $weapon->name ?>?</h5>
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
