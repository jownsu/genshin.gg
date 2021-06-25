<?php require_once("includes/header.php"); ?>

<?php
    if(isset($_POST['submit'])){


        if($character = Character::add($_POST)){
            if( isset($_FILES['icon']) && is_uploaded_file($_FILES['icon']['tmp_name']) ){
               if( !$character->upload($_FILES['icon'], 'icon') ){
                    // print_r($character->errors);
                    $session->set_message("<p class='red-text'>" . implode("<br>", $character->errors) . "</p>");
               } 
            }
    
            if( isset($_FILES['portrait']) && is_uploaded_file($_FILES['portrait']['tmp_name']) ){
                if( !$character->upload($_FILES['portrait'], 'portrait') ){
                    // print_r($character->errors);
                    $session->set_message("<p class='red-text'>" . implode("<br>", $character->errors) . "</p>");
                }
            }
            $session->set_message("<p class='green-text'> Character $character->name was Added </p>");
            header('location: add_character.php');
        }else{
            // print_r($character->get_errors());
            $session->set_message("<p class='red-text'> There was an error adding the character </p>");
        }
    }

    $ek_count = 0;

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
                                <input type="text" id="name" name="name">
                                <label for="name">Name</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <input type="text" id="nickname" name="nickname">
                                <label for="nickname">Nickname</label>
                            </div>
                            <div class="input-field col l12 s12">
                                <input type="text" id="description" name="description">
                                <label for="description">Description</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="4 Star">4 Star</option>
                                    <option value="5 Star">5 Star</option>
                                </select>
                                <label>Rarity</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="weapon" name="weapon">
                                    <option value="Bow">Bow</option>
                                    <option value="Catalyst">Catalyst</option>
                                    <option value="Claymore">Claymore</option>
                                    <option value="Polearm">Polearm</option>
                                    <option value="Sword">Sword</option>
                                </select>
                                <label>Weapon</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <select id="element" name="vision">
                                    <option value="Anemo">Anemo</option>
                                    <option value="Cryo">Cryo</option>
                                    <option value="Dendro">Dendro</option>
                                    <option value="Electro">Electro</option>
                                    <option value="Geo">Geo</option>
                                    <option value="Hydro">Hydro</option>
                                    <option value="Pyro">Pyro</option>
                                </select>
                                <label>Element</label>
                            </div>


                            <h5 class="col l12">Additional Information</h5>


                            <div class="input-field col l6 s12">
                                <select id="sex" name="sex">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label>Sex</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="constellation" name="constellation">
                                <label for="constellation">Constellation</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="nation" name="nation">
                                <label for="nation">Nation</label>
                            </div>

                            <div class="input-field col l6 s12">
                                <input type="text" id="affiliation" name="affiliation">
                                <label for="affiliation">Affiliation</label>
                            </div>

                            <div class="input-field col l3 s6">
                                <select name="birthday[month]" id="birthday-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>"><?= $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="birthday-month">Birthday</label>
                            </div>

                            <div class="input-field col l3 s6">
                                <select name="birthday[day]" id="birthday-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>"><?= $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[month]" id="release-date-month">
                                    <?php foreach(MONTHS as $month): ?>
                                        <option value="<?= $month ?>"><?=  $month ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label for="release-date-month">Release Date</label>
                            </div>
                            

                            <div class="input-field col l2 s4">
                                <select name="release_date[day]" id="release-date-day">
                                    <?php foreach(DAYS as $day): ?>
                                        <option value="<?= $day ?>"><?= $day ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l2 s4">
                                <select name="release_date[year]" id="release-date-year">
                                    <?php foreach(YEARS as $year): ?>
                                        <option value="<?= $year ?>"><?= $year ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-field col l6 s12">
                                <select id="tier" name="tier">
                                    <option value="S">S</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
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
                                        <input type="text" name="skill_talents[normal_attack][name]" id="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input readonly type="text" name="skill_talents[normal_attack][unlock]" id="unlock" value="Normal Attack">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="skill_talents[normal_attack][description]" id="description" cols="30" rows="10"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                                
                                <div class="extraskill col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[elemental_skill][name]" id="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input readonly type="text" name="skill_talents[elemental_skill][unlock]" id="unlock" value="Elemental Skill">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="skill_talents[elemental_skill][description]" id="description" cols="30" rows="10"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>

                                <div class="extraskill col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="skill_talents[elemental_burst][name]" id="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input readonly type="text" name="skill_talents[elemental_burst][unlock]" id="unlock" value="Elemental Burst">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="skill_talents[elemental_burst][description]" id="description" cols="30" rows="10"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>

                                
                            </div>


                            <div class="col l12">
                                <a href="#" class="btn-small green" id="addSkill">Add more skill</a>
                            </div>


                            <h5 class="col s12 m12 l12">Passive Talents</h5>
                            <div class="passive-talents">        
                                <div class="extraPassive col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[asc_one][name]" id="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input readonly type="text" name="passive_talents[asc_one][unlock]" id="unlock" value="Unlocked at Ascension 1">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="passive_talents[asc_one][description]" id="description" cols="30" rows="10"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>

                                <div class="extraPassive col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[asc_four][name]" id="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input readonly type="text" name="passive_talents[asc_four][unlock]" id="unlock" value="Unlocked at Ascension 4">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="passive_talents[asc_four][description]" id="description" cols="30" rows="10"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>

                                <div class="extraPassive col l12">
                                    <div class="input-field col l3">
                                        <input type="text" name="passive_talents[asc_auto][name]" id="name">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input readonly type="text" name="passive_talents[asc_auto][unlock]" id="unlock" value="Unlocked Automatically">
                                        <label for="unlock">Unlock</label>
                                    </div>
                                    <div class="input-field col l12">
                                        <textarea class="materialize-textarea" name="passive_talents[asc_auto][description]" id="description" cols="30" rows="10"></textarea>
                                        <label for="description">Description</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col l12">
                                <a href="#" class="btn-small green" id="addPassive">Add more passive</a>
                            </div>

                        </div>    
                    </div>


                    <div id="swipe-3" class="col s12">
                        <div class="row">
                            <h5 class="col l12">Constellations</h5>
                            
                            <div class="constellation col l12">
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[1][name]" id="name">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[1][unlock]" id="unlock" value="Constellation lvl. 1">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[1][description]" id="description" cols="30" rows="10"></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[2][name]" id="name">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[2][unlock]" id="unlock" value="Constellation lvl. 2">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[2][description]" id="description" cols="30" rows="10"></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="constellation col l12">

                                <div class="input-field col l3">
                                    <input type="text" name="constellations[3][name]" id="name">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[3][unlock]" id="unlock" value="Constellation lvl. 3">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[3][description]" id="description" cols="30" rows="10"></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="constellation col l12">
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[4][name]" id="name">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[4][unlock]" id="unlock" value="Constellation lvl. 4">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[4][description]" id="description" cols="30" rows="10"></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="constellation col l12">
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[5][name]" id="name">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[5][unlock]" id="unlock" value="Constellation lvl. 5">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[5][description]" id="description" cols="30" rows="10"></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="constellation col l12">
                                <div class="input-field col l3">
                                    <input type="text" name="constellations[6][name]" id="name">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col l3">
                                    <input readonly type="text" name="constellations[6][unlock]" id="unlock" value="Constellation lvl. 6">
                                    <label for="unlock">Unlock</label>
                                </div>
                                <div class="input-field col l12">
                                    <textarea class="materialize-textarea" name="constellations[6][description]" id="description" cols="30" rows="10"></textarea>
                                    <label for="description">Description</label>
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
