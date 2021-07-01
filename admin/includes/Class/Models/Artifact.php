<?php

class Artifact extends Model{
    use File;
    protected static $primary_key = "artif_id";

    private $artifact_placeholder = "artifact_placeholder.png";
    private $imagePath = "images" . DS . "artifacts" . DS;

    static function is_artifact_exists($name){
        $count = Artifact::count()->where(["name = $name"])->get();
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

        return $err;
    }

    static function add($data){
        global $session;

        $err = self::validate($data);

        if(self::is_artifact_exists($data['name'])){
            $err['error']['name'] = $data['name'] . " already exists";
        }
        
        if(!empty($err)){
            return $err;
        }
        
        $artifact = new Artifact();

        $artifact->name             = trim($data['name']) ?? "";
        $artifact->max_rarity       = trim($data['max_rarity']) ?? "";
        $artifact->two_piece_bonus  = trim($data['two_piece_bonus']) ?? "";
        $artifact->four_piece_bonus = trim($data['four_piece_bonus']) ?? "";

        return $artifact->create() ? $artifact : false;

    }

    static function edit($artifact, $input){
        global $session;
        
        $err = self::validate($input);

        if(self::is_artifact_exists($input['name']) && $artifact->name != $input['name']){
            $err['error']['name'] = $input['name'] . " already exists";
        }

        if(!empty($err)){
            return $err;
        }

        $oldName = $artifact->name;

        $artifact->name             = trim($input['name']);
        $artifact->max_rarity       = trim($input['max_rarity']);
        $artifact->two_piece_bonus  = trim($input['two_piece_bonus']);
        $artifact->four_piece_bonus = trim($input['four_piece_bonus']);

        if($artifact->update()){
            if(file_exists($artifact->imagePath . $oldName)){
                rename($artifact->imagePath . $oldName, $artifact->imagePath . strtolower($input['name']) );
            }
           return $artifact;
        }else{
            $session->set_message("<p class='red-text'>There is an error" .$input['name'] . " failed to update</p>");
            return false;
        }
    }

    public function upload($file, $filename = "image"){
        //code here
        $path = "../images/artifacts/";
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

    function delete_artifact(){
        if($this->delete()){

            $name = strtolower($this->name);
            
            if( empty($name) || $name == "" ) return false;
            
            $path = IMAGES_ROOT . 'artifacts' . DS . $name;
            if(file_exists($path)){
                self::deleteDir($path);
            }else{
                return false;
            }

            return true;
        }
        return false;
    }


    function artifact_img(){
        return !file_exists(IMAGES_ROOT . DS . 'artifacts' . DS . $this->name . DS . 'icon') 
        ? $this->image_path() . "artifacts" . DS . $this->artifact_placeholder 
        : $this->image_path() . "artifacts" . DS . $this->name . DS . 'icon';
    }

    function rarity(){
        return $this->image_path() . $this->max_rarity ." Star.png";
    }

}