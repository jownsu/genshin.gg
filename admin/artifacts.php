<?php require_once("includes/header.php"); ?>

<?php


    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 10;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $artifacts = Artifact::where(["name LIKE %$search%"])->orderBy('name')->paginate($item_per_page)->get();
            
        $total_page = Artifact::count()->where(["name LIKE %$search%"])->total_page($item_per_page);

    }else{
        $artifacts = Artifact::orderBy('name')->paginate($item_per_page)->get();
        $total_page = Artifact::count()->total_page($item_per_page);
    }


?>

    <div class="table-container">

        <h2>Artifacts</h2>
        <a href="add_artifact.php" class="btn-small green waves-effect">Add new artifact</a>
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
                    <th>Artifact</th>
                    <th>Max Rarity</th>
                    <th>2 Piece Bonus</th>
                    <th>4 Piece Bonus</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
            <?php

                if(empty($artifacts)){
                    die("No records found");
                }
                foreach($artifacts as $artifact):
            ?>

                <tr>
                    <td><?= $artifact->artif_id ?></td>
                    <td><img src="<?= $artifact->artifact_img() ?>" alt="<?= $artifact->name ?>" class="table-img-thumbnail"></td>
                    <td><?= $artifact->name ?></td>
                    <td><img src="<?= $artifact->rarity() ?>" alt="<?= $artifact->rarity ?>" class="table-star"></td>
                    <td><?= $artifact->two_piece_bonus ?></td>
                    <td><?= $artifact->four_piece_bonus ?></td>
                    <td>
                        <a href="edit_artifact.php?id=<?= $artifact->artif_id ?>" class="btn-small blue"><i class="material-icons">update</i></a>
                        <input type="hidden" name="artifacts" value="<?= $artifact->artif_id ?>">
                        <button data-target="delete-modal" data-name="<?= $artifact->name ?>" class="btn-small red modal-trigger btn-delete"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        
        <ul class="pagination center-align">
            <?php if($page > 1):?>
                <li class="waves-effect"><a href="artifacts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="artifacts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($page < $total_page):?>
                <li class="waves-effect"><a href="artifacts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>