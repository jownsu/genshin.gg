<?php

class User extends Db_objects{

    protected static $db_table = "users";
    protected static $db_table_fields = ['username', 'password', 'firstname', 'lastname', 'gender', 'birthday', 'email', 'role', 'security_question', 'security_answer', 'status', 'user_image'];
    protected static $db_table_id = "user_id";
    
    public $user_id;
    public $username;
    public $password;
    public $gender;
    public $birthday;
    public $email;
    public $firstname;
    public $lastname;
    public $role;
    public $security_question;
    public $security_answer;
    public $status;
    public $user_image;

    private $image_placeholder = "userplaceholder.jpg";
    private $image_directory = "Users";

    static function verify_user($username, $password){
        global $db;

        $user = $db->escape_string($username);
        $pass = $db->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE username = '" . $user . "' LIMIT 1";

        $result = self::find_query($sql);
        $user = !empty($result) ? array_shift($result) : false;

        if(!$user){
            return false;
        }

        return password_verify($pass, $user->password) ? $user : false;
    }

    function set_password($pwd){
        $this->password = password_hash($pwd, PASSWORD_DEFAULT);
    }

    function set_security_answer($ans){
        $this->security_answer = password_hash($ans, PASSWORD_DEFAULT);
    }

    function set_birthday($month, $day, $year){
        $this->birthday = $month . " " . $day . " " . $year;
    }

    function get_birthday(){
        return explode(" ", $this->birthday);
    }
    
    function user_image_path(){
        return empty($this->user_image) ? $this->image_path() . $this->image_placeholder : $this->image_path() . $this->image_directory . DS . $this->user_image;
    }


    static function count_inactive(){
        global $db;

        $sql = "SELECT COUNT(*) FROM " . self::$db_table . " WHERE status = 'Inactive'";

        $result = $db->query($sql);
        $row = mysqli_fetch_array($result);
        return array_shift($row);
    }


}