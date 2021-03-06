<?php

    define('DS', DIRECTORY_SEPARATOR);
    define('SITE_ROOT', dirname(__DIR__, 3));
    define('IMAGES_ROOT', dirname(__DIR__, 2) . DS . "images" . DS);

trait File{

    protected $errors = array();
    protected $upload_errors_arr = array(
        UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded in either thumbnail or portrait',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    );

    protected function image_path(){
        return strpos(getcwd(), 'admin') ? 'images' . DS  : "admin" . DS . "images" . DS;
    }
    
    protected function check_files($file){
        if(empty($file) || !is_array($file)){
            $this->errors[] = "There is no file uploaded";
            return false;
        }

        if($file['error'] != 0){
            $this->errors = $this->upload_errors_arr[$file['error']];
            return false;
        }

        if(preg_match("/.exe$|.com$|.bat$|.zip$|.doc$|.txt$/i", $file['name'])){
            $this->errors[] = "You cannot upload this type of file.";
            return false;
          }

        return true;
    }

    static protected function rename_if_exists($path, $filename){
        if(file_exists($path . DS . $filename)){
            $count = 1;
            list($name, $extension) = explode('.', $filename);
            while(file_exists($path . DS . $filename)) {
                $filename = $name . "(" . $count . ")" . '.' . $extension;    
                $count++;
            }
        }

        return $filename;
    }

    function get_errors(){
        return $this->errors;
    }

    static protected function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }


}