<?php require_once("includes/header.php"); ?>
<?php
    if(isset($_GET['id'])){
        $post = Post::find($_GET['id']);
        if( (!$post) || ($session->id != $post->author()->user_id) ){
            header('location: my_posts.php');
        }
    }else{
        header('location: my_posts.php');
    }

    if(isset($_POST['update'])){

        if($uPost = Post::edit($post, $_POST) ){
            $session->set_message("<p class='green-text'>The Post $uPost->title was Updated!</p>");
            header('location: my_posts.php');
        }else{
            $session->set_message("<p class='red-text'>There was an error updating the post</p>");
        }
    }
    
    if(isset($_POST['delete'])){
        if($post->delete()){
            $session->set_message("<p class='green-text'> Post " . $post->title . " has been deleted </p>");
            header('Location: my_posts.php');
        }else{
            $session->set_message("<p class='red-text>There was an error while deleting the post</p>'");
        }
    }

?>
    <div class="container">
        <h4>Edit post</h4>

        <h6>Posted by: <?= $post->author()->username ?> on <?= $post->date ?></h6>

        <div class="row">
            <div class="col s12">
                <img src="<?= $post->post_image_path() ?>" alt="img" class="responsive-img post-image">
            </div>
            <div class="col s12">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $post->post_id ?>">
                    <div class="input-field">
                        <input type="text" id="title" name="title" value="<?= $post->title ?>">
                        <label for="title">Post Title</label>
                    </div>
                    <div class="input-field">
                        <textarea id="description" name="description" class="materialize-textarea"><?= $post->description ?></textarea>
                        <label for="description">Post Description</label>
                    </div>
                    <div class="input-field">
                        <select name="tags[]" multiple>
                            <?php 
                            $tags = $post->post_tags();
                            foreach(TAGS as $tag): ?>
                                <option value="<?= $tag ?>" <?= in_array($tag, $tags) ? 'selected' : '' ?>><?= $tag ?></option>
                            <?php endforeach ?>
                        </select>
                        <label>Select Tag</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="status">
                            <?php foreach(POST_STATUS as $status): ?>
                                <option value="<?= $status ?>" <?= $post->post_status == $status ? 'selected' : '' ?>><?= $status ?></option>
                            <?php endforeach ?>
                        </select>
                        <label>Status</label>
                    </div>
                    <input type="submit" value="Update" name="update" class="btn-small green">
                    <button data-target="delete-post-modal" class="btn-small red modal-trigger btn-delete">Delete</button>
                </form>
                <br>
                
            </div>
        </div>

    </div>

    <div id="delete-post-modal" class="modal black-text">
        <div class="modal-content">
            <h5>Are you sure to delete <?= $post->title ?>?</h5>
        </div>
        <div class="modal-footer">
            <form method="POST">
                <input type="submit" value="Delete" name="delete" class="modal-close btn-small red">
                <a href="#!" class="modal-close btn-small blue">No</a>
            </form>
        </div>
    </div>
    
<?php require_once("includes/ajax_modal.php") ?>
<?php require_once("includes/footer.php"); ?>