<?php


class Character extends Db_objects{

    protected static $db_table = "characters";
    protected static $db_table_fields = ['name', 'nickname', 'rarity', 'weapon', 'element', 'sex', 'birthday',
                                         'constellation', 'nation', 'affiliation', 'release_date', 'thumbnail', 'portrait', 'tier'];
    protected static $db_table_id = "char_id";
    
    public $char_id;
    public $name;
    public $nickname;
    public $rarity;
    public $weapon;
    public $element;
    public $sex;
    public $birthday;
    public $constellation;
    public $nation;
    public $affiliation;
    public $release_date;
    public $thumbnail;
    public $portrait;
    public $tier;

    /***********Uploading Properties**************/
    
    private $thumbnail_tmpName;
    private $portrait_tmpName;

    private $thumbnail_placeholder = "thumbnail_placeholder.png";
    private $portrait_placeholder = "portrait_placeholder.png";


    static function find_characters_by_name(){
        return self::find_all("ORDER BY name");
    }

    function set_thumbnail($file){

        if(!$this->check_files($file)){
            return false;
        }

        $this->thumbnail = basename($file['name']);
        $this->thumbnail_tmpName = ($file['tmp_name']);
    }

    function set_portrait($file){

        $this->check_files($file);

        $this->portrait = basename($file['name']);
        $this->portrait_tmpName = $file['tmp_name'];
    }

    function create_character(){
        if(!empty($this->errors)){
            return false;
        }
        
        // if(file_exists(IMAGES_ROOT . DS . 'Characters' . DS . $this->thumbnail_tmpName)){
        //     $this->errors[] = "The file {$this->thumbnail} existed";
        //     return false;
        // }
        
        // if(file_exists(IMAGES_ROOT . DS . 'Portraits' . DS . $this->portrait_tmpName)){
        //     $this->errors[] = "The file {$this->portrait} existed";
        //     return false;
        // }

        // if(empty($this->thumbnail)){
        //     $this->thumbnail = "thumbnail_placeholder.png";
        // }

        // if(empty($this->portrait)){
        //     $this->portrait = "portrait_placeholder.png";
        // }


        if($this->create()){
            $this->move_files();
            return true;
        }else{
            return false;
        }
    }

    function update_character(){
        if(!empty($this->errors)){
            return false;
        }

        if($this->update()){
            $this->move_files();
            return true;
        }else{
            return false;
        }
    }
    
    function delete_character(){
        if($this->delete()){
            // unlink(IMAGES_ROOT . DS . "Characters" . DS . $this->thumbnail);
            // unlink(IMAGES_ROOT . DS . "Portraits" . DS . $this->portrait);
            return true;
        }
        return false;
    }

    function Thumbnail(){
        return empty($this->thumbnail) ? $this->image_path() . "Characters" . DS . $this->thumbnail_placeholder : $this->image_path() . "Characters" . DS . $this->thumbnail;
    }

    function Element(){
        return $this->image_path() . "Elements" . DS . $this->element . ".png";
    }

    function Portrait(){
        return empty($this->portrait) ? $this->image_path() . "Portraits" . DS . $this->portrait_placeholder : $this->image_path() . "Portraits" . DS  . $this->portrait;
    }

    function Weapon(){
        return $this->image_path() . "Weapons" . DS  . $this->weapon . ".png";
    }

    function Rarity(){
        return $this->image_path() . $this->rarity . ".png";
    }

    function get_release_date(){
        return explode(" ", $this->release_date);
    }

    function set_release_date($month, $day, $year){
        $this->release_date = $month . " " . $day . " " . $year;
    }

    function set_birthday($month, $day){
        $this->birthday = $month . " " . $day;
    }

    function get_birthday(){
        return explode(" ", $this->birthday);
    }

    private function move_files(){
        if(isset($this->thumbnail_tmpName)){
            move_uploaded_file($this->thumbnail_tmpName, IMAGES_ROOT . DS . "Characters" . DS . $this->thumbnail);
        }
        if(isset($this->portrait_tmpName)){
            move_uploaded_file($this->portrait_tmpName, IMAGES_ROOT . DS . "Portraits" . DS . $this->portrait);
        }
    }

    function get_errors(){
        return $this->errors;
    }

    static function count_by_element($element){
        global $db;
        $element = ucfirst(strtolower($element));

        $sql = "SELECT COUNT(*) FROM " . self::$db_table . " WHERE element = ?";
        $db->query($sql);
        $db->bind(1, $element);
        return $db->fetchColumn();
    }
}