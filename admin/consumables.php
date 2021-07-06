<?php require_once("includes/header.php"); ?>

<?php

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $consumables = Consumable::where(["name LIKE %$search%"])->orderBy('name')->paginate($item_per_page)->get();
            
        $total_page = Consumable::count()->where(["name LIKE %$search%"])->total_page($item_per_page);

    }else{
        $consumables = Consumable::orderBy('name')->paginate($item_per_page)->get();
        $total_page = Consumable::count()->total_page($item_per_page);
    }


?>

    <div class="table-container">

        <h2>Consumables</h2>
        <a href="add_consumable.php" class="btn-small green waves-effect">Add new consumable</a>
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
                    <th>Consumable</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Rarity</th>
                    <th>Bonus</th>
                    <th>Ingredients</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
            <?php

                if(empty($consumables)){
                    die("No records found");
                }
                foreach($consumables as $consumable):
            ?>

                <tr>
                    <td><?= $consumable->con_id ?></td>
                    <td><img src="<?= $consumable->consumables_img() ?>" alt="<?= $consumable->name ?>" class="table-img-thumbnail"></td>
                    <td><?= $consumable->name ?></td>
                    <td><?= $consumable->category ?></td>
                    <td><?= $consumable->type ?></td>
                    <td><img src="<?= $consumable->rarity() ?>" alt="<?= $consumable->rarity ?>" class="table-star"></td>
                    <td><?= $consumable->bonus ?></td>
                    <td><?= $consumable->ingredients ?></td>
                    <td>
                        <a href="edit_consumable.php?id=<?= $consumable->con_id ?>" class="btn-small blue"><i class="material-icons">update</i></a>
                        <input type="hidden" name="consumables" value="<?= $consumable->con_id ?>">
                        <button data-target="delete-modal" data-name="<?= $consumable->name ?>" class="btn-small red modal-trigger btn-delete"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        
        <ul class="pagination center-align">
            <?php if($page > 1):?>
                <li class="waves-effect"><a href="consumables.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="consumables.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($page < $total_page):?>
                <li class="waves-effect"><a href="consumables.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>