<?php 
   require_once './inc/headers.php' ;
   require_once './inc/databaseConfig.php' ;
   require_once './inc/handleFileUpload.php' ;

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
   //check wether a user is will update his profile image and allow file upload.
    if (!empty($_FILES['file']['name'])) {
       $sql = '';
        // an object for handling file upload
        $handle_file_upload  = new HandleFileUpload($_FILES['file']) ;

        //validate uploaded file
        $handle_file_upload -> checkExtension() ;
        $handle_file_upload -> isFileExist() ;
        $handle_file_upload -> LimitUploadSize() ;
        $handle_file_upload -> isFileUploaded() ;

        //check either a user uploads an image
        $image_path = ( empty($_FILES['file']['name']) )  ?  '' :
                               'uploads/'.basename($_FILES['file']['name'])  ; 
        if ($handle_file_upload -> isOk) {
             switch($_POST['user']){                
                case 'student' :
                   //check and delete the previously uploaded file.
                  if(!empty($_FILES['file']['name'])){
                     $sql = "SELECT image FROM students WHERE email='{$_POST['email']}'" ;
                      $result = mysqli_query($conn,$sql) ;
                      if($result){
                         //delete user previous image from the server.
                         $prev_uploaded_image = mysqli_fetch_assoc($result)['image'];
                          if(file_exists($prev_uploaded_image)) unlink($prev_uploaded_image);
                      }   
                  }
                     $sql = "UPDATE students SET name='{$_POST['name']}',email='{$_POST['email']}',
                         gender='{$_POST['gender']}',blood_group='{$_POST['bloodGroup']}',
                         class='{$_POST['class']}',course='{$_POST['course']}',age='{$_POST['age']}',
                         dob = '{$_POST['dob']}', phone='{$_POST['phone']}',image='{$image_path}',
                         address = '{$_POST['address']}' WHERE email='{$_POST['email']}'
                       ";
                   $result = mysqli_query($conn,$sql);
                   if($result) {
                        //display the updated student
                         $sql = "SELECT * FROM students WHERE email='{$_POST['email']}'" ;
                         $result = mysqli_query($conn,$sql);
                         if($result) {
                           echo  json_encode([
                              'status' => 1 ,
                              'messege' => "student's record is updated successfully!" ,
                              'info' => mysqli_fetch_assoc($result) ,
                           ]) ; 
                         }                          
                   }                    
                   else  echo  json_encode([
                                       'status' => 0 ,
                                       'messege' => 'Sorry an unknown error occured'  ,
                                    ]) ;                      
               break ;
               case 'teacher' :
                   //check and delete the previously uploaded file.
                   if(!empty($_FILES['file']['name'])){
                     $sql = "SELECT image FROM teachers WHERE email='{$_POST['email']}'" ;
                      $result = mysqli_query($conn,$sql) ;
                      if($result){
                         //delete user previous image from the server.
                         $prev_uploaded_image = mysqli_fetch_assoc($result)['image'];
                          if(file_exists($prev_uploaded_image)) unlink($prev_uploaded_image);
                      }   
                  }
                     $sql = "UPDATE teachers SET name='{$_POST['name']}',email='{$_POST['email']}',                         
                             course='{$_POST['course']}',age='{$_POST['age']}',
                             image='{$image_path}',qualification='{$_POST['qualification']}',
                             address = '{$_POST['address']}' WHERE email='{$_POST['email']}'
                       ";
                   $result = mysqli_query($conn,$sql);
                   if($result) {
                      //display the updated student 
                         $sql = "SELECT * FROM teachers WHERE email='{$_POST['email']}'" ;
                         $result = mysqli_query($conn,$sql);
                         if($result) {
                           echo  json_encode([
                              'status' => 1 ,
                              'messege' => "teacher's record is updated successfully!" ,
                              'info' => mysqli_fetch_assoc($result) ,
                           ]) ; 
                         }                          
                   }                    
                   else  echo  json_encode([
                                       'status' => 0 ,
                                       'messege' => 'Sorry an unknown error occured'  ,
                                    ]) ;                      
               break ;                  
             }
        }
        else echo  json_encode([
            'status' => 0 ,
            'messege' => $handle_file_upload -> messege ,
           ]) ;
        }
 else {
         switch($_POST['user']){
            case 'student' :
               $sql = "UPDATE students SET name='{$_POST['name']}',email='{$_POST['email']}',
               gender='{$_POST['gender']}',blood_group='{$_POST['bloodGroup']}',
               class='{$_POST['class']}',course='{$_POST['course']}',age='{$_POST['age']}',
               dob = '{$_POST['dob']}', phone='{$_POST['phone']}',address = '{$_POST['address']}'
                WHERE email='{$_POST['email']}'
               ";
              $result = mysqli_query($conn,$sql);
             if($result) { 
                  $sql = "SELECT * FROM students WHERE email='{$_POST['email']}'" ;
                  $result = mysqli_query($conn,$sql);
                   if($result) {
                        echo  json_encode([
                           'status' => 1 ,
                           'messege' => "student's record is updated successfully!" ,
                           'info' => mysqli_fetch_assoc($result) ,
                        ]) ; 
                  }     
             }
             break ;
             case 'teacher' :
                $sql = "UPDATE teachers SET name='{$_POST['name']}',email='{$_POST['email']}',                         
                             course='{$_POST['course']}',age='{$_POST['age']}',
                             qualification='{$_POST['qualification']}',
                             address = '{$_POST['address']}' WHERE email='{$_POST['email']}'
                       ";
               $result = mysqli_query($conn,$sql);
              if($result) { 
                  $sql = "SELECT * FROM teachers WHERE email='{$_POST['email']}'" ;
                  $result = mysqli_query($conn,$sql);
                   if($result) {
                        echo  json_encode([
                           'status' => 1 ,
                           'messege' => "teacher's record is updated successfully!" ,
                           'info' => mysqli_fetch_assoc($result) ,
                        ]) ; 
                  }     
             }
             break ;             
        }
      }   
   }
?>