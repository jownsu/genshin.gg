<?php

header('Access-Control-Allow-Origin: *');

include_once('../admin/includes/Class/init.php');


$type = ucfirst(substr($_GET['type'], 0, -1)) ?? "";
$name = str_replace('%20', ' ', $_GET['name']);
$data = $type::fetch($name);

if(!empty($data)){
    header('Content-Type: image/jpg');
    $path = "../admin/images/" . $_GET['type'] . "/" . $name . "/" . $_GET['img'];
    $image = file_get_contents($path);

    echo $image;
}else{
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Character not found']);
}

?>