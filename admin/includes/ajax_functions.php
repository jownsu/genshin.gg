<?php

require_once('Class/init.php');

if(isset($_POST['target_id'])){

    $id         = $_POST['target_id'];
    $category   = $_POST['image_category'];
    $image_name = $_POST['image_name'];

    if($category == "Users"){
        $targetTable = User::find($id);
    }

    if($targetTable){

        $targetTable->user_image = $image_name;

        if($targetTable->update()){
            exit(json_encode(['imgLocation' => 'images' . DS . $category . DS . $image_name]));
        }else{
            exit("There was an error updating");
        }
    }else{
        exit("Target not found");
    }
}




if(isset($_POST['idType'])){
    $id = $_POST['id'];
    $type = ucfirst(substr($_POST['idType'], 0, -1)) ?? "";

    $data = $type::find($id);

    if(!empty($data)){

        switch ($type) {
            case 'Character':
                if($data->delete_character()){
                    exit(json_encode(['location' => 'characters.php', 'message' => 'Character has been deleted']));
                }
                break;

            case 'Weapon':
                if($data->delete_weapon()){
                    exit(json_encode(['location' => 'weapons.php', 'message' => 'Weapon has been deleted']));
                }
                break;

            case 'Artifact':
                if($data->delete_artifact()){
                    exit(json_encode(['location' => 'artifacts.php', 'message' => 'Artifact has been deleted']));
                }
                break;

            case 'Consumable':
                if($data->delete_consumable()){
                    exit(json_encode(['location' => 'consumables.php', 'message' => 'Consumable has been deleted']));
                }
                break;

            case 'Post':
                if($data->delete_post()){
                    exit(json_encode(['location' => 'consumables.php', 'message' => 'Consumable has been deleted']));
                }
                break;
            
            default:
                if($data->delete()){
                    exit(json_encode(['location' => $_POST['idType'] . ".php", 'message' => "$type has been deleted"]));
                }
                break;
        }


    }else{
        exit(json_encode(['message' => 'There was an error on deleting']));
    }

}
