<?php require_once("includes/header.php"); ?>

<?php

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $weapons = Weapon::where(["name LIKE %$search%"])->orderBy('name')->paginate($item_per_page)->get();
            
        $total_page = Weapon::count()->where(["name LIKE %$search%"])->total_page($item_per_page);

    }else{
        $weapons = Weapon::orderBy('name')->paginate($item_per_page)->get();
        $total_page = Weapon::count()->total_page($item_per_page);
    }


?>

    <div class="table-container">

        <h2>Weapons</h2>
        <a href="add_weapon.php" class="btn-small green waves-effect">Add new weapon</a>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search" value="<?= isset($search) ? $search : '' ?>">
                <label class="active" for="search">Search...</label>
            </div>
        </form>
        <table class="highlight centered responsive-table user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Weapon</th>
                    <th>Type</th>
                    <th>Rarity</th>
                    <th>Sub Stat</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
            <?php

                if(empty($weapons)){
                    die("No records found");
                }
                foreach($weapons as $weapon):
            ?>

                <tr>
                    <td><?= $weapon->weap_id ?></td>
                    <td><img src="<?= $weapon->weapon_img() ?>" alt="<?= $weapon->name ?>" class="table-img-thumbnail"></td>
                    <td><?= $weapon->name ?></td>
                    <td><?= $weapon->type ?></td>
                    <td><img src="<?= $weapon->rarity() ?>" alt="<?= $weapon->rarity ?>" class="table-star"></td>
                    <td><?= $weapon->subStat ?></td>
                    <td><?= $weapon->location ?></td>
                    <td>
                        <a href="edit_weapon.php?id=<?= $weapon->weap_id ?>" class="btn-small blue"><i class="material-icons">update</i></a>
                        <input type="hidden" name="weapId" value="<?= $weapon->weap_id ?>">
                        <button data-target="delete-modal" data-name="<?= $weapon->name ?>" class="btn-small red modal-trigger btn-delete"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        
        <ul class="pagination center-align">
            <?php if($page > 1):?>
                <li class="waves-effect"><a href="weapons.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="weapons.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($page < $total_page):?>
                <li class="waves-effect"><a href="weapons.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>