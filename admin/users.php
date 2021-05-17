<?php require_once("includes/header.php"); ?>

<?php
    if($session->role != 'Admin'){
        header("Location: index.php");
    }

?>

    <div class="table-container">

        <h2>Users</h2>
        <a href="add_user.php" class="btn-small green waves-effect">Add new user</a>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search">
                <label for="search">Search...</label>
            </div>
        </form>
        <table class="highlight centered responsive-table user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
            <?php
                $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

                $total_count = User::count_all();
                $paginate = new Paginate($total_count, $page, 3);
                $users = User::find_by_page($paginate);
                if(empty($users)){
                    header("location: users.php");
                }
                foreach($users as $user):
            ?>

                <tr>
                    <td><?= $user->user_id ?></td>
                    <td><img src="<?= $user->user_image_path() ?>" alt="<?= $user->username ?>" class="table-img-thumbnail"></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->firstname ?></td>
                    <td><?= $user->lastname ?></td>
                    <td><?= $user->status ?></td>
                    <td>
                        <a href="edit-user.php?id=<?= $user->user_id ?>" class="btn-small blue"><i class="material-icons">update</i></a>
                        <input type="hidden" name="userId" value="<?= $user->user_id ?>">
                        <button data-target="delete-modal" data-name="<?= $user->username ?>" class="btn-small red modal-trigger btn-delete"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        
        <ul class="pagination center-align">
            <?php if($paginate->has_previous()):?>
                <li class="waves-effect"><a href="users.php?page=<?= $paginate->previous() ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $paginate->total_page(); $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="users.php?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($paginate->has_next()):?>
                <li class="waves-effect"><a href="users.php?page=<?= $paginate->next() ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>