<?php


class Character extends Model{
    use File;
    protected static $primary_key = "char_id";

    /***********Uploading Properties**************/
    
    private $thumbnail_tmpName;
    private $portrait_tmpName;

    private $icon_placeholder = "icon_placeholder.png";
    private $portrait_placeholder = "portrait_placeholder.png";
    private $imagePath = "images" . DS . "characters" . DS;



    static function add($data){
        $character = new Character();

        $character->name           = trim($data['name']) ?? "";
        $character->nickname       = trim($data['nickname']) ?? "";
        $character->vision         = trim($data['vision']) ?? "";
        $character->weapon         = trim($data['weapon']) ?? "";
        $character->rarity         = trim($data['rarity']) ?? "";
        $character->nation         = trim($data['nation']) ?? "";
        // $character->description    = trim($data['description']) ?? "";
        $character->affiliation    = trim($data['affiliation']) ?? "";
        $character->constellation  = trim($data['constellation']) ?? "";
        $character->birthday       = $data['birthday']['month'] . " " . $data['birthday']['day'];
        $character->sex            = trim($data['sex']) ?? "";
        $character->release_date   = $data['release_date']['month'] . " " . $data['release_date']['day'] . " " . $data['release_date']['year'];
        // $character->skillTalents   = json_encode($data['skillTalents']) ?? "";
        // $character->passiveTalents = json_encode($data['passiveTalents']) ?? "";
        // $character->constellations = json_encode($data['constellations']) ?? "";
        $character->tier           = trim($data['tier']) ?? "";

        return $character->create() ? $character : false;
    }

    static function edit($character, $input){
        $oldName = $character->name;

        $character->name           = trim($input['name']);
        $character->nickname       = trim($input['nickname']);
        $character->vision         = trim($input['vision']);
        $character->weapon         = trim($input['weapon']);
        $character->rarity         = trim($input['rarity']);
        $character->nation         = trim($input['nation']);
        // $character->description    = trim($input['description']);
        $character->affiliation    = trim($input['affiliation']);
        $character->constellation  = trim($input['constellation']);
        $character->birthday       = $input['birthday']['month'] . " " . $input['birthday']['day'];
        $character->sex            = trim($input['sex']) ?? "";
        $character->release_date   = $input['release_date']['month'] . " " . $input['release_date']['day'] . " " . $input['release_date']['year'];
        // $character->skillTalents   = json_encode($input['skillTalents']);
        // $character->passiveTalents = json_encode($input['passiveTalents']);
        // $character->constellations = json_encode($input['constellations']);
        $character->tier           = trim($input['tier']);

        if($character->update()){
            rename($this->imagePath . $oldName, $this->imagePath . strtolower($input['name']) );
           return $character;
        }else{
            return false;
        }
    }

    public function upload($file, $filename = "image"){
        //code here
        $path = "../images/characters/";
        $name = strtolower($this->name);

         if(!file_exists($this->imagePath)){
            mkdir($this->imagePath);
         }

         if(!file_exists($this->imagePath . $name)){
            mkdir($this->imagePath . $name);
         }

         if($this->check_files($file)){
           // $this->rename_if_exists();
           move_uploaded_file($file['tmp_name'], $this->imagePath . $name . DS . $filename);
           return true;

         }else{
            return false;
         }
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

            $name = strtolower($this->name);
            $path = IMAGES_ROOT . 'characters' . DS . $name;
            if(file_exists($path)){
                self::deleteDir($path);
            }else{
                return false;
            }

            return true;
        }
        return false;
    }
    
    function test(){
        $name = strtolower($this->name);
        $path = IMAGES_ROOT . 'characters' . DS . $name;
        if(file_exists($path)){
            self::deleteDir($path);
        }else{
            return false;
        }
    }

    function Thumbnail(){
        return !file_exists(IMAGES_ROOT . DS . 'characters' . DS . $this->name . DS . 'icon') 
        ? $this->image_path() . "characters" . DS . $this->icon_placeholder 
        : $this->image_path() . "characters" . DS . $this->name . DS . 'icon';
    }

    function Vision(){
        return $this->image_path() . "Elements" . DS . $this->vision . ".png";
    }

    function Portrait(){
        return !file_exists(IMAGES_ROOT . DS . 'characters' . DS . $this->name . DS . 'portrait') 
        ? $this->image_path() . "characters" . DS . $this->portrait_placeholder 
        : $this->image_path() . "characters" . DS . $this->name . DS . 'portrait';
    }

    function Weapon(){
        return $this->image_path() . "Weapons" . DS  . $this->weapon . ".png";
    }

    function Rarity(){
        return $this->rarity == 5 ? $this->image_path() . "5 Star.png" : $this->image_path() . "4 Star.png";
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

        $count = self::count()->where(["vision = $element"])->get();

        return $count ? $count : 0;
    }
}