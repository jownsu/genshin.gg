<?php require_once("includes/header.php"); ?>
<?php

    if(isset($_GET['id'])){
        $character = Character::find($_GET['id']);
        if(!$character){
            header("location: characters.php");
        }
    }else{
        header("location: characters.php");
    }

    if(isset($_POST['update'])){

        if($uCharacter = Character::edit($character, $_POST)){

            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                if( !$character->upload($_FILES['icon'], 'icon') ){
                    //  print_r($character->errors);
                     $session->set_message("<p class='red-text'>" . implode("<br>", $character->errors) . "</p>");
                } 
             }
     
             if( isset($_FILES['portrait']) && is_uploaded_file($_FILES['portrait']['tmp_name']) ){
                 if( !$character->upload($_FILES['portrait'], 'portrait') ){
                    //  print_r($character->errors);
                     $session->set_message("<p class='red-text'>" . implode("<br>", $character->errors) . "</p>");
                 }
             }
            // header("location: characters.php");

            $session->set_message("<p class='green-text'>Character $uCharacter->name updated!</p>");
        }
    }

    if(isset($_POST['delete'])){
        if($character->delete_character()){
            $session->set_message("<p class='green-text'> Character " . $character->name . " has been deleted </p>");
            header('Location: characters.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the character</p>'");
        }
    }

?>


    <div class="table-container">

        <div class="row">
        
            <div class="col l10 s12 offset-l1">
                <h4>Edit Character</h4>
        
                <ul id="tabs-swipe-demo" class="tabs">
                    <li class="tab col s3"><a href="#swipe-1">Informations</a></li>
                    <li class="tab col s3"><a href="#swipe-2">Skills</a></li>
                    <li class="tab col s3"><a href="#swipe-3">Constellations</a></li>
                    <li class="tab col s3"><a href="#swipe-4">Upload/Save</a></li>
                </ul>
        
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" id="targetId" value="<?= $character->char_id ?>">
        
                    <div id="swipe-1" class="col s12">

                        <div class="row">
                            <h5 class="col l12">Basic Information</h5>

                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= $character->name ?>">
                                <label for="name">Name</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nickname" name="nickname" value="<?= $character->nickname ?>">
                                <label for="nickname">Nickname</label>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="description" name="description" value="<?= $character->description ?>">
                                <label for="description">Description</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                <?php foreach(RARITY as $rarity): ?>
                                    <option value="<?= $rarity ?>" <?= $rarity == $character->rarity ? 'selected' : '' ?> ><?= $rarity ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Rarity</label>
                            </div>
                            
                            <div class="input-field col l6 s12">
                                <select id="weapon" name="weapon">
                                <?php foreach(WEAPONS as $weapon): ?>
                                    <option value="<?= $weapon ?> " <?= $weapon == $character->weapon ? 'selected' : '' ?>><?= $weapon ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Weapon</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="element" name="vision">
                                <?php foreach(ELEMENTS as $element): ?>
                                    <option value="<?= $element ?>" <?= $element == $character->vision ? 'selected' : '' ?>><?= $element ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Vision</label>
                            </div>

                            <h5 class="col l12">Additional Information</h5>

                            <div class="input-field col l6 s12">
                                <select id="sex" name="sex">
                                <?php foreach(SEX as $sex): ?>
                                    <option value="<?= $sex ?>" <?= $sex == $character->sex ? 'selected' : '' ?>><?= $sex ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Sex</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="constellation" name="constellation" value="<?= $character->constellation ?>">
                                <label for="constellation">Constellation</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nation" name="nation" value="<?= $character->nation ?>">
                                <label for="nation">Nation</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="affilation" name="affiliation" value="<?= $character->affiliation ?>">
                                <label for="affilation">Affilation</label>
                            </div>
 
                            <div class="input-field col l3 s6">
                                <select name="birthday[month]" id="birthday-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>" <?= $month == $character->get_birthday()[0] ? ' selected' : '' ?>><?=  $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="birthday-month">Birthday</label>
                            </div>

                            <div class="input-field col l3 s6">
                                <select name="birthday[day]" id="birthday-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>" <?= $day == $character->get_birthday()[1] ? ' selected' : '' ?>><?= $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[month]" id="release-date-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>" <?= $month == $character->get_release_date()[0] ? ' selected' : '' ?>><?=  $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="release-date-month">Release Date</label>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[day]" id="release-date-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>" <?= $day == $character->get_release_date()[1] ? ' selected' : '' ?>><?= $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[year]" id="release-date-year">
                                    <?php foreach(YEARS as $year): ?>
                                        <option value="<?= $year ?>" <?= $year == $character->get_release_date()[2] ? ' selected' : '' ?>><?= $year ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="tier" name="tier">
                                <?php foreach(TIERS as $tier): ?>
                                    <option value="<?= $tier ?>" <?= $tier == $character->tier ? 'selected' : '' ?> ><?= $tier ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Tier</label>
                            </div>
                                

                        </div>
                    </div>



                    <div id="swipe-2" class="col s12">
                        <div class="row">
                            <div class="skill-talents">
                                <h5 class="col s12 m12 l12">Skill Talents</h5>

                                <?php 
                                    $skillTalents = json_decode($character->skillTalents);
                                    foreach($skillTalents as $skillTalent):
                                ?>
                                <div class="extraskill col l12">
                                    <?php if(!preg_match('(normal attack|elemental skill|elemental burst)i', $skillTalent->unlock)): ?>
                                        <div class="col s12 m12 l12 right-align">
                                        <a href="#"><i class="material-icons red-text text-lighten-1" id="removeExtraSkill">close</i></a>
                                        </div>
                                    <?php endif ?>

                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[<?= $skillTalent->unlock ?>][name]" id="name" value="<?= $skillTalent->name ?>">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[<?= $skillTalent->unlock ?>][unlock]" id="unlock" value="<?=$skillTalent->unlock?>">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="skill_talents[<?= $skillTalent->unlock ?>][description]" id="description" cols="30" rows="10"><?= $skillTalent->description ?></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                                <?php endforeach ?>

                            </div>


                            <div class="col l12">
                                <a href="#" class="btn-small green" id="addSkill">Add more skill</a>
                            </div>


                            <h5 class="col s12 m12 l12">Passive Talents</h5>




                            <div class="passive-talents">     
                                <?php 
                                        $passiveTalents = json_decode($character->passiveTalents);
                                    
                                        foreach($passiveTalents as $passiveTalent):
                                ?>   
                                <div class="extraPassive col l12">
                                    <!-- <div class="col s12 m12 l12 right-align">
                                        <a href="#"><i class="material-icons red-text text-lighten-1" id="removeExtraPassive">close</i></a>
                                    </div> -->
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[<?= $passiveTalent->unlock ?>][name]" id="name" value="<?= $passiveTalent->name ?>">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[<?= $passiveTalent->unlock ?>][unlock]" id="unlock" value="<?= $passiveTalent->unlock ?>">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="passive_talents[<?= $passiveTalent->unlock ?>][description]" id="description" cols="30" rows="10"><?= $passiveTalent->description ?></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>

                            <div class="col l12">
                                <a href="#" class="btn-small green" id="addPassive">Add more passive</a>
                            </div>

                        </div>    
                    </div>



                    <div id="swipe-3" class="col s12">

                        <div class="row">
                        <h5 class="col l12">Constellations</h5>

                            <?php 
                                $constellations = json_decode($character->constellations);
                            
                                foreach($constellations as $constellation):
                            ?>
                            <div class="constellation col l12">
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[<?= $constellation->unlock ?>][name]" id="name" value="<?= $constellation->name ?>">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[<?= $constellation->unlock ?>][unlock]" id="unlock" value="<?= $constellation->unlock ?>">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[<?= $constellation->unlock ?>][description]" id="description" cols="30" rows="10"> <?= $constellation->description ?></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>


                    </div>



                    <div id="swipe-4" class="col s12">
                        
                        <div class="row">
                            <div class="col l6 s12 editCharacterPhotosContainer">
                                <img class="edit-thumbnail" src="<?= $character->Thumbnail() ?>" alt="<?= $character->name ?>">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Upload Thumbnail</span>
                                        <input type="file" name="icon">
                                    </div>
                                <div class="file-path-wrapper">
                                    <input type="text" class="file-path validate" accept="image/*">
                                </div>
                            </div>
                            <img class="edit-portrait" src="<?= $character->Portrait() ?>" alt="<?= $character->name ?>">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Upload Portrait</span>
                                    <input type="file" name="portrait">
                                </div>
                                <div class="file-path-wrapper">
                                    <input type="text" class="file-path validate" accept="image/*">
                                </div>
                            </div> 
                            <div class="input-field col l12">
                                <input type="submit" value="Update" name="update" class="btn-small green">
                                <button data-target="delete-char-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                            </div>

                        </div>                    
                    </div>



                </form>
        
        
            </div>
        </div>
    </div>

    <div id="delete-char-modal" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to delete <?= $character->name ?>?</h5>
        </div>
        <div class="modal-footer">
            <form method="POST">
                <input type="submit" value="Delete" name="delete" class="modal-close btn-small red">
                <a href="#!" class="modal-close btn-small blue">No</a>
            </form>
        </div>
    </div>

<script src="js/addMoreSkill.js"> </script>

<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php"); ?>
