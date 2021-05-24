<?php require_once("includes/header.php"); ?>
<?php 
    if($session->role != 'Admin'){
        header("Location: index.php");
    }

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);
        $search_count = Post::search_count(['title'], $search);
        $paginate = new Paginate($search_count, $page, 10);
        $posts = Post::search_post_by_page(['title'], $search, $paginate);
    }else{
        $total_count = Post::count_all();
        $paginate = new Paginate($total_count, $page, 10);
        $posts = Post::find_posts_by_page($paginate);
    }
?>
    <div class="table-container">
        <h2>All Posts</h2>
        <form method="GET" class="row" style="margin-bottom:0">
            <div class="input-field col l4 m8 s12">
                <i class="material-icons prefix">search</i>
                <input type="text" name="search" id="search">
                <label for="search">Search...</label>
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
                    <td><?= $post->username ?></td>
                    <td><?= $post->post_status ?></td>
                    <td><a href="comments.php?id=<?= $post->post_id ?> "><?= Comment::count_comments_by_post_id($post->post_id) ?></a></td>
                    <td>
                        <input type="hidden" name="postId" value="<?= $post->post_id ?>">
                        <button data-target="delete-modal" data-id="<?= $post->post_id ?>" data-name="<?= $post->title ?>" class="btn-small red modal-trigger"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
                <?php endforeach ?>             
            </tbody>
        </table>
        <ul class="pagination center-align">
            <?php if($paginate->has_previous()):?>
                <li class="waves-effect"><a href="posts.php?page=<?= $paginate->previous() ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $paginate->total_page(); $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="posts.php?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($paginate->has_next()):?>
                <li class="waves-effect"><a href="posts.php?page=<?= $paginate->next() ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>

<?php require_once("includes/footer.php"); ?>