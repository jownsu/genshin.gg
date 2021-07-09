<?php require_once("includes/header.php"); ?>
<?php 
    $navActive = "artifacts";
    require_once("includes/navigation.php"); 
    
    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;

    $artifacts = Artifact::orderBy('name')->paginate($item_per_page)->get();
    $total_page = Artifact::count()->total_page($item_per_page);
?>

    <main>

        <div class="character-container blue-grey darken-3 z-depth-4">
                <div class="row">
                    <div class="col s12 l6">
                        <h5 class="white-text">Artifacts List</h5>
                    </div>

                </div>
                <div class="artifacts-overview blue-grey darken-4 z-depth-2">
                    <p>There are 5 slots of gear in Genshin Impact: Flower, Plume, Sands, Goblet, and Circlet. While Flowers will also have flat HP as their main stat, and Plumes will always have flat ATK as their main stat, the other pieces have different options. Keep in mind that a piece of gear can never have the same main and secondary stat.</p>
                    <ul>
                        <li><b>Flower:</b> HP</li>
                        <li><b>Plume:</b> ATK</li>
                        <li><b>Sands:</b> ATK / ATK% / DEF / DEF% / HP / HP% / Energy Recharge / Elemental Mastery</li>
                        <li><b>Goblet:</b> ATK% / DEF% / HP% / Elemental Mastery, Elemental DMG% (Electro, Hydro, etc)</li>
                        <li><b>Circlet:</b> ATK% / DEF% / HP% / CRIT Chance / CRIT DMG / Elemental Mastery / Healing Bonus</li>
                    </ul>
                </div>
                <div class="info-table">
                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Set</th>
                                <th>MaxRarity</th>
                                <th>2-Piece Bonus</th>
                                <th>4-Piece Bonus</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(!empty($artifacts)):
                                foreach($artifacts as $artifact):
                        ?>
                            <tr>
                                <td>
                                    <div class="weapon-container">
                                        <img src="admin/images/artifacts/<?= $artifact->name ?>/icon" class="character-icon" alt="">
                                        <p><?= $artifact->name ?></p> 
                                    </div>    
                                </td>
                                <td><img class="rarity" src="admin/images/<?= $artifact->max_rarity ?> Star.png" alt=""></td>
                                <td><?= $artifact->two_piece_bonus ?></td>
                                <td><?= $artifact->four_piece_bonus ?></td>
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
                            <li class="waves-effect"><a href="artifacts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
                        <?php endif ?>

                        <?php for($i = 1; $i <= $total_page; $i++): ?>
                            <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="artifacts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endfor ?>

                        <?php if( $page < $total_page ):?>
                            <li class="waves-effect"><a href="artifacts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
                        <?php endif ?>
            </ul>
    </div>
</div>
        </div>
    </main>
    
    <?php require_once("includes/footer.php"); ?>

 