<?php 
     require_once './inc/headers.php' ;
   require_once './inc/handleFileUpload.php';
   require_once './inc/headers.php' ;
   require_once './inc/databaseConfig.php' ;

   if( $_SERVER['REQUEST_METHOD'] === 'POST'){
   //function to prevent xss attact 
   $secure_input = fn($input) => htmlspecialchars($input) ;
  //store user data to the database if user deos not already exist.
       $sql = "SELECT * FROM teachers WHERE email = '{$_POST['temail']}' ";
       $result = mysqli_query($conn , $sql) ;
       if( mysqli_num_rows($result) > 0 ){
         echo 'teacher already exist!' ;          
       }  
       else{
            // an object for handling file upload
            $handle_file_upload  = new HandleFileUpload($_FILES['tfile']) ;

            //validate uploaded file
            $handle_file_upload -> checkExtension() ;
            $handle_file_upload -> isFileExist() ;
            $handle_file_upload -> LimitUploadSize() ;
            $handle_file_upload -> isFileUploaded() ;

            //secure user password using password hashing.
            $password = password_hash($secure_input($_POST["tpassword"]),PASSWORD_DEFAULT) ;
            //store image path to the database
            $image_path = ( empty($_FILES['tfile']['name']) )  ?  '' :
                            'uploads/'.basename($_FILES['tfile']['name'])  ;  
            $sql =   <<<query
                            INSERT INTO `teachers` (
                                    `name`, `id`, `email`, `password`,
                                    `age`, `image`, `date_registered`, `address`,
                                    `course`, `qualification`
                                )
                                VALUES ( 
                                    '{$secure_input($_POST["tname"])}',  NULL ,
                                       '{$secure_input($_POST["temail"])}', 
                                    '{$secure_input($_POST["tpassword"])}',
                                    '{$secure_input($_POST["tage"])}',
                                    '{$image_path}',
                                      current_timestamp(),                                              
                                     '{$secure_input($_POST["taddress"])}',                                               
                                       '{$secure_input($_POST["tcourse"])}', 
                                       '{$secure_input($_POST["tqualification"])}'
                             )
                    query;
             if($handle_file_upload -> isOk ){
                  //sign a new user
                  if( mysqli_query($conn,$sql)) {
                        $handle_file_upload -> messege = 'teacher was registered successfully!';
                        echo  $handle_file_upload -> messege ;
                  } 
              }
              else echo $handle_file_upload -> messege ;
       }         
   }    
   
?>