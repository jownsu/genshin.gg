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


    static function is_character_exists($name){
        $count = Character::count()->where(["name = $name"])->get();
        return $count > 0 ? true : false;
    }

    private static function validate($data){
        $err = array();

        foreach(array_keys($data) as $key){
            if(is_string($data[$key])){
                $data[$key] = trim($data[$key]);
            }
        }

        if(in_array(null, $data)){
            $err['error']['empty'] = 'Field cannot be empty';
        }

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $data['name'])){
            $err['error']['name'] = "!$%^&*()_+|~=`{}[]:;<>?,./\” characters not allowed";
        }

        foreach($data['skill_talents'] as $key => $arrSkill){
            if($key == 3) break;
            if(in_array('',$arrSkill)){
                $err['error']['empty'] = "Field cannot be empty";
            }
        }

        foreach($data['passive_talents'] as $key => $arrPassive){
            if($key == 3) break;
            if(in_array('',$arrPassive)){
                $err['error']['empty'] = "Field cannot be empty";
            }
        }

        if(isset($data['skill_talents'][3])){
            if(  in_array('', $data['skill_talents'][3]) && in_array(!null, $data['skill_talents'][3]) ){
                $err['error']['extraSkill'] = 'Fieldset should be complete';
            }
        }

        if(isset($data['passive_talents'][3])){
            if(  in_array('', $data['passive_talents'][3]) && in_array(!null, $data['passive_talents'][3]) ){
                $err['error']['extraPassive'] = 'Fieldset should be complete';
            }
        }

        return $err;
    }

    static function add($data){
        
        $err = self::validate($data);

        if(self::is_character_exists($data['name'])){
            $err['error']['name'] = $data['name'] . " already exists";
        }
        
        if(!empty($err)){
            return $err;
        }

        if(in_array('', $data['skill_talents'][3])){
            unset($data['skill_talents'][3]);
        }

        if(in_array('', $data['passive_talents'][3])){
            unset($data['passive_talents'][3]);
        }

        $character = new Character();

        $character->name           = trim($data['name']) ?? "";
        $character->nickname       = trim($data['nickname']) ?? "";
        $character->vision         = trim($data['vision']) ?? "";
        $character->weapon         = trim($data['weapon']) ?? "";
        $character->rarity         = trim($data['rarity']) ?? "";
        $character->nation         = trim($data['nation']) ?? "";
        $character->description    = trim($data['description']) ?? "";
        $character->affiliation    = trim($data['affiliation']) ?? "";
        $character->constellation  = trim($data['constellation']) ?? "";
        $character->birthday       = $data['birthday']['month'] . " " . $data['birthday']['day'];
        $character->sex            = trim($data['sex']) ?? "";
        $character->release_date   = $data['release_date']['month'] . " " . $data['release_date']['day'] . " " . $data['release_date']['year'];
        $character->skillTalents   = json_encode(array_values($data['skill_talents'])) ?? "";
        $character->passiveTalents = json_encode(array_values($data['passive_talents'])) ?? "";
        $character->constellations = json_encode(array_values($data['constellations'])) ?? "";
        $character->tier           = trim($data['tier']) ?? "";

        return $character->create() ? $character : false;

    }

    static function edit($character, $input){
        
        $err = self::validate($input);

        if(self::is_character_exists($input['name']) && $character->name != $input['name']){
            $err['error']['name'] = $input['name'] . " already exists";
        }

        if(!empty($err)){
            return $err;
        }

        $oldName = $character->name;

        $character->name           = trim($input['name']);
        $character->nickname       = trim($input['nickname']);
        $character->vision         = trim($input['vision']);
        $character->weapon         = trim($input['weapon']);
        $character->rarity         = trim($input['rarity']);
        $character->nation         = trim($input['nation']);
        $character->description    = trim($input['description']);
        $character->affiliation    = trim($input['affiliation']);
        $character->constellation  = trim($input['constellation']);
        $character->birthday       = $input['birthday']['month'] . " " . $input['birthday']['day'];
        $character->sex            = trim($input['sex']) ?? "";
        $character->release_date   = $input['release_date']['month'] . " " . $input['release_date']['day'] . " " . $input['release_date']['year'];
        $character->skillTalents   = json_encode(array_values($input['skill_talents']));
        $character->passiveTalents = json_encode(array_values($input['passive_talents']));
        $character->constellations = json_encode(array_values($input['constellations']));
        $character->tier           = trim($input['tier']);

        if($character->update()){
            if(file_exists($character->imagePath . $oldName)){
                rename($character->imagePath . $oldName, $character->imagePath . strtolower($input['name']) );
            }
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
    
    function delete_character(){
        if($this->delete()){

            $name = strtolower($this->name);
            
            if( empty($name) || $name == "" ) return false;
            
            $path = IMAGES_ROOT . 'characters' . DS . $name;
            if(file_exists($path)){
                self::deleteDir($path);
            }

            return true;
        }
        return false;
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
        return $this->image_path() . "weapons" . DS  . $this->weapon . ".png";
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

    /****API**********/
    public static function fetch($name){
        //   $name = str_replace('-', ' ', $name);
          $character = self::where(["name = {$name}"])->get_single();

          if(empty($character)) return false;

          $character->skillTalents   = json_decode($character->skillTalents);
          $character->passiveTalents = json_decode($character->passiveTalents);
          $character->constellations = json_decode($character->constellations);
          unset($character->char_id);
          return json_encode($character);
       } 
}