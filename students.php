<?php
   // a php file for handle students registration
   require_once './inc/handleFileUpload.php';
   require_once './inc/headers.php' ;
   require_once './inc/databaseConfig.php' ;
   
   if( $_SERVER['REQUEST_METHOD'] === 'POST'){
   //function to prevent xss attact 
   $secure_input = fn($input) => htmlspecialchars($input) ;
  //store user data to the database if user deos not already exist.
       $sql = "SELECT * FROM students WHERE email = '{$_POST['email']}' ";
       $result = mysqli_query($conn , $sql) ;
       if( mysqli_num_rows($result) > 0 ){
         echo 'student already exist!' ;          
       }  
       else{
            // an object for handling file upload
            $handle_file_upload  = new HandleFileUpload($_FILES['file']) ;

            //validate uploaded file
            $handle_file_upload -> checkExtension() ;
            $handle_file_upload -> isFileExist() ;
            $handle_file_upload -> LimitUploadSize() ;
            $handle_file_upload -> isFileUploaded() ;

            //secure user password using password hashing.
            $password = password_hash($secure_input($_POST["password"]),PASSWORD_DEFAULT) ;
            //store image path to the database
            $image_path = ( empty($_FILES['file']['name']) )  ?  '' :
                            'uploads/'.basename($_FILES['file']['name'])  ;  
            $sql =   <<<query
                           INSERT INTO `students` (
                                    `id`, `name`, `email`,
                                    `gender`, `blood_group`,
                                    `class`, `course`, `date_registered`, 
                                    `age`, `password`, `dob`, `image`, `phone`,
                                    `address`
                              )
                              VALUES ( 
                                          NULL, '{$secure_input($_POST["name"])}', 
                                             '{$secure_input($_POST["email"])}', 
                                          '{$secure_input($_POST["gender"])}',
                                             '{$secure_input($_POST["bloodGroup"])}', 
                                          '{$secure_input($_POST["class"])}'
                                          , '{$secure_input($_POST["course"])}',
                                             current_timestamp(), 
                                             '{$secure_input($_POST["age"])}', 
                                             '{$password}', '{$secure_input($_POST["dob"])}', 
                                             '$image_path', '{$secure_input($_POST["phone"])}', 
                                             '{$secure_input($_POST["address"])}'
                                   )
                      query;
             if($handle_file_upload -> isOk ){
                  //sign a new user
                  if( mysqli_query($conn,$sql)) {
                        $handle_file_upload -> messege = 'student was registered successfully!';
                        echo  $handle_file_upload -> messege ;
                  } 
              }
              else echo $handle_file_upload -> messege ;
       }          
   }    

?>