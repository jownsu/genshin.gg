<?php require_once("includes/header.php"); ?>
<?php 
    $navActive = "alchemies";
    require_once("includes/navigation.php"); 

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;
    
    $alchemies = Consumable::where(['category = Alchemy'])->orderBy('name')->paginate($item_per_page)->get();
    $total_page = Consumable::count()->where(['category = Alchemy'])->orderBy('name')->total_page($item_per_page);
?>

    <main>

        <div class="character-container blue-grey darken-3 z-depth-4">
                <div class="row">
                    <div class="col s12 l6">
                        <h5 class="white-text">Alchemy Consumables List</h5>
                    </div>

                </div>
                <div class="artifacts-overview blue-grey darken-4 z-depth-2">
                    <p>Alchemy is a great source of potions that provide stat boosts for when you're punching 
                        above your weight or simply doing challenging content. You can also use it to transmute character and 
                        weapon enhancement materials into higher rarity ones. Alchemists are usually located in the major cities.</p>

                </div>
                <div class="weapon-table">
                    <table class="highlight centered">
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
                            if(!empty($alchemies)):
                                foreach($alchemies as $alchemy):
                        ?>
                            <tr>
                                <td>
                                    <div class="weapon-container">
                                        <img src="admin/images/artifacts/<?= $alchemy->name ?>/icon" class="character-icon" alt="">
                                        <p><?= $alchemy->name ?></p> 
                                    </div>    
                                </td>
                                <td><?= $alchemy->type ?></td>
                                <td><img class="rarity" src="admin/images/<?= $alchemy->rarity ?> Star.png" alt=""></td>
                                <td><?= $alchemy->bonus?></td>
                                <td><?= $alchemy->ingredients ?></td>
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
                        <li class="waves-effect"><a href="alchemy.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
                    <?php endif ?>

                    <?php for($i = 1; $i <= $total_page; $i++): ?>
                        <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="alchemy.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor ?>

                    <?php if( $page < $total_page ):?>
                        <li class="waves-effect"><a href="alchemy.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
                    <?php endif ?>
                </ul>
    </div>
</div>
        </div>
    </main>
    
    <?php require_once("includes/footer.php"); ?>

 