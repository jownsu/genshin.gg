<?php

class User extends Model{
    use File;
    protected static $primary_key = "user_id";

    private $image_placeholder = "userplaceholder.jpg";
    private $image_directory = "Users";

    static function is_username_exists($username){
        $count = User::count()->where(["username = $username"])->get();
        return $count > 0 ? true : false;
    }

    private static function validate($data){
        $err = array();

        foreach(array_keys($data) as $key){
            if(is_string($data[$key])){
                $data[$key] = trim($data[$key]);
            }
        }

        if(in_array(null, $data)){
            $err['error']['empty'] = 'Field cannot be empty';
        }

        if(preg_match("/[!$%^&*()_+|~=`{}\[\]:\";<>?,.\/]/", $data['username'])){
            $err['error']['username'] = "!$%^&*()_+|~=`{}[]:;<>?,./\” characters not allowed";
        }

        if(!empty($data['password']) && !empty($data['confirm_password'])){
            if($data['password'] != $data['confirm_password']){
                $err['error']['password'] = "Password not match";
            }
        }

        if(!empty($data['security_answer']) && !empty($data['confirm_security_answer'])){
            if($data['security_answer'] != $data['confirm_security_answer']){
                $err['error']['sec_answer'] = "Security answer not match";
            }
        }

        if(!empty($data['email'])){
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $err['error']['email'] = 'Invalid email format';
            }
        }


        return $err;
    }

    static function add($data){

        $err = self::validate($data);

        if(self::is_username_exists($data['username'])){
            $err['error']['username'] = $data['username'] . " already exists";
        }
        
        if(!empty($err)){
            return $err;
        }

        $user = new User();

        $user->username          = trim($data['username']);
        $user->firstname         = trim($data['firstname']);
        $user->lastname          = trim($data['lastname']);
        $user->email             = trim($data['email']);
        $user->status            = trim($data['status']);
        $user->role              = trim($data['role']);
        $user->security_question = trim($data['security_question']);
        $user->set_password($data['password']); 
        $user->set_security_answer($data['security_answer']);

        return $user->create() ? $user : false;
        
    }

    static function edit($user, $input){

        $err = self::validate($input);

        if(self::is_username_exists($input['username']) && $user->username != $input['username'] ){
            $err['error']['username'] = $input['username'] . " already exists";
        }
        
        if(!empty($err)){
            return $err;
        }


        $user->username          = trim($input['username']);
        $user->firstname         = trim($input['firstname']);
        $user->lastname          = trim($input['lastname']);
        $user->email             = trim($input['email']);
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

        $sql = "SELECT * FROM " . self::table();
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