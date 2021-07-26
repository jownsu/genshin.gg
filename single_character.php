
<?php 
    require_once("includes/header.php");
    require_once("includes/navigation.php");
    
    if(isset($_GET['id'])){
        $character = Character::find($_GET['id']);
        if(empty($character)){
            header("Location: index.php");
        }

        $color = [  'Anemo' => '#76FFD7',
                    'Cryo' => '#99FFF9',
                    'Electro' => '#FFACE6',
                    'Geo' => '#FFE699',
                    'Hydro' => '#80C0FF',
                    'Pyro' => '#FF9991' ];
        $tierBG = [ 'S' => '#FF7F7F',
                    'A' => '#FFBF7F',
                    'B' => '#FFFF7F',
                    'C' => '#BFFF7F',
                    'D' => '#7FFF7F'    ];
    }    
?>

    <main>



    <div class="character-container blue-grey darken-3 z-depth-4">
        <div class="single-char-header blue-grey darken-4 z-depth-2">

                <a href="#" class='character-portrait'>
                    <img src="<?= $character->Thumbnail() ?>" class='character-icon responsive-img' alt="<?= $character->name ?>">
                    <img src="<?= $character->Rarity() ?>" alt="<?= $character->rarity ?>" class="rarity">
                    <img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="character-element">
                </a>

                <div class="single-char-info">
                    <p class="char_name" style="color: <?= $color[$character->vision] ?>"><?= $character->name ?></p>
                    <p><?= $character->nickname ?></p>
                    <p><span style="color: <?= $color[$character->vision] ?>"><?= $character->vision ?></span> * <?= $character->weapon ?></p>
                </div>

                <div class="single-char-tier" style="background: <?= $tierBG[$character->tier] ?>"><?= $character->tier ?></div>

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
                <div class="talent-info blue-grey darken-4 center-align z-depth-2">
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
                <div class="talent-info blue-grey darken-4 center-align z-depth-2">
                    <h6 class="yellow-text"><?= $passive->name ?></h6>
                    <p class="grey-text">Unlock: <?= $passive->unlock ?></h6>
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
                <div class="constellation-info blue-grey darken-4 center-align z-depth-2">
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

 