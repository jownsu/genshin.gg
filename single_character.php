
<?php 
    require_once("includes/header.php");
    require_once("includes/navigation.php");
    
    if(isset($_GET['id'])){
        $character = Character::find($_GET['id']);
        if(empty($character)){
            header("Location: index.php");
        }
    }    
?>

    <main>



    <div class="character-container blue-grey darken-3">
        <div class="single-char-header blue-grey darken-4">

                <a href="#" class='character-portrait'>
                    <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                    <img src="<?= $character->Rarity() ?>" alt="<?= $character->rarity ?>" class="character-rarity">
                    <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                </a>

                <div class="single-char-info">
                    <p><?= $character->name ?></p>
                    <p><?= $character->nickname ?></p>
                    <p><?= $character->vision ?> * <?= $character->weapon ?></p>
                </div>

                <div class="single-char-tier red"><?= $character->tier ?></div>

        </div>

        <h5>Overview</h5>
        <p><?= $character->description ?></p>

        <h5>Skill Talents</h5>
        <div class="talent-container row">
            <?php
                $skills = json_decode($character->skillTalents);
                foreach($skills as $skill): 
            ?>
            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text"><?= $skill->name ?></h6>
                    <p class="grey-text">Unlock: <?= $skill->unlock ?></h6>
                    <p class="left-align"><?= nl2br($skill->description) ?></p>
                </div>
            </div>  
            
            <?php endforeach ?>
        </div>


        <h5>Passive Talents</h5>
        <div class="talent-container row">

            <?php
            $passives = json_decode($character->passiveTalents);
            foreach($passives as $passive): 
            
            ?>
            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text"><?= $passive->name ?></h6>
                    <p class="grey-text">Unlock: <? $passive->unlock ?></h6>
                    <p class="left-align"><?= nl2br($passive->description) ?></p>
                </div>
            </div>  
            <?php endforeach ?>

        </div>




        <h5>Constellations</h5>
        <div class="talent-container row">
            <?php

            $constellations = json_decode($character->constellations);
            foreach($constellations as $constellation): 
            ?>
            <div class="col s12 m12 l4 s">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text"><?= $constellation->name ?></h6>
                    <p class="grey-text">Unlock: <?= $constellation->unlock ?></h6>
                    <p class="left-align"><?= nl2br($constellation->description) ?></p>
                </div>
            </div>

            <?php endforeach ?>
        </div>

    </div>
 

    </main>
    <script>
  


    </script>
<?php require_once("includes/footer.php"); ?>

 