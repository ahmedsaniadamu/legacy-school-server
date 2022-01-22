<?php 
 // a class for handling file upload
 final class HandleFileUpload{
       
       public $uploadFile ;
       public static $extension = ['jpg','png','jpeg'] ;
       public $isOk = true ;
       public $messege ;     


       public function __construct($uploadFile){
           $this -> uploadFile = $uploadFile ;
       }

       public function targetFile(){
           return 'uploads/'.basename($this->uploadFile['name']) ;
       }

       public function tmpName(){
            return $this->uploadFile['tmp_name'] ;
       }

       public function checkExtension(){
          if(  !in_array( strtolower(pathinfo( $this->targetFile() , PATHINFO_EXTENSION )),
               self::$extension ) && !empty($this->uploadFile['name']) ){
                $this ->messege = 'Error image is not one of the required format. 
                                      use png , jpg , jpeg images' ;
                $this->isOk = false ;
          }
       }
     
       public function isFileExist(){
         if( !empty($this->uploadFile['name']) && file_exists( $this-> targetFile() ) ){
            $this ->messege = 'Error file already exist' ;
            $this->isOk = false ;
          }
       }
       
       public function LimitUploadSize(){
           if(!empty($this->uploadFile['name']) && $this-> uploadFile['size']  > 1000 * 1024 ){
                $this ->messege = 'Error file is too large. upload size is limited to 1mb' ;
                $this->isOk = false ;
           }
       }

       public function isFileUploaded(){
           if( $this-> isOk && !empty($this->uploadFile['name'])){
               if( move_uploaded_file( $this-> tmpName() , $this-> targetFile() )){
                   $this-> isOk = true ;
               }
           }
       }
  }
 ?>
