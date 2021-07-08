<?php require_once("includes/header.php"); ?>
<?php
    if(isset($_POST['submit'])){

            $image_name = $_FILES['post_image']['name'] ?? "";

            if($post = Post::add($_POST, $image_name)){
                if(is_object($post)){
                    if( isset($_FILES['post_image']) && is_uploaded_file($_FILES['post_image']['tmp_name']) ){
                        if( !$post->upload($_FILES['post_image']) ){
                             $session->set_message("<p class='red-text'>" . implode("<br>", $post->errors) . "</p>");
                        } 
                     }
                    $session->set_message("<p class='green-text'> Post $post->title was Added </p>");
                }else{
                    $empty_err = $post['error']['empty'] ?? "";
                }

            }else{
                $session->set_message("<p class='red-text'> There was an error adding the post </p>");
            }
    }

?>
    <div class="container">
        <h4>Add new post</h4>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="title" name="title" value="<?= $_POST['title'] ?? "" ?>" class="<?= ( empty($_POST['title']) && isset($empty_err) ) ? 'invalid' : '' ?>">
                <label for="title">Post Title</label>
                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
            </div>
            <div class="input-field">
                <textarea id="description" name="description" class="materialize-textarea <?= ( empty($_POST['description']) && isset($empty_err) ) ? 'invalid' : '' ?>"><?= $_POST['description'] ?? "" ?></textarea>
                <label for="description">Post Description</label>
                <span class="helper-text" data-error="<?= $empty_err ?? '' ?>"></span>
            </div>
            <div class="input-field">
                <select name="tags[]" multiple>
                    <?php foreach(TAGS as $tag): ?>
                        <option value="<?= $tag ?>" <?= ( isset($_POST['tags']) && in_array($tag, $_POST['tags']) ) ? 'selected' : '' ?>><?= $tag ?></option>
                    <?php endforeach ?>
                </select>
                <label>Select Tag</label>
            </div>
            <div class="input-field col s12">
                <select name="status">
                    <option value="Published" <?= ( isset($_POST['status']) && $_POST['status'] == 'Published' ) ? 'selected' : '' ?>>Published</option>
                    <option value="Draft" <?= ( isset($_POST['status']) && $_POST['status'] == 'Draft' ) ? 'selected' : '' ?>>Draft</option>
                </select>
                <label>Status</label>
            </div>
            <div class="file-field input-field">
                <div class="btn-small green">
                    <span>Image</span>
                    <input type="file" name="post_image">
                </div>
                <div class="file-path-wrapper">
                    <input type="text" class="file-path validate"  accept="image/*">
                </div>
            </div>
 
            <input type="submit" value="Submit" name="submit" class="btn-small green">
        </form>
    </div>


<?php require_once("includes/footer.php"); ?>
