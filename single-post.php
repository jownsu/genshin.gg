<?php require_once("includes/header.php"); ?>
<?php require_once("includes/navigation.php"); ?>

<?php
    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    if(isset($_GET['id'])){
        $post_id = $_GET['id'];
        $post = Post::find($post_id);
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
                <p>Posted by <?= $post->author()->username . " " .$post->date ?></p>
                <?php
                 $tags = $post->post_tags();
                 foreach($tags as $tag): ?>
                    <div class="chip"><?= $tag ?></div>
                <?php endforeach ?>
                <img src="<?= $post->post_image_path() ?>" alt="img" class="responsive-img">
                <p><?= $post->description ?></p>   
            </div>
            <?php
                $whereSQL = ["post_id = $post_id"];
                $items_per_page = 3;

                $comments = Comment::where($whereSQL)->orderBy('date', 'desc')->paginate($items_per_page)->get();
                $total_page = Comment::count()->where($whereSQL)->total_page($items_per_page);
            ?>

            <p><span id="commentCount"><?= Comment::count()->where($whereSQL)->get() ?></span> Comment/s</p>

            <div class="comments-container">
                
                <?php 
                if(!empty($comments)):
                    foreach($comments as $comment):
                        $author = $comment->author();
                    ?>
                        <div class="comment">
                            <img src="<?= $author->user_image_path() ?>" alt="<?= $author->username ?>">
                            <div class="comment-details">
                                <p class="c-name"><?= $author->username ?></p>
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
            <?php if($page > 1):?>
                <li class="waves-effect"><a href="single-post.php?id=<?= $post_id . "&page=" .  ($page - 1) ?>"><i class="material-icons">chevron_left</i></a></li>
            <?php endif ?>

            <?php for($i = 1; $i <= $total_page; $i++): ?>
                <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="single-post.php?id=<?= $post_id . "&page=" . $i ?>"><?= $i ?></a></li>
            <?php endfor ?>

            <?php if($page < $total_page):?>
                <li class="waves-effect">
                    <a href="single-post.php?id=<?= $post_id . "&page=" .  ($page + 1) ?>">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
            <?php endif ?>
        </ul>

        </div>
    </main>
    
<?php require_once("includes/footer.php"); ?>

 