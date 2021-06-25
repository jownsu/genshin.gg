<?php require_once("includes/header.php"); ?>

<?php 
require_once("includes/navigation.php"); ?>

    <main>



    <div class="character-container blue-grey darken-3">
        <div class="single-char-header blue-grey darken-4">

                <a href="#" class='character-portrait'>
                    <img src="admin/images/characters/eula/icon" class='character-icon responsive-img' alt="eula">
                    <img src="admin/images/5 star.png" alt="5 Star" class="character-rarity">
                    <img src="admin/images/Elements/Cryo.png" alt="Cryo" class="character-element">
                </a>

                <div class="single-char-info">
                    <p>Eula</p>
                    <p>Eula Lawrence</p>
                    <p>Cryo * Claymore</p>
                </div>

                <div class="single-char-tier red">S</div>

        </div>

        <h5>Eula Overview</h5>
        <p>The Spindrift Knight, a scion of the old aristocracy, and the Captain of the Knights of Favonius Reconnaissance Company. The reason for which a descendant of the ancient nobles might join the Knights remains a great mystery in Mondstadt to this very day.</p>

        <h5>Eula Skill Talents</h5>
        <div class="talent-container row">
            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Favonius Bladework - Edel</h6>
                    <p class="grey-text">Unlock: Normal Attack</h6>
                    <p class="left-align"><?= nl2br("Normal Attack
                        Perform up to five consecutive strikes.
                        Charged Attack
                        Drains Stamina over time to perform continuous slashes. At the end of the sequence, perform a more powerful slash.
                        Plunging Attack
                        Plunges from mid-air to strike the ground, damaging opponents along the path and dealing AoE DMG upon impact.") ?></p>
                </div>
            </div>  

            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Icetide Vortex</h6>
                    <p class="grey-text">Unlock: Elemental Skill</h6>
                    <p class="left-align"><?= nl2br("Press
                        Slashes swiftly, dealing Cryo DMG. When it hits an opponent, Eula gains a stack of Grimheart that stacks up to two times. These stats can only be gained once every 0.3s.
                        Grimheart
                        Increases Eula's resistance to interruption and DEF.
                        Hold
                        Wielding her sword, Eula consumes all the stacks of Grimheart and lashes forward, dealing AoE Cryo DMG to opponents in front of her. If Grimheart stacks are consumed, surrounding opponents will have their Physical RES and Cryo RES decreased.
                        Each consumed stack of Grimheart will be converted into an Icewhirl Brand that deals Cryo DMG to nearby opponents.") ?></p>
                </div>
            </div>

            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Glacial Illumination</h6>
                    <p class="grey-text">Unlock: Elemental Burst</h6>
                    <p class="left-align"><?= nl2br("Brandishes her greatsword, dealing Cryo DMG to nearby opponents and creating a Lightfall Sword that follows her around for a duration of up to 7s.
                        While present, the Lightfall Sword increases Eula's resistance to interruption. When Eula's own Normal Attack, Elemental Skill, and Elemental Burst deal DMG to opponents, they will charge the Lightfall Sword, which can gain an energy stack once every 0.1s. Once its duration ends, the Lightfall Sword will descend and explode violently, dealing Physical DMG to nearby opponents. This DMG scales on the number of energy stacks the Lightfall Sword has accumulated. If Eula leaves the field, the Lightfall Sword will immediately explode.") ?></p>
                </div>
            </div>

        </div>


        <h5>Eula Passive Talents</h5>
        <div class="talent-container row">
            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Roiling Rime</h6>
                    <p class="grey-text">Unlock: Unlocked at Ascension 1</h6>
                    <p class="left-align"><?= nl2br("If 2 stacks of Grimheart are consumed upon unleashing the Holding Mode of Icetide Vortex, a Shattered Lightfall Sword will be created that will explode immediately, dealing 50% of the basic Physical DMG dealt by a Lightfall Sword created by Glacial Illumination.") ?></p>
                </div>
            </div>  

            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Wellspring of War-Lust</h6>
                    <p class="grey-text">Unlock: Unlocked at Ascension 4</h6>
                    <p class="left-align"><?= nl2br("When Glacial Illumination is cast, the CD of Icetide Vortex is reset and Eula gains 1 stack of Grimheart.") ?></p>
                </div>
            </div>

            <div class="col s12 m12 l4">
                <div class="talent-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Aristocratic Introspection</h6>
                    <p class="grey-text">Unlock: Unlocked Automatically</h6>
                    <p class="left-align"><?= nl2br("Brandishes her greatsword, dealing Cryo DMG to nearby opponents and creating a Lightfall Sword that follows her around for a duration of up to 7s.
                        While present, the Lightfall Sword increases Eula's resistance to interruption. When Eula's own Normal Attack, Elemental Skill, and Elemental Burst deal DMG to opponents, they will charge the Lightfall Sword, which can gain an energy stack once every 0.1s. Once its duration ends, the Lightfall Sword will descend and explode violently, dealing Physical DMG to nearby opponents. This DMG scales on the number of energy stacks the Lightfall Sword has accumulated. If Eula leaves the field, the Lightfall Sword will immediately explode.") ?></p>
                </div>
            </div>

        </div>




        <h5>Eula Constellations</h5>
        <div class="talent-container row">

            <div class="col s12 m12 l4 s">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Tidal Illusion</h6>
                    <p class="grey-text">Unlock: Constellation Lv. 1</h6>
                    <p class="left-align"><?= nl2br("Every time Icetide Vortex's Grimheart stacks are consumed, Eula's Physical DMG is increased by 30% for 6s. Each stack consumed will increase the duration of this effect by 6s up to a maximum of 18s.") ?></p>
                </div>
            </div>

            <div class="col s12 m12 l4">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Lady of Seafoam</h6>
                    <p class="grey-text">Unlock: Constellation Lv. 2</h6>
                    <p class="left-align"><?= nl2br("Decreases the CD of Icetide Vortex's Holding Mode, rendering it identical to Tapping CD.") ?></p>
                </div>
            </div>

            <div class="col s12 m12 l4">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Lawrence Pedigree</h6>
                    <p class="grey-text">Unlock: Constellation Lv. 3</h6>
                    <p class="left-align"><?= nl2br("Increases the Level of Glacial Illumination by 3.
                        Maximum upgrade level is 15.") ?></p>
                </div>
            </div>

            <div class="col s12 m12 l4">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">The Obstinacy of One's Inferiors</h6>
                    <p class="grey-text">Unlock: Constellation Lv. 4</h6>
                    <p class="left-align"><?= nl2br("Lightfall Swords deal 25% increased DMG against opponents with less than 50% HP.") ?></p>
                </div>
            </div>
            
            <div class="col s12 m12 l4">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Chivalric Quality</h6>
                    <p class="grey-text">Unlock: Constellation Lv. 5</h6>
                    <p class="left-align"><?= nl2br("Increases the Level of Icetide Vortex by 3.
                        Maximum upgrade level is 15.") ?></p>
                </div>
            </div>
            
            <div class="col s12 m12 l4">
                <div class="constellation-info blue-grey darken-4 center-align">
                    <h6 class="yellow-text">Noble Obligation</h6>
                    <p class="grey-text">Unlock: Constellation Lv. 6</h6>
                    <p class="left-align"><?= nl2br("Lightfall Swords created by Glacial Illumination start with 5 stacks of energy. Normal Attacks, Elemental Skills, and Elemental Bursts have a 50% chance to grant the Lightning Sword an additional stack of energy.") ?></p>
                </div>
            </div>
            
        </div>

    </div>
 

    </main>
    <script>
  


    </script>
<?php require_once("includes/footer.php"); ?>

 