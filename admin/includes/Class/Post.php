<?php

class Post extends Db_objects{

    protected static $db_table = "posts";
    protected static $db_table_fields = ['title', 'description', 'image', 'date', 'author_id', 'tags', 'post_status'];
    protected static $db_table_id = "post_id";

    public $post_id;
    public $title;
    public $description;
    public $image;
    public $date;
    public $tags;
    public $post_status;
    public $author_id;

    public $username;


    /*******Uploading Properties******/

    private $image_tmpname;
    private $image_dir = 'Posts';

    static function find_published_post_by_page($paginate){
        $sql = "SELECT * FROM " . self::$db_table; 
        $sql .= " INNER JOIN users ON " . self::$db_table . ".author_id = users.user_id ";
        $sql .= " WHERE posts.post_status = 'Published' ";
        $sql .= "LIMIT " . $paginate->items_per_page . " OFFSET " . $paginate->offset();
        
        return self::find_query($sql);
    }

    static function find_by_page($paginate, $sqlExtend=""){
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " INNER JOIN users ON " . self::$db_table . ".author_id = users.user_id ";
        $sql .= "LIMIT " . $paginate->items_per_page . " OFFSET " . $paginate->offset();
        return self::find_query($sql);
    }
    
    static function find_by_author($paginate, $id){
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " INNER JOIN users ON " . self::$db_table . ".author_id = users.user_id ";
        $sql .= "WHERE " . self::$db_table . ".author_id = :id";
        $sql .= " LIMIT " . $paginate->items_per_page . " OFFSET " . $paginate->offset();
        return self::find_query($sql, [":id" => $id]);
    }

    static function find_by_id($id){
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " INNER JOIN users ON " . self::$db_table . ".author_id = users.user_id ";
        $sql .= "WHERE posts.post_id = :id LIMIT 1";

        $result = self::find_query($sql, [':id' => $id]);
        return !empty($result) ? array_shift($result) : false;
    }


    static function count_published_post(){
        global $db;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE post_status = 'Published'";
        $db->query($sql);
        return $db->fetchColumn();
    }

    function create_post(){
        if(!empty($this->errors)){
            return false;
        }
        
        if($this->create()){
            $this->move_files();
            return true;
        }else{
            return false;
        }
    }

    private function move_files(){
        if(isset($this->image_tmpname)){
            move_uploaded_file($this->image_tmpname, IMAGES_ROOT . DS . $this->image_dir . DS . $this->image);
        }
    }

    function set_image($file){

        $this->check_files($file);

        $this->image = basename($file['name']);
        $this->image_tmpname = $file['tmp_name'];
    }

    function post_image_path(){
        return $this->image_path() . $this->image_dir . DS . $this->image;
    }

    function post_description(){
        return substr($this->description, 0, 250);
    }

    function post_tags(){
        return explode(', ', $this->tags);
    }
}