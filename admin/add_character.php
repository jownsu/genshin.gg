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
            // $session->set_message("<p class='red-text'> There was an error adding the character </p>");
        }
    }
?>


    <div class="table-container">

            <h4>Add Character</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col l6 s12">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name">
                                <label for="name">Name</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <input type="text" id="nickname" name="nickname">
                                <label for="nickname">Nickname</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <select id="rarity" name="rarity">
                                    <option value="4 Star">4 Star</option>
                                    <option value="5 Star">5 Star</option>
                                </select>
                                <label>Rarity</label>
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
                        </div>
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <select id="sex" name="sex">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label>Sex</label>
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
                        </div>
                    </div>
                    <div class="col l6 s12">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Icon</span>
                                <input type="file" name="icon">
                            </div>
                            <div class="file-path-wrapper">
                                <input type="text" class="file-path validate" accept="image/*">
                            </div>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Portrait</span>
                                <input type="file" name="portrait">
                            </div>
                            <div class="file-path-wrapper">
                                <input type="text" class="file-path validate"  accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="submit" value="Submit" name="submit" class="btn-small green">
            </form>
    </div>


<?php require_once("includes/footer.php"); ?>
