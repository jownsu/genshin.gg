<?php


class Character extends Model{

    protected static $primary_key = "char_id";

    /***********Uploading Properties**************/
    
    private $thumbnail_tmpName;
    private $portrait_tmpName;

    private $thumbnail_placeholder = "thumbnail_placeholder.png";
    private $portrait_placeholder = "portrait_placeholder.png";


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


        
        if(file_exists(IMAGES_ROOT . DS . 'Characters' . DS . $this->thumbnail)){
            $thumbnailCount = 1;
            list($name, $extension) = explode('.', $this->thumbnail);
            while(file_exists(IMAGES_ROOT . DS . 'Characters' . DS . $this->thumbnail)) {
                $this->thumbnail = $name . "(" . $thumbnailCount . ")" . '.' . $extension;    
                $thumbnailCount++;
            }
        }

        if(file_exists(IMAGES_ROOT . DS . 'Portraits' . DS . $this->portrait)){
            $portraitCount = 1;
            list($name, $extension) = explode('.', $this->portrait);
            while(file_exists(IMAGES_ROOT . DS . 'Portraits' . DS . $this->portrait)) {
                $this->portrait = $name . "(" . $portraitCount . ")" . '.' . $extension;    
                $portraitCount++;
            }
        }

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
        return (empty($this->thumbnail)) || !file_exists(IMAGES_ROOT . DS . 'Characters' . DS . $this->thumbnail) ? $this->image_path() . "Characters" . DS . $this->thumbnail_placeholder : $this->image_path() . "Characters" . DS . $this->thumbnail;
    }

    function Element(){
        return $this->image_path() . "Elements" . DS . $this->element . ".png";
    }

    function Portrait(){
        return (empty($this->portrait) || !file_exists(IMAGES_ROOT . DS . 'Portraits' . DS . $this->portrait)) ? $this->image_path() . "Portraits" . DS . $this->portrait_placeholder : $this->image_path() . "Portraits" . DS  . $this->portrait;
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
        $element = ucfirst(strtolower($element));

        $count = self::count()->where(["element = $element"])->get();

        return $count ? $count : 0;
    }
}