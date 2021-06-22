<?php require_once("includes/header.php"); ?>

<?php require_once("includes/navigation.php"); ?>
<?php

    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? (int)$_GET['page'] : 1;
    $item_per_page = 3;
    if(isset($_GET['search']) && $_GET['search'] != ""){
        $search = trim($_GET['search']);

        $posts = Post::where(["title LIKE %$search%"])->orderBy('title')->paginate($item_per_page)->get();
        $total_page = Post::count()->where(["title LIKE %$search%"])->total_page($item_per_page);

    }else{
        $posts = Post::orderBy('title')->paginate($item_per_page)->get();
        $total_page = Post::count()->total_page($item_per_page);
    }



?>

    <main>
        <div class="container">
            <h6>All Posts</h6>
            <form method="GET" class="row" style="margin-bottom:0">
                <div class="input-field col l4 m8 s12">
                    <i class="material-icons prefix">search</i>
                    <input type="text" name="search" id="search" value="<?= isset($search) ? $search : '' ?>">
                    <label for="search">Search...</label>
                </div>
            </form>
            <?php 
                if(empty($posts)){
                    die('No records found');
                }


                foreach($posts as $post): ?>
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
                            Posted by <?= $post->author()->username ?> at <?= $post->date ?></p>
                            <p class="post-body"><?= $post->post_description() ?></p>
                            <a href="single-post.php">See more</a>
                        </div>            
                    </div>
                <?php endforeach ?>


                <ul class="pagination center-align">
                    <?php if( $page > 1 ):?>
                        <li class="waves-effect"><a href="index.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page - 1 ?>"><i class="material-icons">chevron_left</i></a></li>
                    <?php endif ?>

                    <?php for($i = 1; $i <= $total_page; $i++): ?>
                        <li class="<?= $page == $i ? 'active light-blue darken-3' : 'waves-effect' ?>"><a href="index.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor ?>

                    <?php if( $page < $total_page ):?>
                        <li class="waves-effect"><a href="index.php?<?= isset($search) ? 'search='.$search : '' ?>&page=<?= $page + 1 ?>"><i class="material-icons">chevron_right</i></a></li>
                    <?php endif ?>
                </ul>
        </div>
  
    </main>
    
<?php require_once("includes/footer.php"); ?>

 