<?php

class Post extends Model{

    protected static $primary_key = "post_id";



    /*******Uploading Properties******/

    private $image_tmpname;
    private $image_dir = 'Posts';

    public function author(){
        $author = User::find($this->user_id, 'username, user_id');
        return $author;
    }

    static function add($data){
        global $session;
        
        $post = new Post();

        $post->title        = trim($data['title']) ?? "";
        $post->description  = trim($data['description']) ?? "";
        $post->tags         = isset($data['tags']) ? implode(", ", $data['tags']) : '';
        $post->post_status  = trim($data['status']) ?? "";
        $post->date         = date("F d, Y");
        $post->user_id      = $session->id;

        return $post->create() ? $post : false;
    }

    static function edit($post, $input){

        $post->title        = trim($input['title']) ?? "";
        $post->description  = trim($input['description']) ?? "";
        $post->tags         = isset($input['tags']) ? implode(", ", $input['tags']) : '';
        $post->post_status  = trim($input['status']) ?? "";
        $post->date         = date("F d, Y");

        return $post->update() ? $post : false;

    }


    function create_post(){
        if(!empty($this->errors)){
            return false;
        }
        
        if($this->create()){
            $this->move_files();
            return true;
        }else{
            return false;
        }
    }

    private function move_files(){
        if(isset($this->image_tmpname)){
            move_uploaded_file($this->image_tmpname, IMAGES_ROOT . DS . $this->image_dir . DS . $this->image);
        }
    }

    function set_image($file){

        $this->check_files($file);

        $this->image = basename($file['name']);
        $this->image_tmpname = $file['tmp_name'];
    }

    function post_image_path(){
        return $this->image_path() . $this->image_dir . DS . $this->image;
    }

    function post_description(){
        return substr($this->description, 0, 250);
    }

    function post_tags(){
        return explode(', ', $this->tags);
    }
}