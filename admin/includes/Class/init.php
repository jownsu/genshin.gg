<?php

define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', dirname(__DIR__, 3));
define('IMAGES_ROOT', dirname(__DIR__, 2) . DS . "images");

require_once("Database.php");
require_once("Db_objects.php");
require_once("User.php");
require_once("Character.php");
require_once("Post.php");
require_once("Comment.php");
require_once("Session.php");
require_once("Paginate.php");
require_once("functions.php");