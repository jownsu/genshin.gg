<?php

class Session{

    public $id;
    public $username;
    public $role;
    public $image_path;
    public $message;
    private $signed_in = false;

    function __construct(){
        session_start();
        $this->check_login();
        $this->check_message();
    }

    function login($user){
        if($user){
            $this->id        = $_SESSION['id']       = $user->user_id;
            $this->username  = $_SESSION['username'] = $user->username;
            $this->role      = $_SESSION['role']     = $user->role;
            $this->image_path      = $_SESSION['image_path']     = $user->user_image_path();
            $this->signed_in = true;
        }
    }

    function logout(){
        unset($this->id);
        unset($this->username);
        unset($this->role);
        unset($this->image_path);
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['image_path']);
        session_destroy();
        $this->signed_in = false;
    }

    function is_signed_in(){
        return $this->signed_in;
    }

    function check_login(){
        if(isset($_SESSION['id'])){
            $this->id         = $_SESSION['id'];
            $this->username   = $_SESSION['username'];
            $this->role       = $_SESSION['role'];
            $this->image_path = $_SESSION['image_path'];
            $this->signed_in  = true;
        }else{
            unset($this->id);
            unset($this->username);
            unset($this->role);
            unset($this->image_path);
            $this->signed_in = false;
        }
    }

    function check_message(){
        if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            unset($this->message);
        }
    }

    function set_message($msg){
        $this->message = $_SESSION['message'] = $msg;
    }

    function get_username(){
        return isset($this->username) ? $this->username : 'Guest';
    }


}

$session = new Session();