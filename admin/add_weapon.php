<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){

            if($weapon = Weapon::add($_POST)){
                if(is_object($weapon)){
                    if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                        if( !$weapon->upload($_FILES['icon'], 'icon') ){
                            // print_r($weapon->errors);
                            $session->set_message("<p class='red-text'>" . implode("<br>", $weapon->errors) . "</p>");
                        } 
                    }
                    $session->set_message("<p class='green-text'> Weapon $weapon->name  was added </p>");
                    header('location: add_weapon.php');
                }else{
                    $empty_err   = isset($weapon['error']['empty']) ? $weapon['error']['empty'] : "";
                    $name_err    = isset($weapon['error']['name']) ? $weapon['error']['name'] : $empty_err;
                    $baseATK_err = isset($weapon['error']['baseATK']) ? $weapon['error']['baseATK'] : $empty_err;
                }

            }else{
                // print_r($weapon->get_errors());
                $session->set_message("<p class='red-text'> There was an error adding the weapon </p>");
            }


    }
?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Add Weapon</h4>

                <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($weapon['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                    <?php foreach(WEAPONS as $weaponName): ?>
                                        <option value="<?= $weaponName ?>" <?= ( isset($_POST['type']) && $_POST['type'] == $weaponName ) ? 'selected' : '' ?> ><?= $weaponName ?></option>
                                    <?php endforeach ?> 
                                </select>
                                <label>Type</label>

                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="baseAttack" name="baseAttack" value="<?= isset($_POST['baseAttack']) ? $_POST['baseAttack'] : '' ?>" class="<?= ( (empty($_POST['baseAttack']) && isset($empty_err)) || isset($weapon['error']['baseATK']) ) ? 'invalid' : '' ?>">
                                <label for="baseAttack">Base Attack</label>
                                <span class="helper-text" data-error="<?= $baseATK_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="subStat" name="subStat" value="<?= isset($_POST['subStat']) ? $_POST['subStat'] : '' ?>" class="<?= ( empty($_POST['subStat']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="subStat">Sub Stat</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
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
                                <select id="location" name="location">
                                    <?php foreach(WEAPON_LOCATIONS as $location): ?>
                                        <option value="<?= $location ?>" <?= ( isset($_POST['location']) && $_POST['location'] == $location ) ? 'selected' : '' ?> ><?= $location ?></option>
                                    <?php endforeach ?> 
                                </select>
                                <label>Location</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="passiveName" name="passiveName" value="<?= isset($_POST['passiveName']) ? $_POST['passiveName'] : '' ?>" class="<?= ( empty($_POST['passiveName']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="passiveName">Passive Name</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="passiveDesc" name="passiveDesc" value="<?= isset($_POST['passiveDesc']) ? $_POST['passiveDesc'] : '' ?>" class="<?= ( empty($_POST['passiveDesc']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="passiveDesc">Passive Description</label>
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
