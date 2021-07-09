<?php require_once("includes/header.php"); ?>
<?php 
    $navActive = "foods";
    require_once("includes/navigation.php"); 

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;
    
    $foods = Consumable::where(['category = Food'])->orderBy('name')->paginate($item_per_page)->get();
    $total_page = Consumable::count()->where(['category = Food'])->total_page($item_per_page);
?>

    <main>

        <div class="character-container blue-grey darken-3 z-depth-4">
                <div class="row">
                    <div class="col s12 l6">
                        <h5 class="white-text">Food Consumables List</h5>
                    </div>

                </div>
                <div class="artifacts-overview blue-grey darken-4 z-depth-2">
                    <p>Without a healer in your team, cooking becomes essential to staying healthy 
                        and reviving fallen allies. It can also provide significant boosts to a wide variety of stats including Stamina consumption, 
                        ATK, DEF, and CRIT Rate. You can cook and process ingredients at any cooking stations found scattered throughout the map. As listed below, 
                        some characters create enhanced versions of certain dishes.</p>

                </div>
                <div class="info-table">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Consumable</th>
                                <th>Type</th>
                                <th>Rarity</th>
                                <th>Bonus</th>
                                <th>Ingredients</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(!empty($foods)):
                                foreach($foods as $food):
                        ?>
                            <tr>
                                <td>
                                    <div class="weapon-container">
                                        <img src="<?= $food->consumables_img() ?>" class="character-icon" alt="">
                                        <p><?= $food->name ?></p> 
                                    </div>    
                                </td>
                                <td><?= $food->type ?></td>
                                <td><img class="rarity" src="admin/images/<?= $food->rarity ?> Star.png" alt=""></td>
                                <td><?= $food->bonus?></td>
                                <td><?= $food->ingredients ?></td>
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
                        <li class="waves-effect"><a href="foods.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
                    <?php endif ?>

                    <?php for($i = 1; $i <= $total_page; $i++): ?>
                        <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="foods.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor ?>

                    <?php if( $page < $total_page ):?>
                        <li class="waves-effect"><a href="foods.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
                    <?php endif ?>
                </ul>
    </div>
</div>
        </div>
    </main>
    
    <?php require_once("includes/footer.php"); ?>

 