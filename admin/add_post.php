<?php require_once("includes/header.php"); ?>
<?php
    if(isset($_POST['submit'])){

        if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['tags'])){
            $session->set_message("<p class='red-text'>Fields cannot be empty</p>");
        }else{

            // $post->set_image($_FILES['file-post-image']);
    
            if($post = Post::add($_POST)){
                $session->set_message("<p class='green-text'> Post $post->title was Added </p>");
                header("location: my_posts.php");
            }else{
                echo("error");
                print_r($_POST);
                //$session->set_message("<p class='red-text'>" . implode("<br>", $post->errors) . "</p>");
            }
        }
    }

?>
    <div class="container">
        <h4>Add new post</h4>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" id="title" name="title">
                <label for="title">Post Title</label>
            </div>
            <div class="input-field">
                <textarea id="description" name="description" class="materialize-textarea"></textarea>
                <label for="description">Post Description</label>
            </div>
            <div class="input-field">
                <select name="tags[]" multiple>
                    <?php foreach(TAGS as $tag): ?>
                        <option value="<?= $tag ?>"><?= $tag ?></option>
                    <?php endforeach ?>
                </select>
                <label>Select Tag</label>
            </div>
            <div class="input-field col s12">
                <select name="status">
                    <option value="Published" selected>Published</option>
                    <option value="Draft">Draft</option>
                </select>
                <label>Status</label>
            </div>
            <div class="file-field input-field">
                <div class="btn-small green">
                    <span>Image</span>
                    <input type="file" name="file-post-image">
                </div>
                <div class="file-path-wrapper">
                    <input type="text" class="file-path validate"  accept="image/*">
                </div>
            </div>
 
            <input type="submit" value="Submit" name="submit" class="btn-small green">
        </form>
    </div>


<?php require_once("includes/footer.php"); ?>
