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

        // if(!empty($_FILES['file-thumbnail']['name'])){
        //     $character->set_thumbnail($_FILES['file-thumbnail']);
        // }
        // if(!empty($_FILES['file-portrait']['name'])){
        //     $character->set_portrait($_FILES['file-portrait']);
        // }

        if($uCharacter = Character::edit($character, $_POST)){

            header("location: characters.php");

            $session->set_message("<p class='green-text'>Character $uCharacter->name updated!</p>");
        }else{
            $session->set_message("<p class='red-text'>There is an error updating the character</p>");
        }
    }

    if(isset($_POST['delete'])){
        if($character->delete()){
            $session->set_message("<p class='green-text'> Character " . $character->name . " has been deleted </p>");
            header('Location: characters.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the character</p>'");
        }
    }

?>


    <div class="table-container">

            <h4>Edit Character</h4>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" id="targetId" value="<?= $character->char_id ?>">
                <div class="row">
                    <div class="col l6 s12">
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <input type="text" id="name" name="name" value="<?= $character->name ?>">
                                <label for="name">Name</label>
                            </div>
                            <div class="input-field col l6 s12">
                                <input type="text" id="nickname" name="nickname" value="<?= $character->nickname ?>">
                                <label for="nickname">Nickname</label>
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
                                <select id="tier" name="tier">
                                <?php foreach(TIERS as $tier): ?>
                                    <option value="<?= $tier ?>" <?= $tier == $character->tier ? 'selected' : '' ?> ><?= $tier ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Tier</label>
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
                        </div>
                        <div class="row">
                            <div class="input-field col l6 s12">
                                <select id="sex" name="sex">
                                <?php foreach(SEX as $sex): ?>
                                    <option value="<?= $sex ?>" <?= $sex == $character->sex ? 'selected' : '' ?>><?= $sex ?></option>
                                <?php endforeach ?> 
                                </select>
                                <label>Sex</label>
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
                            
                                <input type="submit" value="Update" name="update" class="btn-small green">
                                <button data-target="delete-char-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                        </div>
                    </div>
                    <div class="col l6 s12 editCharacterPhotosContainer">
                        <img class="edit-thumbnail" src="<?= $character->Thumbnail() ?>" alt="<?= $character->name ?>">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Thumbnail</span>
                                <input type="file" name="file-thumbnail">
                            </div>
                            <div class="file-path-wrapper">
                                <input type="text" class="file-path validate" accept="image/*">
                            </div>
                        </div>
                        <img class="edit-portrait" src="<?= $character->Portrait() ?>" alt="<?= $character->name ?>">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Portrait</span>
                                <input type="file" name="file-portrait">
                            </div>
                            <div class="file-path-wrapper">
                                <input type="text" class="file-path validate" accept="image/*">
                            </div>
                        </div> 
                    </div>
                </div>
            </form>
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

<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php"); ?>
