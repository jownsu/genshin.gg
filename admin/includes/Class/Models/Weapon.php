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

    private static function validate($data){
        $err = array();

        foreach(array_keys($data) as $key){
            $data[$key] = trim($data[$key]);
        }

        if(in_array(null, $data)){
            $err['error']['empty'] = 'Field cannot be empty';
        }

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $data['name'])){
            $err['error']['name'] = "!$%^&*()_+|~=`{}[]:;<>?,./\” characters not allowed";
        }

        if( !is_numeric($data['baseAttack']) && !empty($data['baseAttack'])){
            $err['error']['baseATK'] = "Base Attack must be a number";
        }

        return $err;
    }

    static function add($data){

        $err = self::validate($data);

        if(self::is_weapon_exists($data['name'])){
            $err['error']['name'] = $data['name'] . " already exists";
        }
        
        if(!empty($err)){
            return $err;
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

        return $weapon->create() ? $weapon : false;

    }

    static function edit($weapon, $input){

        $err = self::validate($input);

        if(self::is_weapon_exists($input['name']) && $weapon->name != $input['name']){
            $err['error']['name'] = $input['name'] . " already exists";
        }

        if(!empty($err)){
            return $err;
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