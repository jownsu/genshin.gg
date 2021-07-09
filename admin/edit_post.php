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

        $current_image = $post->image ?? "";

        $image = !empty($_FILES['post_image']['name']) ? $_FILES['post_image']['name'] : $post->image;

        $image_name = Post::rename_img($image);

        if($uPost = Post::edit($post, $_POST, $image_name) ){
            if(is_object($uPost)){

                if( isset($_FILES['post_image']) && is_uploaded_file($_FILES['post_image']['tmp_name']) ){
                    if( !$uPost->upload($_FILES['post_image'], $image_name, $current_image) ){
                         $session->set_message("<p class='red-text'>" . implode("<br>", $post->errors) . "</p>");
                    } 
                 }

                $session->set_message("<p class='green-text'>Post $uPost->title updated!</p>");
                header("Refresh: 0");
            }else{
                $empty_err   = $uPost['error']['empty'] ?? "";
            }
        }else{
            $session->set_message("<p class='red-text'>There was an error updating the post</p>");
        }

    }
    
    if(isset($_POST['delete'])){
        if($post->delete_post()){
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
                <form method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?= $post->post_id ?>">

                    <div class="file-field input-field">
                        <div class="btn-small green">
                            <span>Change Image</span>
                            <input type="file" name="post_image">
                        </div>
                        <div class="file-path-wrapper">
                            <input type="text" class="file-path validate"  accept="image/*">
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="text" id="title" name="title" value="<?= $_POST['title'] ?? $post->title ?>" class="<?= ( empty($_POST['title']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                        <label for="title">Post Title</label>
                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                    </div>

                    <div class="input-field">
                        <textarea id="description" name="description" class="materialize-textarea <?= ( empty($_POST['description']) && isset($empty_err) ) ? 'invalid' : '' ?>"><?= $_POST['description'] ?? $post->description ?></textarea>
                        <label for="description">Post Description</label>
                        <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
                    </div>
                    
                    <div class="input-field">
                        <select name="tags[]" multiple>
                            <?php 
                            $tags = $post->post_tags();
                            foreach(TAGS as $tag): ?>
                                <option value="<?= $tag ?>" <?= in_array($tag, $_POST['tags'] ?? $tags) ? 'selected' : '' ?>><?= $tag ?></option>
                            <?php endforeach ?>
                        </select>
                        <label>Select Tag</label>
                    </div>

                    <div class="input-field col s12">
                        <select name="status">
                            <option value="Published" <?= ( ($_POST['status'] ?? $post->post_status) == 'Published' ) ? 'selected' : '' ?>>Published</option>
                            <option value="Draft" <?= ( ($_POST['status'] ?? $post->post_status) == 'Draft' ) ? 'selected' : '' ?>>Draft</option>
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