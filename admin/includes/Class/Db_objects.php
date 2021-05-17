<?php


class Db_objects{

    protected $errors = array();
    protected $upload_errors_arr = array(
        UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded in either thumbnail or portrait',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    );
    
    static function find_by_page($paginate, $sqlExtend = ""){
        $sql = "SELECT * FROM " . static::$db_table . " " . $sqlExtend . " LIMIT " . $paginate->items_per_page . " OFFSET " . $paginate->offset();
        return self::find_query($sql);
    }

    static function find_by_id($id){
        $result = self::find_query("SELECT * FROM " . static::$db_table . " WHERE " . static::$db_table_id . " = ". $id . " LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }

    static function find_all($sql = ""){
        $result = self::find_query("SELECT * FROM " . static::$db_table . " " . $sql);
        return !empty($result) ? $result : false;
    }


    static function find_query($sql, $binds = array()){
        global $db;
        $db->query($sql);
        
        if(isset($binds)){
            foreach($binds as $key => $value){
                $db->bind("{$key}", "{$value}");
            }
        }
        
        $result = $db->execute();

        $obj_arr = array();
            while($row = $result->fetch()){
                $obj_arr[] = self::instantiate($row);
            }
        return $obj_arr;
    }

    static function instantiate($record){
        $calling_class = get_called_class();
        $obj = new $calling_class;

        foreach($record as $key => $value){
            if($obj->has_attribute($key)){
                $obj->$key = $value;
            }
        }

        return $obj;
    }

    private function has_attribute($attribute){
        return property_exists($this, $attribute);
    }

    protected function get_properties(){
        $properties = array();

        foreach(static::$db_table_fields as $field){
            if($this->has_attribute($field)){
                $properties[$field] = $this->$field;
            }
        }

        return $properties;

    }

    static function count_all(){
        global $db;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $db->query($sql);
        return $db->fetchColumn();
    }

    function create(){
        global $db;

        $properties = $this->get_properties();

        $sql = "INSERT INTO " . static::$db_table . " (". implode(", ", static::$db_table_fields) .") ";
        $sql .= "VALUES (:". implode(", :", static::$db_table_fields) .")";

        $db->query($sql);

        foreach($properties as $key => $value){
            $db->bind(":{$key}", "{$value}");
        }

        return $db->execute() ? true : false;

    }

    function update(){
        global $db;

        $properties = $this->get_properties();
        $update_set_pair = array();

        foreach(array_keys($properties) as $key){
            $update_set_pair[] = "{$key} = :{$key}";
        }

        $sql = "UPDATE " . static::$db_table . " SET ";
        $sql .= implode(', ', $update_set_pair) . " WHERE " . static::$db_table_id . " = " . $this->{static::$db_table_id};
        
        $db->query($sql);

        foreach($properties as $key => $value){
            $db->bind(":{$key}", "{$value}");
        }

        return $db->execute() ? true : false;
    }

    function delete(){
        global $db;

        $sql = "DELETE FROM " . static::$db_table . " WHERE " . static::$db_table_id . " = " . $this->{static::$db_table_id};

        $db->query($sql);
        return $db->execute() ? true : false;
    }



    /*******File Pathing Methods**********/


    protected function get_access(){
        $current_dir = explode(DS , getcwd());
        $current_access = array_pop($current_dir);
        return $current_access;
    }

    protected function image_path(){
        $current_access = $this->get_access();
        return $current_access == 'admin' ? 'images' . DS  : "admin" . DS . "images" . DS;
    }
    
    protected function check_files($file){
        if(empty($file) || !is_array($file)){
            $this->errors[] = "There is no file uploaded";
            return false;
        }

        if($file['error'] != 0){
            $this->errors = $this->upload_errors_arr[$file['error']];
            return false;
        }

        return true;
    }



}