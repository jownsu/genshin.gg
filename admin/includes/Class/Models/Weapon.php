<?php

class Weapon extends Model{
    use File;
    protected static $primary_key = "weap_id";

    private $weapon_placeholder = "weapon_placeholder.png";
    private $imagePath = "images" . DS . "weapons" . DS;

    static function is_weapon_exists($name){
        $count = Weapon::count()->where(["name = $name"])->get();
        return $count > 0 ? true : false;
    }

    static function add($data){
        global $session;

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $data['name'])){
            $session->set_message("<p class='red-text'>Some special characters not allowed</p>");
            return false;
        }

        if(self::is_weapon_exists($data['name'])){
            $session->set_message("<p class='red-text'>" .$data['name'] . " already exists</p>");
            return false;
        } 
        
        $weapon = new Weapon();

        $weapon->name        = trim($data['name']) ?? "";
        $weapon->type        = trim($data['type']) ?? "";
        $weapon->rarity      = trim($data['rarity']) ?? "";
        $weapon->baseAttack  = trim($data['baseAttack']) ?? "";
        $weapon->subStat     = trim($data['subStat']) ?? "";
        $weapon->passiveName = trim($data['passiveName']) ?? "";
        $weapon->passiveDesc = trim($data['passiveDesc']) ?? "";
        $weapon->location    = trim($data['location']) ?? "";

        // return $weapon->create() ? $weapon : false;
        if($weapon->create()){
            return $weapon;
        }else{
            $session->set_message("<p class='red-text'>There is an error." .$data['name'] . " failed to add</p>");
            return false;
        }
    }

    static function edit($weapon, $input){
        global $session;

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $input['name'])){
            $session->set_message("<p class='red-text'>Some special characters not allowed</p>");
            return false;
        }

        if(self::is_weapon_exists($input['name']) && $weapon->name != $input['name']){
            $session->set_message("<p class='red-text'>" .$input['name'] . " already exists</p>");
            return false;
        } 

        $oldName = $weapon->name;

        $weapon->name        = trim($input['name']);
        $weapon->type        = trim($input['type']);
        $weapon->rarity      = trim($input['rarity']);
        $weapon->baseAttack  = trim($input['baseAttack']);
        $weapon->subStat     = trim($input['subStat']);
        $weapon->passiveName = trim($input['passiveName']);
        $weapon->passiveDesc = trim($input['passiveDesc']);
        $weapon->location    = trim($input['location']);

        if($weapon->update()){
            if(file_exists($weapon->imagePath . $oldName)){
                rename($weapon->imagePath . $oldName, $weapon->imagePath . strtolower($input['name']) );
            }
           return $weapon;
        }else{
            $session->set_message("<p class='red-text'>There is an error" .$input['name'] . " failed to update</p>");
            return false;
        }
    }

    public function upload($file, $filename = "image"){
        //code here
        $path = "../images/weapons/";
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

    function delete_weapon(){
        if($this->delete()){

            $name = strtolower($this->name);
            
            if( empty($name) || $name == "" ) return false;
            
            $path = IMAGES_ROOT . 'weapons' . DS . $name;
            if(file_exists($path)){
                self::deleteDir($path);
            }else{
                return false;
            }

            return true;
        }
        return false;
    }


    function weapon_img(){
        return !file_exists(IMAGES_ROOT . DS . 'weapons' . DS . $this->name . DS . 'icon') 
        ? $this->image_path() . "weapons" . DS . $this->weapon_placeholder 
        : $this->image_path() . "weapons" . DS . $this->name . DS . 'icon';
    }

    function rarity(){
        return $this->image_path() . $this->rarity ." Star.png";
    }




}