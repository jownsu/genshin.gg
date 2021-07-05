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

            if(is_object($uCharacter)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$uCharacter->upload($_FILES['icon'], 'icon') ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $uCharacter->errors) . "</p>");
                    } 
                 }
         
                 if( isset($_FILES['portrait']) && is_uploaded_file($_FILES['portrait']['tmp_name']) ){
                     if( !$uCharacter->upload($_FILES['portrait'], 'portrait') ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $uCharacter->errors) . "</p>");
                     }
                 }
                $session->set_message("<p class='green-text'>Character $uCharacter->name updated!</p>");
                header("Refresh:0");
            }else{
                $empty_err   = isset($uCharacter['error']['empty']) ? $uCharacter['error']['empty'] : "";
                $name_err    = isset($uCharacter['error']['name']) ? $uCharacter['error']['name'] : $empty_err;
                $extraSkill_err   = $uCharacter['error']['extraSkill'] ?? null;
                $extraPassive_err   = $uCharacter['error']['extraPassive'] ?? null;
            }

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
                                <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : $character->name ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($uCharacter['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nickname" name="nickname" value="<?= isset($_POST['nickname']) ? $_POST['nickname'] : $character->nickname ?>" class="<?= ( empty($_POST['nickname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="nickname">Nickname</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="description" name="description" value="<?= isset($_POST['description']) ? $_POST['description'] : $character->description ?>" class="<?= ( empty($_POST['description']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="description">Description</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="4" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $character->rarity) == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( (isset($_POST['rarity']) ? $_POST['rarity'] : $character->rarity) == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>
                            
                            <div class="input-field col l6 s12">
                                <select id="weapon" name="weapon">
                                <?php foreach(WEAPONS as $weapon): ?>
                                    <option value="<?= $weapon ?>" <?= ( $weapon == (isset($_POST['weapon']) ? $_POST['weapon'] : $character->weapon) ) ? 'selected' : '' ?> ><?= $weapon ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Weapon</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="element" name="vision">
                                <?php foreach(ELEMENTS as $element): ?>
                                    <option value="<?= $element ?>" <?= ( $element == (isset($_POST['vision']) ? $_POST['vision'] : $character->vision ) ) ? 'selected' : '' ?> ><?= $element ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Vision</label>
                            </div>

                            <h5 class="col l12">Additional Information</h5>

                            <div class="input-field col l6 s12">
                                <select id="sex" name="sex">
                                <?php foreach(SEX as $sex): ?>
                                    <option value="<?= $sex ?>" <?= ( $sex == (isset($_POST['sex']) ? $_POST['sex'] : $character->sex) ) ? 'selected' : '' ?>><?= $sex ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Sex</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="constellation" name="constellation" value="<?= isset($_POST['constellation']) ? $_POST['constellation'] : $character->constellation ?>" class="<?= ( empty($_POST['constellation']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="constellation">Constellation</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nation" name="nation" value="<?= isset($_POST['nation']) ? $_POST['nation'] : $character->nation ?>" class="<?= ( empty($_POST['nation']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="nation">Nation</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="affilation" name="affiliation" value="<?= isset($_POST['affiliation']) ? $_POST['affiliation'] : $character->affiliation ?>" class="<?= ( empty($_POST['affiliation']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="affilation">Affilation</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>
 
                            <div class="input-field col l3 s6">
                                <select name="birthday[month]" id="birthday-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>" <?= ( $month == (isset($_POST['birthday']['month']) ? $_POST['birthday']['month'] : $character->get_birthday()[0]) ) ? 'selected' : '' ?>><?=  $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="birthday-month">Birthday</label>
                            </div>

                            <div class="input-field col l3 s6">
                                <select name="birthday[day]" id="birthday-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>" <?= ( $day == (isset($_POST['birthday']['day']) ? $_POST['birthday']['day'] : $character->get_birthday()[1]) ) ? 'selected' : '' ?>><?=  $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[month]" id="release-date-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>" <?= ( $month == (isset($_POST['release_date']['month']) ? $_POST['release_date']['month'] : $character->get_release_date()[0]) ) ? 'selected' : '' ?>><?=  $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="release-date-month">Release Date</label>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[day]" id="release-date-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>" <?= ( $day == (isset($_POST['release_date']['day']) ? $_POST['release_date']['day'] : $character->get_release_date()[1]) ) ? 'selected' : '' ?>><?=  $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[year]" id="release-date-year">
                                    <?php foreach(YEARS as $year): ?>
                                        <option value="<?= $year ?>" <?= ( $year == (isset($_POST['release_date']['year']) ? $_POST['release_date']['year'] : $character->get_release_date()[2]) ) ? 'selected' : '' ?>><?=  $year ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="tier" name="tier">
                                <?php foreach(TIERS as $tier): ?>
                                    <option value="<?= $tier ?>" <?= ( $tier == (isset($_POST['tier']) ? $_POST['tier'] : $character->tier) ) ? 'selected' : '' ?> ><?= $tier ?></option>
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
                                    foreach($skillTalents as $key => $skillTalent):
                                ?>
                                <div class="extraskill col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[<?= $key ?>][name]" id="name" value="<?= isset($_POST['skill_talents'][$key]['name']) ? $_POST['skill_talents'][$key]['name'] : $skillTalent->name ?>" class="<?= ( empty($_POST['skill_talents'][$key]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $key > 2 ? $extraSkill_err : $empty_err ?? '' ?>"></span>
                                    </div>
                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[<?= $key ?>][unlock]" id="unlock" value="<?= isset($_POST['skill_talents'][$key]['unlock']) ? $_POST['skill_talents'][$key]['unlock'] : $skillTalent->unlock ?>" class="<?= ( empty($_POST['skill_talents'][$key]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $key > 2 ? $extraSkill_err : $empty_err ?? '' ?>"></span>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['skill_talents'][$key]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="skill_talents[<?= $key ?>][description]" id="description" cols="30" rows="10"><?= isset($_POST['skill_talents'][$key]['description']) ? $_POST['skill_talents'][$key]['description'] : $skillTalent->description ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $key > 2 ? $extraSkill_err : $empty_err ?? '' ?>"></span>
                                    </div>
                                </div>
                                <?php endforeach ?>

                            </div>


                            <h5 class="col s12 m12 l12">Passive Talents</h5>


                            <div class="passive-talents">     
                                <?php 
                                        $passiveTalents = json_decode($character->passiveTalents);
                                    
                                        foreach($passiveTalents as $key => $passiveTalent):
                                ?>   
                                <div class="extraPassive col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[<?= $key ?>][name]" id="name" value="<?= isset($_POST['passive_talents'][$key]['name']) ? $_POST['passive_talents'][$key]['name'] : $passiveTalent->name ?>" class="<?= ( empty($_POST['passive_talents'][$key]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $key > 2 ? $extraPassive_err : $empty_err ?? '' ?>"></span>
                                    </div>
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[<?= $key ?>][unlock]" id="unlock" value="<?= isset($_POST['passive_talents'][$key]['unlock']) ? $_POST['passive_talents'][$key]['unlock'] : $passiveTalent->unlock ?>" class="<?= ( empty($_POST['passive_talents'][$key]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $key > 2 ? $extraPassive_err : $empty_err ?? '' ?>"></span>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['passive_talents'][$key]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="passive_talents[<?= $key ?>][description]" id="description" cols="30" rows="10"><?= isset($_POST['passive_talents'][$key]['description']) ? $_POST['passive_talents'][$key]['description'] : $passiveTalent->description ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $key > 2 ? $extraPassive_err : $empty_err ?? '' ?>"></span>
                                    </div>
                                </div>

                                <?php endforeach ?>
                            </div>

                        </div>    
                    </div>



                    <div id="swipe-3" class="col s12">

                        <div class="row">
                        <h5 class="col l12">Constellations</h5>

                            <?php 
                                $constellations = json_decode($character->constellations);
                            
                                foreach($constellations as $key => $constellation):
                            ?>
                            <div class="constellation col l12">
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[<?= $key ?>][name]" id="name" value="<?= isset($_POST['constellations'][$key]['name']) ? $_POST['constellations'][$key]['name'] : $constellation->name ?>" class="<?= ( empty($_POST['constellations'][$key]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[<?= $key ?>][unlock]" id="unlock" value="<?= isset($_POST['constellations'][$key]['unlock']) ? $_POST['constellations'][$key]['unlock'] : $constellation->unlock ?>" class="<?= ( empty($_POST['constellations'][$key]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="unlock">Unlock</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations'][$key]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[<?= $key ?>][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations'][$key]['description']) ? $_POST['constellations'][$key]['description'] : $constellation->description ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
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
