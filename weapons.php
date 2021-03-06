<?php require_once("includes/header.php"); ?>
<?php 
    $navActive = "weapons";
    require_once("includes/navigation.php"); 

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);
        $weapons = Weapon::where(["type = $search"])->orderBy('name')->paginate($item_per_page)->get();
        $total_page = Weapon::count()->where(["type = $search"])->total_page($item_per_page);
    }else{
        $weapons = Weapon::orderBy('name')->paginate($item_per_page)->get();
        $total_page = Weapon::count()->total_page($item_per_page);
    }



?>

    <main>

        <div class="character-container blue-grey darken-3 z-depth-4">
                <div class="row">
                    <div class="col s12 l6">
                        <h5 class="white-text">Weapons List</h5>
                    </div>

                </div>

                <div class="weaponNav row blue-grey darken-4 z-depth-2">
                    <div class="weapList">
                        <a href="weapons.php?search=bow"> <img class="tooltipped <?= $search == 'bow' ? 'active' : '' ?>" src="admin/images/weapons/Bow.png" alt="Bow" data-position='top' data-tooltip='Bow'> </a>
                        <a href="weapons.php?search=catalyst"> <img class="tooltipped <?= $search == 'catalyst' ? 'active' : '' ?>" src="admin/images/weapons/Catalyst.png" alt="Catalyst" data-position='top' data-tooltip='Catalyst'> </a>
                        <a href="weapons.php?search=claymore"> <img class="tooltipped <?= $search == 'claymore' ? 'active' : '' ?>" src="admin/images/weapons/Claymore.png" alt="Claymore" data-position='top' data-tooltip='Claymore'> </a>
                        <a href="weapons.php?search=polearm"> <img class="tooltipped <?= $search == 'polearm' ? 'active' : '' ?>" src="admin/images/weapons/Polearm.png" alt="Polearm" data-position='top' data-tooltip='Polearm'> </a>
                        <a href="weapons.php?search=sword"> <img class="tooltipped <?= $search == 'sword' ? 'active' : '' ?>" src="admin/images/weapons/Sword.png" alt="Sword" data-position='top' data-tooltip='Sword'> </a>
                    </div>
                </div>

                <div class="info-table">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Weapon</th>
                                <th>Type</th>
                                <th>Rarity</th>
                                <th>ATK</th>
                                <th>Secondary</th>
                                <th>Passive</th>
                                <th>Bonus</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(!empty($weapons)):
                                foreach($weapons as $weapon):
                        ?>
                            <tr>
                                <td>
                                    <div class="weapon-container">
                                        <img src="<?= $weapon->weapon_img() ?>" class="character-icon" alt="">
                                        <p><?= $weapon->name ?></p> 
                                    </div>    
                                </td>
                                <td><?= $weapon->type ?></td>
                                <td><img class="rarity" src="<?= $weapon->rarity() ?>" alt=""></td>
                                <td><?= $weapon->baseAttack ?></td>
                                <td><?= $weapon->subStat ?></td>
                                <td><?= $weapon->passiveName ?></td>
                                <td><?= $weapon->passiveDesc ?></td>
                                <td><?= $weapon->location ?></td>
                            </tr>

                        <?php
                            endforeach;
                        endif;
                        ?>

                        </tbody>
                    </table>
                </div>

        </div>
                <ul class="pagination center-align">
                    <?php if( $page > 1 ):?>
                        <li class="waves-effect"><a href="weapons.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
                    <?php endif ?>

                    <?php for($i = 1; $i <= $total_page; $i++): ?>
                        <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="weapons.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor ?>

                    <?php if( $page < $total_page ):?>
                        <li class="waves-effect"><a href="weapons.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
                    <?php endif ?>
                </ul>
    </div>
</div>
        </div>
    </main>
    
    <?php require_once("includes/footer.php"); ?>

 