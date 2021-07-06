<?php require_once("includes/header.php"); ?>
<?php 
    if($session->role != 'Admin'){
        header("Location: index.php");
    }

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    $item_per_page = 10;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $whereSQL = ["title LIKE %$search%"];

        $posts = Post::where($whereSQL)->orderBy('title')->paginate($item_per_page)->get();
        $total_page = Post::count()->where($whereSQL)->total_page($item_per_page);

    }else{
        $posts = Post::orderBy('title')->paginate($item_per_page)->get();
        $total_page = Post::count()->total_page($item_per_page);
    }
?>
    <div class="table-container">
        <h2>All Posts</h2>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search" value="<?= isset($search) ? $search : '' ?>">
                <label class="active" for="search">Search...</label>
            </div>
        </form>
        <table class="highlight centered responsive-table post-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Comments</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
                <?php
                    if(empty($posts)){
                        die("No records found");
                    }

                foreach($posts as $post): ?>

                <tr>
                    <td><?= $post->post_id ?></td>
                    <td><a href="../single-post.php?id=<?= $post->post_id ?>"><?= $post->title ?></a></td>
                    <td>
                        <?php
                        $tags = $post->post_tags();
                        foreach($tags as $tag): ?>
                        <div class="chip"><?= $tag ?></div>
                        <?php endforeach ?>
                    </td>
                    <td><?= $post->author()->username ?></td>
                    <td><?= $post->post_status ?></td>
                    <td><a href="comments.php?id=<?= $post->post_id ?> "><?= Comment::count()->where(["post_id = $post->post_id"])->get() ?></a></td>
                    <td>
                        <input type="hidden" name="posts" value="<?= $post->post_id ?>">
                        <button data-target="delete-modal" data-id="<?= $post->post_id ?>" data-name="<?= $post->title ?>" class="btn-small red modal-trigger"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
                <?php endforeach ?>             
            </tbody>
        </table>
        <ul class="pagination center-align">
            <?php if($page > 1):?>
                <li class="waves-effect"><a href="all_posts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="all_posts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($page < $total_page):?>
                <li class="waves-effect"><a href="all_posts.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>

<?php require_once("includes/footer.php"); ?>