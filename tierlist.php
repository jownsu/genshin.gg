<?php require_once("includes/header.php"); ?>

<?php 
$navActive = "tierlist";
require_once("includes/navigation.php"); ?>
    <main>

        <div class="character-container blue-grey darken-3 z-depth-4">
            <div class="row">
                <div class="col s12 l6">
                    <h5 class="white-text">Character Tier List</h5>
                </div>
            </div>
            <?php
                $characters = Character::orderBy('name')->get();
                $S_tier = array_filter($characters, function($c){
                    return $c->tier == 'S';
                });
                $A_tier = array_filter($characters, function($c){
                    return $c->tier == 'A';
                });
                $B_tier = array_filter($characters, function($c){
                    return $c->tier == 'B';
                });
                $C_tier = array_filter($characters, function($c){
                    return $c->tier == 'C';
                });
                $D_tier = array_filter($characters, function($c){
                    return $c->tier == 'D';
                });
            ?>

            <div class="charNav row blue-grey darken-4 z-depth-2">
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
                        <img class="tooltipped" src="admin/images/weapons/Bow.png" alt="Bow" data-position='top' data-tooltip='Bow'>
                        <img class="tooltipped" src="admin/images/weapons/Catalyst.png" alt="Catalyst" data-position='top' data-tooltip='Catalyst'>
                        <img class="tooltipped" src="admin/images/weapons/Claymore.png" alt="Claymore" data-position='top' data-tooltip='Claymore'>
                        <img class="tooltipped" src="admin/images/weapons/Polearm.png" alt="Polearm" data-position='top' data-tooltip='Polearm'>
                        <img class="tooltipped" src="admin/images/weapons/Sword.png" alt="Sword" data-position='top' data-tooltip='Sword'>
                    </div>
            </div>
            
            <h6>Quick View</h6>
            <div class="char-modal">

            <div class="tier-container row z-depth-2">
                <div class="tier valign-wrapper" style="background: #FF7F7F">
                    <span>S</span>
                </div>
                <div class="tier-characters">
                    <?php foreach($S_tier as $character): ?>
                        <a href="single_character.php?id=<?= $character->char_id ?>" class='character-portrait' data-id="<?= $character->char_id ?>" data-element="<?=$character->vision?>" data-weapon="<?=$character->weapon?>">
                            <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                            <span class="character-name"><?= $character->name ?></span>
                            <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                        </a>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="tier-container row z-depth-2">
                <div class="tier valign-wrapper" style="background: #FFBF7F">
                    <span>A</span>
                </div>
                <div class="tier-characters">
                    <?php foreach($A_tier as $character): ?>
                        <a href="single_character.php?id=<?= $character->char_id ?>" class='character-portrait' data-id="<?= $character->char_id ?>" data-element="<?=$character->vision?>" data-weapon="<?=$character->weapon?>">
                            <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                            <span class="character-name"><?= $character->name ?></span>
                            <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                        </a>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="tier-container row z-depth-2">
                <div class="tier valign-wrapper" style="background: #FFFF7F">
                    <span>B</span>
                </div>
                <div class="tier-characters">
                    <?php foreach($B_tier as $character): ?>
                        <a href="single_character.php?id=<?= $character->char_id ?>" class='character-portrait' data-id="<?= $character->char_id ?>" data-element="<?=$character->vision?>" data-weapon="<?=$character->weapon?>">
                            <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                            <span class="character-name"><?= $character->name ?></span>
                            <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                        </a>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="tier-container row z-depth-2">
                <div class="tier valign-wrapper" style="background: #BFFF7F">
                    <span>C</span>
                </div>
                <div class="tier-characters">
                    <?php foreach($C_tier as $character): ?>
                        <a href="single_character.php?id=<?= $character->char_id ?>" class='character-portrait' data-id="<?= $character->char_id ?>" data-element="<?=$character->vision?>" data-weapon="<?=$character->weapon?>">
                            <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                            <span class="character-name"><?= $character->name ?></span>
                            <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                        </a>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="tier-container row z-depth-2">
                <div class="tier valign-wrapper" style="background: #7FFF7F">
                    <span>D</span>
                </div>
                <div class="tier-characters">
                    <?php foreach($D_tier as $character): ?>
                        <a href="single_character.php?id=<?= $character->char_id ?>" class='character-portrait' data-id="<?= $character->char_id ?>" data-element="<?=$character->vision?>" data-weapon="<?=$character->weapon?>">
                            <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                            <span class="character-name"><?= $character->name ?></span>
                            <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
            </div>

        </div>

    </main>
    <script>
  


    </script>
<?php require_once("includes/footer.php"); ?>

 