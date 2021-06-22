<?php

class Comment extends Model{


    protected static $primary_key = "comment_id";


    public $username;
    public $user_image;


    public function author(){
        $author = User::find($this->user_id, 'username, user_image');
        return $author;
    }

    function author_image_path(){
        return empty($this->user_image) ? $this->image_path() . $this->user_image : $this->image_path() . "Users" . DS . $this->user_image;
    }


    static function find_comments_by_page($id, $paginate){
        
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " INNER JOIN users ON " . self::$db_table . ".user_id = users.user_id ";
        $sql .= "WHERE " . self::$db_table . ".post_id = :id";
        $sql .= " ORDER BY " . self::$db_table . ".date DESC ";
        $sql .= "LIMIT " . $paginate->items_per_page . " OFFSET " . $paginate->offset();
        
        $result = self::find_query($sql, [":id" => $id]);

        return !empty($result) ? $result : false;
    }

    static function find_by_id($id){
        $result = self::find_query("SELECT * FROM " . static::$db_table . " WHERE comment_id = :id LIMIT 1", [":id", $id]);
        return !empty($result) ? array_shift($result) : false;
    }

    
    function delete(){
        global $db;
        $sql = "DELETE FROM " . static::$db_table . " WHERE comment_id = " . $this->comment_id;
        return $db->query($sql) ? true : false;
    }

    static function count_comments_by_post_id($id){
        global $db;

        $sql = "SELECT COUNT(*) FROM " . self::$db_table . " WHERE post_id = " . $id;

        $db->query($sql);
        return $db->fetchColumn();
    }





}