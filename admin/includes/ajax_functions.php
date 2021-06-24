<?php

require_once('Class/init.php');

if(isset($_POST['target_id'])){

    $id         = $_POST['target_id'];
    $category   = $_POST['image_category'];
    $image_name = $_POST['image_name'];

    if($category == "Users"){
        $targetTable = User::find($id);
    }

    if($targetTable){

        $targetTable->user_image = $image_name;

        if($targetTable->update()){
            exit(json_encode(['imgLocation' => 'images' . DS . $category . DS . $image_name]));
        }else{
            exit("There was an error updating");
        }
    }else{
        exit("Target not found");
    }
}




if(isset($_POST['idType'])){
    $type = $_POST['idType'];
    $id   = $_POST['id'];

    switch ($type) {
        case 'userId':
            deleteUser($id);
            exit(json_encode(['location' => 'users.php', 'message' => 'User has been deleted']));
            break;

        case 'charId':
            deleteChar($id);
            exit(json_encode(['location' => 'characters.php', 'message' => 'Character has been deleted']));
            break;

        case 'postId':
            deletePost($id);
            exit(json_encode(['location' => 'posts.php', 'message' => 'Post has been deleted']));
            break;

        case 'commentId':
            deleteComment($id);
            exit(json_encode(['location' => 'comments.php', 'message' => 'Comment has been deleted']));
            break;
            
        default:
            exit(json_encode(['message' => 'There was an error on deleting']));
    }
}

function deleteUser($id){
    global $session;

    $user = User::find($id);
    if($user){
        $user->delete();
    }
}

function deleteChar($id){
    global $session;

    $character = Character::find($id);

    if($character){
        $character->delete_character();
    }
}

function deletePost($id){
    global $session;

    $post = Post::find($id);
    if($post){
        $post->delete();
    }
}

function deleteComment($id){
    global $session;

    $comment = Comment::find($id);
    if($comment){
        $comment->delete();
    }
}