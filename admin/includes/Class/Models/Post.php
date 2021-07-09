<?php

class Post extends Model{
    use File;
    
    protected static $primary_key = "post_id";

    private $imagePath = "images" . DS . "Posts" . DS;
    private $post_placeholder = "post_placeholder.jpg";


    /*******Uploading Properties******/

    private $image_tmpname;
    private $image_dir = 'Posts';

    public function author(){
        $author = User::find($this->user_id, 'username, user_id');
        return $author;
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

        return $err;
    }

    static function add($data, $image = ""){
        global $session;

        $err = self::validate($data);

        if(!empty($err)){
            return $err;
        }

        $post = new Post();

        $post->title        = $data['title'] ?? "";
        $post->description  = $data['description'] ?? "";
        $post->image        = $image ?? "";
        $post->tags         = isset($data['tags']) ? implode(", ", $data['tags']) : '';
        $post->post_status  = $data['status'] ?? "";
        $post->date         = date("F d, Y");
        $post->user_id      = $session->id;

        return $post->create() ? $post : false;
    }

    static function edit($post, $input, $image){

        $err = self::validate($input);

        if(!empty($err)){
            return $err;
        }

        $post->title        = trim($input['title']);
        $post->description  = trim($input['description']);
        $post->image        = $image ?? $post->image;
        $post->tags         = isset($input['tags']) ? implode(", ", $input['tags']) : '';
        $post->post_status  = trim($input['status']);
        $post->date         = date("F d, Y");

        return $post->update() ? $post : false;

    }

    static function rename_img($file){
        if(empty($file)) return $file;
        $imagePath = "images" . DS . "Posts" . DS;

        $filename = self::rename_if_exists($imagePath ,$file);
        
        return $filename;
    }

    public function upload($file, $filename, $oldimage = null){
        //code here
        $path = IMAGES_ROOT . 'Posts' . DS;
        // $name = strtolower($this->name);

         if(!file_exists($this->imagePath)){
            mkdir($this->imagePath);
         }

        //  if(!file_exists($this->imagePath . $name)){
        //     mkdir($this->imagePath . $name);
        //  }

         if($this->check_files($file)){
        //    $filename = $this->rename_if_exists($this->imagePath ,$file['name']);

           move_uploaded_file($file['tmp_name'], $this->imagePath . $filename);
           if(!empty($oldimage)){
                unlink($path . $oldimage);   
           }
           return true;

         }else{
            return false;
         }
     }


     function delete_post(){
        if($this->delete()){

            if(!empty($this->image)){
                $image = strtolower($this->image);
            
                // if( empty($image) || $image == "" ) return false;
                
                $path = IMAGES_ROOT . 'Posts' . DS . $image;
    
                if(file_exists($path)){
                    unlink($path);
                }
            }
            return true;
        }
        return false;
    }

    function post_image_path(){
        return (file_exists(IMAGES_ROOT . DS . 'Posts' . DS . $this->image) && !empty($this->image) )
        ? $this->image_path() . "Posts" . DS . $this->image 
        : $this->image_path() . "Posts" . DS . $this->post_placeholder;

    }

    function post_description(){
        return substr($this->description, 0, 250);
    }

    function post_tags(){
        return explode(', ', $this->tags);
    }
}