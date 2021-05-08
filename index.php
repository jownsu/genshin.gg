<?php require_once("includes/header.php"); ?>

<?php require_once("includes/navigation.php"); ?>
<?php

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;

    $total_count = Post::count_published_post();
    $paginate = new Paginate($total_count, $page, 3);
    $posts = Post::find_published_post_by_page($paginate);
?>

    <main>
        <div class="container">


            <h6>All Posts</h6>
            <?php foreach($posts as $post): ?>
            <div class="post-container">
                <img src="<?= $post->post_image_path() ?>" alt="" class="post-img">
                <div class="post-content">
                    <a href="single-post.php?id=<?= $post->post_id ?>" class="post-title"><?= $post->title ?></a>
                    <p>
                    <?php
                        $tags = $post->post_tags();
                        foreach($tags as $tag): ?>
                    <div class="chip"><?= $tag ?></div>
                    <?php endforeach ?>
                    Posted by <?= $post->username ?> at <?= $post->date ?></p>
                    <p class="post-body"><?= $post->post_description() ?></p>
                    <a href="single-post.php">See more</a>
                </div>            
            </div>
            <?php endforeach ?>
                <ul class="pagination center-align">
                    <?php if($paginate->has_previous()):?>
                        <li class="waves-effect"><a href="index.php?page=<?= $paginate->previous() ?>"><i class="material-icons">chevron_left</i></a></li>
                    <?php endif ?>

                    <?php for($i = 1; $i <= $paginate->total_page(); $i++): ?>
                        <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="index.php?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor ?>

                    <?php if($paginate->has_next()):?>
                        <li class="waves-effect"><a href="index.php?page=<?= $paginate->next() ?>"><i class="material-icons">chevron_right</i></a></li>
                    <?php endif ?>
                </ul>
            

        </div>
  
    </main>
    
<?php require_once("includes/footer.php"); ?>

 