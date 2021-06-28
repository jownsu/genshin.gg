<?php require_once("includes/header.php"); ?>
<?php 
    $navActive = "characters";
    require_once("includes/navigation.php"); ?>

    <main>

        <div class="character-container blue-grey darken-3 z-depth-4">
                <div class="row">
                    <div class="col s12 l6">
                        <h5 class="white-text">Character List</h5>
                    </div>

                </div>

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
</div>
        </div>
    </main>
    
    <?php require_once("includes/footer.php"); ?>

 