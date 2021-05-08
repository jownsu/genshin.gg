<?php

define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', "E:".DS."xampp".DS."htdocs".DS."Projects".DS."genshin.gg");
define('IMAGES_ROOT', "E:".DS."xampp".DS."htdocs".DS."Projects".DS."genshin.gg".DS."admin".DS."images");

require_once("Database.php");
require_once("Db_objects.php");
require_once("User.php");
require_once("Character.php");
require_once("Post.php");
require_once("Comment.php");
require_once("Session.php");
require_once("Paginate.php");
require_once("functions.php");