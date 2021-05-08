<?php require_once("includes/header.php"); ?>
<?php require_once("includes/navigation.php"); ?>

<?php
    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    if(isset($_GET['id'])){
        $post_id = $_GET['id'];
        $post = Post::find_by_id($post_id);
        if(!$post){
            header('Location: index.php');
        }
    }else{
        header('Location: index.php');
    }


?>
    <main>
        <div class="container">

            <div class="single-post-container">
                <h4 class="single-post-title">Title: <?= $post->title ?></h4>
                <p>Posted by <?= $post->username . " " .$post->date ?></p>
                <?php
                 $tags = $post->post_tags();
                 foreach($tags as $tag): ?>
                    <div class="chip"><?= $tag ?></div>
                <?php endforeach ?>
                <img src="<?= $post->post_image_path() ?>" alt="img" class="responsive-img">
                <p><?= $post->description ?></p>   
            </div>
            <?php
                $total_count = Comment::count_comments_by_post_id($post->post_id);
                $paginate = new Paginate($total_count, $page, 3);
                $comments = Comment::find_comments_by_page($post->post_id, $paginate);
            ?>

            <p><span id="commentCount"><?= $total_count ?></span> Comment/s</p>

            <div class="comments-container">
                
                <?php 
                if(!empty($comments)):
                    foreach($comments as $comment): ?>
                        <div class="comment">
                            <img src="<?= $comment->author_image_path() ?>" alt="<?= $comment->username ?>">
                            <div class="comment-details">
                                <p class="c-name"><?= $comment->username ?></p>
                                <p><?= $comment->date ?></p>
                                <p><?= $comment->description ?></p>
                            </div>
                        </div>
                <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="form-comment-container">
                <?= $session->message ?>
                <p>Leave a Comment</p>
                <form class="form-comment" method="POST">
                    <div class="input-field">
                        <input type="hidden" name="postId" value="<?= $post->post_id ?>">
                        <input type="hidden" name="author" value="<?= $session->id ?>">
                        <textarea name="comment" id="textarea1" cols="30" rows="10" class="materialize-textarea validate"></textarea>
                        <label for="textarea1">Comment...</label>
                    </div>
                    <input type="submit" class="btn-small blue darken-3" id="btnComment" name="submit-comment" value="submit">
                </form>
            </div>

        <ul class="pagination center-align">
            <?php if($paginate->has_previous()):?>
                <li class="waves-effect"><a href="single-post.php?id=<?= $post_id . "&page=" .  $paginate->previous() ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $paginate->total_page(); $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="single-post.php?id=<?= $post_id . "&page=" . $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($paginate->has_next()):?>
                <li class="waves-effect"><a href="single-post.php?id=<?= $post_id . "&page=" .  $paginate->next() ?>"> <i class="material-icons">chevron_right</i></a></li>
            <?php endif ?>
        </ul>

        </div>
    </main>
    
<?php require_once("includes/footer.php"); ?>

 