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

    static function add($data){
        global $session;
        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $data['name'])){
            $session->set_message("<p class='red-text'>Some special characters not allowed</p>");
            return false;
        }
        if(self::is_artifact_exists($data['name'])){
            $session->set_message("<p class='red-text'>" .$data['name'] . " already exists</p>");
            return false;
        } 
        
        $artifact = new Artifact();

        $artifact->name             = trim($data['name']) ?? "";
        $artifact->max_rarity       = trim($data['max_rarity']) ?? "";
        $artifact->two_piece_bonus  = trim($data['two_piece_bonus']) ?? "";
        $artifact->four_piece_bonus = trim($data['four_piece_bonus']) ?? "";

        // return $artifact->create() ? $artifact : false;
        if($artifact->create()){
            return $artifact;
        }else{
            $session->set_message("<p class='red-text'>There is an error." .$data['name'] . " failed to add</p>");
            return false;
        }
    }

    static function edit($artifact, $input){
        global $session;
        
        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $input['name'])){
            $session->set_message("<p class='red-text'>Some special characters not allowed</p>");
            return false;
        }

        if(self::is_artifact_exists($input['name']) && $artifact->name != $input['name']){
            $session->set_message("<p class='red-text'>" .$input['name'] . " already exists</p>");
            return false;
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