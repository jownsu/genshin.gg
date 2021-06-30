<?php

class Consumable extends Model{
    use File;
    protected static $primary_key = "con_id";

    private $consumables_placeholder = "consumables_placeholder.png";
    private $imagePath = "images" . DS . "consumables" . DS;

    static function is_consumable_exists($name){
        $count = Consumable::count()->where(["name = $name"])->get();
        return $count > 0 ? true : false;
    }

    static function add($data){
        global $session;

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $data['name'])){
            $session->set_message("<p class='red-text'>Some special characters not allowed</p>");
            return false;
        }

        if(self::is_consumable_exists($data['name'])){
            $session->set_message("<p class='red-text'>" .$data['name'] . " already exists</p>");
            return false;
        } 
        
        $consumable = new Consumable();

        $consumable->name        = trim($data['name']) ?? "";
        $consumable->category    = trim($data['category']) ?? "";
        $consumable->type        = trim($data['type']) ?? "";
        $consumable->rarity      = trim($data['rarity']) ?? "";
        $consumable->bonus       = trim($data['bonus']) ?? "";
        $consumable->ingredients = trim($data['ingredients']) ?? "";

        // return $consumable->create() ? $consumable : false;
        if($consumable->create()){
            return $consumable;
        }else{
            $session->set_message("<p class='red-text'>There is an error." .$data['name'] . " failed to add</p>");
            return false;
        }
    }

    static function edit($consumable, $input){
        global $session;

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $input['name'])){
            $session->set_message("<p class='red-text'>Some special characters not allowed</p>");
            return false;
        }

        if(self::is_consumable_exists($input['name']) && $consumable->name != $input['name']){
            $session->set_message("<p class='red-text'>" .$input['name'] . " already exists</p>");
            return false;
        } 

        $oldName = $consumable->name;

        $consumable->name        = trim($input['name']);
        $consumable->category    = trim($input['category']);
        $consumable->type        = trim($input['type']);
        $consumable->rarity      = trim($input['rarity']);
        $consumable->bonus       = trim($input['bonus']);
        $consumable->ingredients = trim($input['ingredients']);

        if($consumable->update()){
            if(file_exists($consumable->imagePath . $oldName)){
                rename($consumable->imagePath . $oldName, $consumable->imagePath . strtolower($input['name']) );
            }
           return $consumable;
        }else{
            $session->set_message("<p class='red-text'>There is an error" .$input['name'] . " failed to update</p>");
            return false;
        }
    }

    public function upload($file, $filename = "image"){
        //code here
        $path = "../images/consumables/";
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

    function delete_consumable(){
        if($this->delete()){

            $name = strtolower($this->name);
            
            if( empty($name) || $name == "" ) return false;
            
            $path = IMAGES_ROOT . 'consumable' . DS . $name;
            if(file_exists($path)){
                unlink($path);
            }else{
                return false;
            }

            return true;
        }
        return false;
    }


    function consumables_img(){
        $name = str_replace(" ", "_", $this->name);

        return !file_exists(IMAGES_ROOT . DS . 'consumables' . DS . $this->name . DS ."icon") 
        ? $this->image_path() . "consumables" . DS . $this->consumables_placeholder 
        : $this->image_path() . "consumables" . DS . $this->name . DS ."icon";
    }

    function rarity(){
        return $this->image_path() . $this->rarity ." Star.png";
    }

}