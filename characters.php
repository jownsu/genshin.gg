<?php require_once("includes/header.php"); ?>
<?php 
    $navActive = "characters";
    require_once("includes/navigation.php"); ?>

    <main>

        <div class="character-container blue-grey darken-3">
                <div class="row">
                    <div class="col s12 l6">
                        <h5 class="white-text">Character List</h5>
                    </div>

                </div>

                <div class="charNav row blue-grey darken-4">
                    <div class="elemList">
                        <img class="tooltipped" src="admin/images/Elements/Anemo.png" alt="anemo" data-position='top' data-tooltip='Anemo'>                            
                        <img class="tooltipped" src="admin/images/Elements/Cryo.png" alt="cryo" data-position='top' data-tooltip='Cryo'>                             
                        <img class="tooltipped" src="admin/images/Elements/Dendro.png" alt="dendro" data-position='top' data-tooltip='Dendro'>                             
                        <img class="tooltipped" src="admin/images/Elements/Electro.png" alt="electro" data-position='top' data-tooltip='Electro'>                             
                        <img class="tooltipped" src="admin/images/Elements/Geo.png" alt="geo" data-position='top' data-tooltip='Geo'>                             
                        <img class="tooltipped" src="admin/images/Elements/Hydro.png" alt="hydro" data-position='top' data-tooltip='Hydro'>                             
                        <img class="tooltipped" src="admin/images/Elements/Pyro.png" alt="pyro" data-position='top' data-tooltip='Pyro'>       
                    </div>
                    <div class="weapList">
                        <img class="tooltipped" src="admin/images/Weapons/Bow.png" alt="Bow" data-position='top' data-tooltip='Bow'>
                        <img class="tooltipped" src="admin/images/Weapons/Catalyst.png" alt="Catalyst" data-position='top' data-tooltip='Catalyst'>
                        <img class="tooltipped" src="admin/images/Weapons/Claymore.png" alt="Claymore" data-position='top' data-tooltip='Claymore'>
                        <img class="tooltipped" src="admin/images/Weapons/Polearm.png" alt="Polearm" data-position='top' data-tooltip='Polearm'>
                        <img class="tooltipped" src="admin/images/Weapons/Sword.png" alt="Sword" data-position='top' data-tooltip='Sword'>
                    </div>
                </div>

                <div class="char-modal">
                <div class="characters-list">
                    <?php 
                        $characters = Character::orderBy('name')->get();
                        foreach($characters as $character):;
                    ?>
                    <a href="#charInfoModal" class='character-portrait modal-trigger' data-id="<?= $character->char_id ?>" data-element="<?=$character->element?>" data-weapon="<?=$character->weapon?>">
                        <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                        <span class="character-name"><?= $character->name ?></span>
                        <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                    </a>

                    <?php endforeach ?>
                </div>
                </div>
        </div>


        <div id="charInfoModal" class="modal modalCharInfo black-text">
            <div class='modal-content'>
                <div class='row'>
                    <div class='col l4 m12 s12 center-align'>
                        <img src='admin/images/Portraits/portrait_placeholder.png' alt='' class='character-modal-portrait' id="portrait">
                    </div>

                <div class='col l6 m12 s12 offset-l2 center-align'>
            <div class='row'>
                <div class='col s12'>
                    <h1 class='modal-charName' id='name'>Unknown</h1>
                    <h5 class='modal-charNickname' id='nickname'>???</h5>
                </div>
                <div class='common-info'>
                    <div class='col s4 rarity'>
                        <p>Rarity</p>
                        <img src='' alt='' id='rarity'>
                    </div>
                    <div class='col s4 weapon'>
                        <p>Weapon</p>
                        <img src='' alt='' id='weapon'>
                    </div>
                    <div class='col s4 element'>
                        <p>Element</p>
                        <img src='' alt='' id='element'>
                    </div>
                </div>

                <div class='col s12 main-info'>
                    <table>
                        <tr>
                            <th>Sex</th>
                            <td id="sex">???</td>
                        </tr>
                        <tr>
                            <th>Birthday</th>
                            <td id="birthday">???</td>
                        </tr>
                        <tr>
                            <th>Constellation</th>
                            <td id="constellation">???</td>
                        </tr>
                        <tr>
                            <th>Nation</th>
                            <td id="nation">???</td>
                        </tr>
                        <tr>
                            <th>Affiliation</th>
                            <td id="affiliation">???</td>
                        </tr>
                        <tr>
                            <th>Release Date</th>
                            <td id='release_date'>???</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </main>
    
    <?php require_once("includes/footer.php"); ?>

 