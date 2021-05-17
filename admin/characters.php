<?php require_once("includes/header.php"); ?>

<?php
    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);
        $search_count = Character::search_count(['name'], $search);
        $paginate = new Paginate($search_count, $page, 10);
        $characters = Character::search_query(['name'], $search, $paginate);
    }else{

        $total_count = Character::count_all();
        $paginate = new Paginate($total_count, $page, 10);
        $characters = Character::find_characters_by_name_and_page($paginate);
    }


?>
    <div class="table-container">

        <h2>Characters</h2>
        <a href="add_character.php" class="btn-small green waves-effect">Add new character</a>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search">
                <label for="search">Search...</label>
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
                    <td><img src="<?= $character->Element() ?>" alt="<?= $character->element ?>" class="table-thumbnails tooltipped" data-position="top" data-tooltip="<?= $character->element ?>""></td>
                    <td>
                            <a href="edit-character.php?id=<?= $character->char_id ?>" class="btn-small blue"><i class="material-icons">update</i></a>
                            <input type="hidden" name="charId" value="<?= $character->char_id ?>">
                            <button data-target="delete-modal" data-id="<?= $character->char_id ?>" data-name="<?= $character->name ?>" class="btn-small red modal-trigger btn-delete"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <ul class="pagination center-align">
            <?php if($paginate->has_previous()):?>
                <li class="waves-effect"><a href="characters.php?page=<?= $paginate->previous() ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $paginate->total_page(); $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="characters.php?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($paginate->has_next()):?>
                <li class="waves-effect"><a href="characters.php?page=<?= $paginate->next() ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>
