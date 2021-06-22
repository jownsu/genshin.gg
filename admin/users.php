<?php require_once("includes/header.php"); ?>

<?php
    if($session->role != 'Admin'){
        header("Location: index.php");
    }

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $where = ["username LIKE %$search%", "firstname LIKE %$search%"];

        $users = User::where(["username LIKE %$search%"])
            ->orWhere(["firstname LIKE %$search%"])
            ->orWhere(["lastname LIKE %$search%"])
            ->orderBy('username')->paginate(5)->get();
            
        $total_page = User::count()->where(["username LIKE %$search%"])
        ->orWhere(["firstname LIKE %$search%"])
        ->orWhere(["lastname LIKE %$search%"]) 
        ->total_page(5);

    }else{
        $users = User::orderBy('username')->paginate(5)->get();
        $total_page = User::count()->total_page(5);
    }


?>

    <div class="table-container">

        <h2>Users</h2>
        <a href="add_user.php" class="btn-small green waves-effect">Add new user</a>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search" value="<?= isset($search) ? $search : '' ?>">
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

                if(empty($users)){
                    die("No records found");
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
            <?php if($page > 1):?>
                <li class="waves-effect"><a href="users.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="users.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($page < $total_page):?>
                <li class="waves-effect"><a href="users.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>


<?php require_once("includes/footer.php"); ?>