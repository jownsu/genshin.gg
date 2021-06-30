<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){


        if($weapon = Weapon::add($_POST)){
            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
               if( !$weapon->upload($_FILES['icon'], 'icon') ){
                    // print_r($weapon->errors);
                    $session->set_message("<p class='red-text'>" . implode("<br>", $weapon->errors) . "</p>");
               } 
            }

            $session->set_message("<p class='green-text'> Character $weapon->name was Added </p>");
            header('location: add_weapon.php');
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
                                <input type="text" id="name" name="name">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="type" name="type">
                                    <option value="Bow">Bow</option>
                                    <option value="Catalyst">Catalyst</option>
                                    <option value="Claymore">Claymore</option>
                                    <option value="Polearm">Polearm</option>
                                    <option value="Sword">Sword</option>
                                </select>
                                <label>Type</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="baseAttack" name="baseAttack">
                                <label for="baseAttack">Base Attack</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="subStat" name="subStat">
                                <label for="subStat">Sub Stat</label>
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
                                <select id="location" name="location">
                                    <option value="Chest">Chest</option>
                                    <option value="Crafting">Crafting</option>
                                    <option value="BP Bounty">BP Bounty</option>
                                    <option value="Gacha">Gacha</option>
                                    <option value="Starglitter Exchange">Starglitter Exchange</option>
                                </select>
                                <label>Location</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="passiveName" name="passiveName">
                                <label for="passiveName">Passive Name</label>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="passiveDesc" name="passiveDesc">
                                <label for="passiveDesc">Passive Description</label>
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
