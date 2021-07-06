<?php require_once("includes/header.php"); ?>

<?php

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 5;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $characters = Character::where(["name LIKE %$search%"])->orderBy('name')->paginate($item_per_page)->get();
        $total_page = Character::count()->where(["name LIKE %$search%"])->total_page($item_per_page);

    }else{
        $characters = Character::orderBy('name')->paginate($item_per_page)->get();
        $total_page = Character::count()->total_page($item_per_page);
    }

?>
    <div class="table-container">

        <h2>Characters</h2>
        <a href="add_character.php" class="btn-small green waves-effect">Add new character</a>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search" value=<?= isset($search) ? $search : '' ?>>
                <label class="active" for="search">Search...</label>
            </div>
        </form>
        </div>
        <table class="highlight centered responsive-table char-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Rarity</th>
                    <th>Weapon</th>
                    <th>Element</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
            <?php

                if(empty($characters)){
                    die("No Records Found");
                }
                foreach($characters as $character):
            ?>
                <tr>
                    <td><?= $character->char_id ?></td>
                    <td><img src="<?= $character->Thumbnail() ?>" class="table-img-thumbnail" alt="<?= $character->name ?>"></td>
                    <td><?= $character->name ?></td>
                    <td><img src="<?= $character->Rarity() ?>" alt="<?= $character->rarity ?>" class="table-star"></td>
                    <td><img src="<?= $character->Weapon() ?>" alt="<?= $character->weapon ?>" class="table-thumbnails tooltipped" data-position="top" data-tooltip="<?= $character->weapon ?>"></td>
                    <td><img src="<?= $character->Vision() ?>" alt="<?= $character->vision ?>" class="table-thumbnails tooltipped" data-position="top" data-tooltip="<?= $character->vision ?>""></td>
                    <td>
                            <a href="edit-character.php?id=<?= $character->char_id ?>" class="btn-small blue"><i class="material-icons">update</i></a>
                            <input type="hidden" name="characters" value="<?= $character->char_id ?>">
                            <button data-target="delete-modal" data-id="<?= $character->char_id ?>" data-name="<?= $character->name ?>" class="btn-small red modal-trigger btn-delete"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

        <ul class="pagination center-align">
            <?php if( $page > 1 ):?>
                <li class="waves-effect"><a href="characters.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="characters.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if( $page < $total_page ):?>
                <li class="waves-effect"><a href="characters.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>
