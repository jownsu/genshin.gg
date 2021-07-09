<?php
include_once('../admin/includes/Class/init.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$type = ucfirst(substr($_GET['type'], 0, -1)) ?? "";
$name = str_replace('%20', ' ', $_GET['name']);
$data = $type::fetch($name);

echo $data ?? json_encode(['message' => $name . " not found"]);


?>