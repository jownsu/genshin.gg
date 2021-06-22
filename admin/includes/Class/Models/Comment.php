<?php

class Comment extends Model{

    protected static $primary_key = "comment_id";

    public function author(){
        $author = User::find($this->user_id, 'username, user_image');
        return $author;
    }

    function author_image_path(){
        return empty($this->user_image) ? $this->image_path() . $this->user_image : $this->image_path() . "Users" . DS . $this->user_image;
    }
    
    function delete(){
        global $db;
        $sql = "DELETE FROM " . static::$db_table . " WHERE comment_id = " . $this->comment_id;
        return $db->query($sql) ? true : false;
    }

}