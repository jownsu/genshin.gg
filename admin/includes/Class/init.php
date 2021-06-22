<?php

define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', dirname(__DIR__, 3));
define('IMAGES_ROOT', dirname(__DIR__, 2) . DS . "images");

require_once("Database.php");
require_once("Model.php");
require_once("Models/User.php");
require_once("Models/Character.php");
require_once("Models/Post.php");
require_once("Models/Comment.php");
require_once("Session.php");
require_once("Paginate.php");
require_once("functions.php");