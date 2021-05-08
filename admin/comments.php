<?php require_once("includes/header.php"); ?>
<?php
    if(isset($_GET['id'])){
        $postId = $_GET['id'];

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
        $total_count = Comment::count_comments_by_post_id($postId);

        $paginate = new Paginate($total_count, $page);

        $comments = Comment::find_comments_by_page($postId, $paginate);
        $post = Post::find_by_id($postId);
        if(empty($post)){
            header('location: posts.php');
        }
    }else{
        header('location: posts.php');
    }


?>
    <div class="table-container">
        <h2>Comments</h2>
        <h5>Title: <a href="../single-post.php?id=<?= $postId ?>"><?= $post->title ?></a></h5>
        <h6>Status: <?= $post->status ?></h6>
        <table class="highlight centered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="delete-bubbling-container">
                <?php 
                    if(!empty($comments)):
                        foreach($comments as $comment): ?>
                <tr>
                    <td><?= $comment->comment_id ?></td>
                    <td><?= $comment->username ?></td>
                    <td><?= $comment->description ?></td>
                    <td><?= $comment->date ?></td>
                    <td>
                        <input type="hidden" name="commentId" value="<?= $comment->comment_id ?>">
                        <button data-target="delete-modal" data-id="<?= $comment->comment_id ?>" data-name="<?= $comment->description ?>" class="btn-small red modal-trigger"><i class="material-icons">delete</i></button>
                    </td>
                </tr>
                    <?php endforeach ?>   
                <?php endif ?>                         

            </tbody>
        </table>

        <ul class="pagination center-align">
            <?php if($paginate->has_previous()):?>
                <li class="waves-effect"><a href="comments.php?id=<?= $postId . '&page=' . $paginate->previous() ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $paginate->total_page(); $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="posts.php?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($paginate->has_next()):?>
                <li class="waves-effect"><a href="comments.php?id=<?= $postId . '&page=' . $paginate->next() ?>"><i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>
    </div>



<?php require_once("includes/footer.php"); ?>