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

    static function find_posts_by_page($paginate, $sqlExtend="", $bind = array()){
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " INNER JOIN users ON " . self::$db_table . ".author_id = users.user_id ";
        $sql .= $sqlExtend;
        $sql .= " LIMIT " . $paginate->items_per_page . " OFFSET " . $paginate->offset();
        return self::find_query($sql, $bind);
    }
    
    static function find_by_author($paginate, $id){
        $sql = "WHERE " . self::$db_table . ".author_id = :id";
        return self::find_posts_by_page($paginate, $sql, [":id" => $id]);
    }

    static function find_by_id($id){
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " INNER JOIN users ON " . self::$db_table . ".author_id = users.user_id ";
        $sql .= "WHERE posts.post_id = :id LIMIT 1";

        $result = self::find_query($sql, [':id' => $id]);
        return !empty($result) ? array_shift($result) : false;
    }

    static function search_post_by_page($tables, $search, $paginate, $whereSqlExtend = ""){
        $likeSql = array();

        foreach($tables as $table){
            $likeSql[] = "{$table} LIKE :search";
        }
        $sql = "WHERE " . implode(' OR ', $likeSql);
        $sql .= " " . $whereSqlExtend;
        $result = self::find_posts_by_page($paginate, $sql, [':search' => "%{$search}%"]);
        return !empty($result) ? $result : false;
    }

    static function search_published_post($tables, $search, $paginate){
        $sql = " AND posts.post_status = 'Published'";
        $result = self::search_post_by_page($tables, $search, $paginate, $sql);
        return !empty($result) ? $result : false;
    }

    static function search_post_by_author($tables, $search, $id, $paginate){
        $likeSql = array();

        foreach($tables as $table){
            $likeSql[] = "{$table} LIKE :search";
        }
        $sql = "WHERE " . implode(' OR ', $likeSql);
        $sql .= " AND " . self::$db_table . ".author_id = :id";

        $result = self::find_posts_by_page($paginate, $sql, [':search' => "%{$search}%", ':id' => $id]);
        return !empty($result) ? $result : false;
    }


    static function count_published_post(){
        global $db;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE post_status = 'Published'";
        $db->query($sql);
        return $db->fetchColumn();
    }

    static function search_count_by_author($tables, $search, $id){
        global $db;

        $likeSql = array();

        foreach($tables as $table){
            $likeSql[] = "{$table} LIKE :search";
        }

        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE " . implode(' OR ', $likeSql);
        $sql .= " AND " . self::$db_table . ".author_id = :id";
        $db->query($sql);
        $db->bind(':search' , "%{$search}%");
        $db->bind(':id' , $id);
        return $db->fetchColumn();

    }

    static function search_count_by_published_post($tables, $search){
        global $db;

        $likeSql = array();

        foreach($tables as $table){
            $likeSql[] = "{$table} LIKE :search";
        }

        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE " . implode(' OR ', $likeSql);
        $sql .= " AND ". self::$db_table .".post_status = 'Published'";
        $db->query($sql);
        $db->bind(':search' , "%{$search}%");
        return $db->fetchColumn();

    }

    static function count_posts_by_author($id){
        global $db;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $sql .= " WHERE " . self::$db_table . ".author_id = :id";
        $db->query($sql);
        $db->bind(':id', $id);
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