<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){

        if($character = Character::add($_POST)){
            if(is_object($character)){
                if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
                    if( !$character->upload($_FILES['icon'], 'icon') ){
                            $session->set_message("<p class='red-text'>" . implode("<br>", $character->errors) . "</p>");
                        } 
                    }
                    if( isset($_FILES['portrait']) && is_uploaded_file($_FILES['portrait']['tmp_name']) ){
                        if( !$character->upload($_FILES['portrait'], 'portrait') ){
                            $session->set_message("<p class='red-text'>" . implode("<br>", $character->errors) . "</p>");
                        }
                    }
                    $session->set_message("<p class='green-text'> Character $character->name was Added </p>");
                    header('location: add_character.php');
            }else{
                $empty_err   = isset($character['error']['empty']) ? $character['error']['empty'] : "";
                $name_err    = isset($character['error']['name']) ? $character['error']['name'] : $empty_err;
                $extraSkill_err   = $character['error']['extraSkill'] ?? null;
                $extraPassive_err   = $character['error']['extraPassive'] ?? null;
            }
        }else{
            $session->set_message("<p class='red-text'> There was an error adding the character </p>");
        }

    }


?>


    <div class="table-container">

        <div class="row">

            <div class="col l10 s12 offset-l1">
                <h4>Add Character</h4>

                <ul id="tabs-swipe-demo" class="tabs">
                    <li class="tab col s3"><a href="#swipe-1">Informations</a></li>
                    <li class="tab col s3"><a href="#swipe-2">Skills</a></li>
                    <li class="tab col s3"><a href="#swipe-3">Constellations</a></li>
                    <li class="tab col s3"><a href="#swipe-4">Upload/Save</a></li>
                </ul>


                <form action="" method="POST" enctype="multipart/form-data">

                    <div id="swipe-1" class="col s12">
                        <div class="row">
                            <h5 class="col l12">Basic Information</h5>
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" class="<?= ( (empty($_POST['name']) && isset($empty_err)) || isset($character['error']['name']) ) ? 'invalid' : '' ?>">
                                <label for="name">Name</label>
                                <span class="helper-text" data-error="<?= $name_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nickname" name="nickname" value="<?= isset($_POST['nickname']) ? $_POST['nickname'] : '' ?>" class="<?= ( empty($_POST['nickname']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="nickname">Nickname</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l12 s12">
                                <input type="text" id="description" name="description" value="<?= isset($_POST['description']) ? $_POST['description'] : '' ?>" class="<?= ( empty($_POST['description']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="description">Description</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="4" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '4' ) ? 'selected' : '' ?>>4 Star</option>
                                    <option value="5" <?= ( isset($_POST['rarity']) && $_POST['rarity'] == '5' ) ? 'selected' : '' ?>>5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="weapon" name="weapon">
                                    <?php foreach(WEAPONS as $weapon): ?>
                                        <option value="<?= $weapon ?>" <?= ( isset($_POST['weapon']) && $_POST['weapon'] == $weapon ) ? 'selected' : '' ?> ><?= $weapon ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>Weapon</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="element" name="vision">
                                    <?php foreach(ELEMENTS as $element): ?>
                                        <option value="<?= $element ?>" <?= ( isset($_POST['vision']) && $_POST['vision'] == $element ) ? 'selected' : '' ?>><?= $element ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>Element</label>
                            </div>


                            <h5 class="col l12">Additional Information</h5>


                            <div class="input-field col l6 s12">
                                <select id="sex" name="sex">
                                    <option value="Male" <?= ( isset($_POST['sex']) && $_POST['sex'] == 'Male' ) ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= ( isset($_POST['sex']) && $_POST['sex'] == 'Female' ) ? 'selected' : '' ?>>Female</option>
                                </select>
                                <label>Sex</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="constellation" name="constellation" value="<?= isset($_POST['constellation']) ? $_POST['constellation'] : '' ?>" class="<?= ( empty($_POST['constellation']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="constellation">Constellation</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nation" name="nation" value="<?= isset($_POST['nation']) ? $_POST['nation'] : '' ?>" class="<?= ( empty($_POST['nation']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="nation">Nation</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="affiliation" name="affiliation" value="<?= isset($_POST['affiliation']) ? $_POST['affiliation'] : '' ?>" class="<?= ( empty($_POST['affiliation']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                <label for="affiliation">Affiliation</label>
                                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                            </div>

                            <div class="input-field col l3 s6">
                                <select name="birthday[month]" id="birthday-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>" <?= ( isset($_POST['birthday']['month']) && $_POST['birthday']['month'] == $month ) ? 'selected' : '' ?>><?= $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="birthday-month">Birthday</label>
                            </div>

                            <div class="input-field col l3 s6">
                                <select name="birthday[day]" id="birthday-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>" <?= ( isset($_POST['birthday']['day']) && $_POST['birthday']['day'] == $day ) ? 'selected' : '' ?>> <?= $day ?> </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[month]" id="release-date-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>" <?= ( isset($_POST['release_date']['month']) && $_POST['release_date']['month'] == $month ) ? 'selected' : '' ?>> <?= $month ?> </option>
                                    <?php endforeach ?>
                                </select>
                                <label for="release-date-month">Release Date</label>
                            </div>
                            

                            <div class="input-field col l2 s4">
                                <select name="release_date[day]" id="release-date-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>" <?= ( isset($_POST['release_date']['day']) && $_POST['release_date']['day'] == $day ) ? 'selected' : '' ?>><?= $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[year]" id="release-date-year">
                                    <?php foreach(YEARS as $year): ?>
                                        <option value="<?= $year ?>" <?= ( isset($_POST['release_date']['year']) && $_POST['release_date']['year'] == $year ) ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="tier" name="tier">
                                    <option value="S" <?= ( isset($_POST['tier']) && $_POST['tier'] == 'S' ) ? 'selected' : '' ?>>S</option>
                                    <option value="A" <?= ( isset($_POST['tier']) && $_POST['tier'] == 'A' ) ? 'selected' : '' ?>>A</option>
                                    <option value="B" <?= ( isset($_POST['tier']) && $_POST['tier'] == 'B' ) ? 'selected' : '' ?>>B</option>
                                    <option value="C" <?= ( isset($_POST['tier']) && $_POST['tier'] == 'C' ) ? 'selected' : '' ?>>C</option>
                                    <option value="D" <?= ( isset($_POST['tier']) && $_POST['tier'] == 'D' ) ? 'selected' : '' ?>>D</option>
                                </select>
                                <label>Tier</label>
                            </div>


                        </div>
                    </div>


                    <div id="swipe-2" class="col s12">
                        <div class="row">
                            <div class="skill-talents">
                                <h5 class="col s12 m12 l12">Skill Talents</h5>

                                <div class="extraskill col l12">

                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[0][name]" id="name" value="<?= isset($_POST['skill_talents'][0]['name']) ? $_POST['skill_talents'][0]['name'] : '' ?>" class="<?= ( empty($_POST['skill_talents'][0]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input readonly type="text" name="skill_talents[0][unlock]" id="unlock" value="<?= isset($_POST['skill_talents'][0]['unlock']) ? $_POST['skill_talents'][0]['unlock'] : 'Normal Attack' ?>" class="<?= ( empty($_POST['skill_talents'][0]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['skill_talents'][0]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="skill_talents[0][description]" id="description" cols="30" rows="10"><?= isset($_POST['skill_talents'][0]['description']) ? $_POST['skill_talents'][0]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                </div>
                                
                                <div class="extraskill col l12">

                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[1][name]" id="name" value="<?= isset($_POST['skill_talents'][1]['name']) ? $_POST['skill_talents'][1]['name'] : '' ?>" class="<?= ( empty($_POST['skill_talents'][1]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input readonly type="text" name="skill_talents[1][unlock]" id="unlock" value="<?= isset($_POST['skill_talents'][1]['unlock']) ? $_POST['skill_talents'][1]['unlock'] : 'Elemental Skill' ?>" class="<?= ( empty($_POST['skill_talents'][1]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['skill_talents'][1]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="skill_talents[1][description]" id="description" cols="30" rows="10"><?= isset($_POST['skill_talents'][1]['description']) ? $_POST['skill_talents'][1]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                </div>

                                <div class="extraskill col l12">

                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[2][name]" id="name" value="<?= isset($_POST['skill_talents'][2]['name']) ? $_POST['skill_talents'][2]['name'] : '' ?>" class="<?= ( empty($_POST['skill_talents'][2]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input readonly type="text" name="skill_talents[2][unlock]" id="unlock" value="<?= isset($_POST['skill_talents'][2]['unlock']) ? $_POST['skill_talents'][2]['unlock'] : 'Elemental Burst' ?>" class="<?= ( empty($_POST['skill_talents'][2]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['skill_talents'][2]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="skill_talents[2][description]" id="description" cols="30" rows="10"><?= isset($_POST['skill_talents'][2]['description']) ? $_POST['skill_talents'][2]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                </div>

                                <div class="extraskill col l12">

                                    <p class="grey-text">* Optional</p>
                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[3][name]" id="name" value="<?= isset($_POST['skill_talents'][3]['name']) ? $_POST['skill_talents'][3]['name'] : '' ?>" class="<?= ( empty($_POST['skill_talents'][3]['name']) && isset($extraSkill_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $extraSkill_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[3][unlock]" id="unlock"  value="<?= isset($_POST['skill_talents'][3]['unlock']) ? $_POST['skill_talents'][3]['unlock'] : '' ?>" class="<?= ( empty($_POST['skill_talents'][3]['unlock']) && isset($extraSkill_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $extraSkill_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['skill_talents'][3]['description']) && isset($extraSkill_err) ) ? 'invalid' : '' ?>" name="skill_talents[3][description]" id="description" cols="30" rows="10"><?= isset($_POST['skill_talents'][3]['description']) ? $_POST['skill_talents'][3]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $extraSkill_err ?? '' ?>"></span>
                                    </div>

                                </div>

                                
                            </div>


                            <h5 class="col s12 m12 l12">Passive Talents</h5>
                            <div class="passive-talents">

                                <div class="extraPassive col l12">

                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[0][name]" id="name" value="<?= isset($_POST['passive_talents'][0]['name']) ? $_POST['passive_talents'][0]['name'] : '' ?>" class="<?= ( empty($_POST['passive_talents'][0]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input readonly type="text" name="passive_talents[0][unlock]" id="unlock" value="<?= isset($_POST['passive_talents'][0]['unlock']) ? $_POST['passive_talents'][0]['unlock'] : 'Unlocked at Ascension 1' ?>" class="<?= ( empty($_POST['passive_talents'][0]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['passive_talents'][0]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="passive_talents[0][description]" id="description" cols="30" rows="10"><?= isset($_POST['passive_talents'][0]['description']) ? $_POST['passive_talents'][0]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                </div>

                                <div class="extraPassive col l12">

                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[1][name]" id="name" value="<?= isset($_POST['passive_talents'][1]['name']) ? $_POST['passive_talents'][1]['name'] : '' ?>" class="<?= ( empty($_POST['passive_talents'][1]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input readonly type="text" name="passive_talents[1][unlock]" id="unlock" value="<?= isset($_POST['passive_talents'][1]['unlock']) ? $_POST['passive_talents'][1]['unlock'] : 'Unlocked at Ascension 4' ?>" class="<?= ( empty($_POST['passive_talents'][1]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['passive_talents'][1]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="passive_talents[1][description]" id="description" cols="30" rows="10"><?= isset($_POST['passive_talents'][1]['description']) ? $_POST['passive_talents'][1]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                </div>

                                <div class="extraPassive col l12">

                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[2][name]" id="name" value="<?= isset($_POST['passive_talents'][2]['name']) ? $_POST['passive_talents'][2]['name'] : '' ?>" class="<?= ( empty($_POST['passive_talents'][2]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input readonly type="text" name="passive_talents[2][unlock]" id="unlock" value="<?= isset($_POST['passive_talents'][2]['unlock']) ? $_POST['passive_talents'][2]['unlock'] : 'Unlocked Automatically' ?>" class="<?= ( empty($_POST['passive_talents'][2]['unlock']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['passive_talents'][2]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="passive_talents[2][description]" id="description" cols="30" rows="10"><?= isset($_POST['passive_talents'][2]['description']) ? $_POST['passive_talents'][2]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                </div>

                                <div class="extraPassive col l12">
                                
                                    <p class="grey-text">* Optional</p>
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[3][name]" id="name" value="<?= isset($_POST['passive_talents'][3]['name']) ? $_POST['passive_talents'][3]['name'] : '' ?>" class="<?= ( empty($_POST['passive_talents'][3]['name']) && isset($extraPassive_err) ) ? 'invalid' : '' ?>">
                                        <label for="name">Name</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[3][unlock]" id="unlock"  value="<?= isset($_POST['passive_talents'][3]['unlock']) ? $_POST['passive_talents'][3]['unlock'] : '' ?>" class="<?= ( empty($_POST['passive_talents'][3]['unlock']) && isset($extraPassive_err) ) ? 'invalid' : '' ?>">
                                        <label for="unlock">Unlock</label>
                                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                    </div>

                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea <?= ( empty($_POST['passive_talents'][3]['description']) && isset($extraPassive_err) ) ? 'invalid' : '' ?>" name="passive_talents[3][description]" id="description" cols="30" rows="10"><?= isset($_POST['passive_talents'][3]['description']) ? $_POST['passive_talents'][3]['description'] : '' ?></textarea>
                                        <label for="description">Description</label>
                                        <span class="helper-text" data-error="<?= $extraPassive_err ?? '' ?>"></span>
                                    </div>

                                </div>
                            </div>



                        </div>    
                    </div>


                    <div id="swipe-3" class="col s12">
                        <div class="row">
                            <h5 class="col l12">Constellations</h5>
                            
                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[1][name]" id="name" value="<?= isset($_POST['constellations'][1]['name']) ? $_POST['constellations'][1]['name'] : '' ?>" class="<?= ( empty($_POST['constellations'][1]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[1][unlock]" id="unlock" value="Constellation lvl. 1">
                                    <label for="unlock">Unlock</label>
                                </div>

                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations'][1]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[1][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations'][1]['description']) ? $_POST['constellations'][1]['description'] : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[2][name]" id="name" value="<?= isset($_POST['constellations'][2]['name']) ? $_POST['constellations'][2]['name'] : '' ?>" class="<?= ( empty($_POST['constellations'][2]['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[2][unlock]" id="unlock" value="Constellation lvl. 2">
                                    <label for="unlock">Unlock</label>
                                </div>

                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations'][2]['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[2][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations'][2]['description']) ? $_POST['constellations'][2]['description'] : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[3][name]" id="name" value="<?= isset($_POST['constellations']['3']['name']) ? $_POST['constellations']['3']['name'] : '' ?>" class="<?= ( empty($_POST['constellations']['3']['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[3][unlock]" id="unlock" value="Constellation lvl. 3">
                                    <label for="unlock">Unlock</label>
                                </div>

                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations']['3']['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[3][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations']['3']['description']) ? $_POST['constellations']['3']['description'] : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[4][name]" id="name" value="<?= isset($_POST['constellations']['4']['name']) ? $_POST['constellations']['4']['name'] : '' ?>" class="<?= ( empty($_POST['constellations']['4']['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[4][unlock]" id="unlock" value="Constellation lvl. 4">
                                    <label for="unlock">Unlock</label>
                                </div>

                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations']['4']['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[4][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations']['4']['description']) ? $_POST['constellations']['4']['description'] : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[5][name]" id="name" value="<?= isset($_POST['constellations']['5']['name']) ? $_POST['constellations']['5']['name'] : '' ?>" class="<?= ( empty($_POST['constellations']['5']['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[5][unlock]" id="unlock" value="Constellation lvl. 5">
                                    <label for="unlock">Unlock</label>
                                </div>

                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations']['5']['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[5][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations']['5']['description']) ? $_POST['constellations']['5']['description'] : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[6][name]" id="name" value="<?= isset($_POST['constellations']['6']['name']) ? $_POST['constellations']['6']['name'] : '' ?>" class="<?= ( empty($_POST['constellations']['6']['name']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                                    <label for="name">Name</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[6][unlock]" id="unlock" value="Constellation lvl. 6">
                                    <label for="unlock">Unlock</label>
                                </div>

                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea <?= ( empty($_POST['constellations']['6']['description']) && isset($empty_err) ) ? 'invalid' : '' ?>" name="constellations[6][description]" id="description" cols="30" rows="10"><?= isset($_POST['constellations']['6']['description']) ? $_POST['constellations']['6']['description'] : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                                </div>

                            </div>


                        </div>
                    </div>


                    <div id="swipe-4" class="col s12">
                        <div class="row">
                                <div class="file-field input-field col l6">
                                    <div class="btn">
                                        <span>Icon</span>
                                        <input type="file" name="icon">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input type="text" class="file-path validate" accept="image/*">
                                    </div>
                                </div>
                                <div class="file-field input-field col l6">
                                    <div class="btn">
                                        <span>Portrait</span>
                                        <input type="file" name="portrait">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input type="text" class="file-path validate"  accept="image/*">
                                    </div>
                                </div>
                            <div class="input-field col l12">
                                <input type="submit" value="Submit" name="submit" class="btn-small green">
                            </div>
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
