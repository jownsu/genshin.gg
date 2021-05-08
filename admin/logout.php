<?php
    require_once("includes/Class/init.php");

    $session->logout();
    header("location: login.php");
