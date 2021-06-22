<?php

class User extends Model{

    protected static $primary_key = "user_id";

    private $image_placeholder = "userplaceholder.jpg";
    private $image_directory = "Users";


    static function add($data){

        $user = new User();

        $user->username          = trim($data['username']);
        $user->firstname         = trim($data['firstname']);
        $user->lastname          = trim($data['lastname']);
        $user->email             = trim($data['email']);
        $user->gender            = trim($data['gender']);
        $user->birthday          = $data['birthday']['month'] . ' ' . $data['birthday']['day'] . ' ' . $data['birthday']['year'];
        $user->status            = trim($data['status']);
        $user->role              = trim($data['role']);
        $user->security_question = trim($data['security_question']);
        $user->set_password($password); 
        $user->set_security_answer($security_answer);

        return $user->create() ? $user : false;
        
    }

    static function edit($user, $input){
        $user->username          = trim($input['username']);
        $user->firstname         = trim($input['firstname']);
        $user->lastname          = trim($input['lastname']);
        $user->email             = trim($input['email']);
        $user->gender            = trim($input['gender']);
        $user->birthday          = $input['birthday']['month'] . ' ' . $input['birthday']['day'] . ' ' . $input['birthday']['year'];
        $user->status            = trim($input['status']);
        $user->role              = trim($input['role']);
        // $user->security_question = trim($input['security_question']);
        // $user->set_password($password); 
        // $user->set_security_answer($security_answer);

        return $user->update() ? $user : false;
    }

    static function verify_user($username, $password){
        $user = self::where(["username = " . $username])->get_single();

        if(!$user){
            return false;
        }

        return password_verify($password, $user->password) ? $user : false;
    }

    static function find_forgotten_user($username, $security_question, $security_answer){
        global $db;

        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE username = :username AND security_question = :security_question LIMIT 1";

        $result = self::find_query($sql, [':username' => $username, ':security_question' => $security_question]);
        $user = !empty($result) ? array_shift($result) : false;

        if(!$user){
            return false;
        }

        return password_verify($security_answer, $user->security_answer) ? $user : false;
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
        // $sql = "SELECT COUNT(*) FROM " . self::$db_table . " WHERE status = 'Inactive'";
        $count = self::count()->where(['status = Inactive'])->get();

        // $db->query($sql);
        return $count;
    }


}