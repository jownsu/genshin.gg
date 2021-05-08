<?php

require_once("config.php");

class Database{


    private $connection;

    function __construct(){
        $this->open_db(); 
    }

    function open_db(){
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->connection->connect_errno){
            die("Database Connection Error " . $this->connection->connect_error);
        }
        return $this->connection;
    }

    function query($sql){
        $result = $this->connection->query($sql);
        $this->confirm_query($sql);
        return $result;
    }

    function confirm_query($result){
        if(!$result){
            die("Query Error! " . $this->connect_error);
        }
    }

    function escape_string($str){
        return $this->connection->real_escape_string($str);
    }

    function insert_id(){
        return $this->connection->insert_id;
    }

}

$db = new Database();