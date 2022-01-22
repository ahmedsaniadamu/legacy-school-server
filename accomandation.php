<?php
   // a php file for handling accomandations
  require_once './inc/headers.php' ;
  require_once './inc/databaseConfig.php' ;
   
  $_POST = json_decode( file_get_contents('php://input') , true ) ;
  
  if( isset( $_POST['name'] , $_POST['email'] , $_POST['admissionNo'] ,
    $_POST['class'],$_POST['room'] , $_POST['gender'] )){
          
         // check if student exist
         $sql = "SELECT * FROM students WHERE email='{$_POST['email']}' AND 
                 id='{$_POST['admissionNo']}' AND class='{$_POST['class']}' 
                 AND gender = '{$_POST['gender']}'" ;

         $result = mysqli_query($conn,$sql) ;

        if(mysqli_num_rows($result) > 0 ){       
            // check and insert. sudent that is trying to apply for hostel     
            switch($_POST['gender']){                
                 case 'female' :
                     //check if student is already registered.
                    $sql = "SELECT * FROM female_hostel WHERE email = '{$_POST['email']}'" ;  
                    if( mysqli_num_rows(mysqli_query($conn,$sql)) ){
                        echo 'student already applied for accomandation' ;
                    }   
                    //register a new student 
                    else {
                            $sql = "INSERT INTO `female_hostel` ( 
                                        `id`,`name`,`email`,`admission_no`,
                                        `room_no`,`class`,`date_registered`
                                     )
                                    VALUES( 
                                        NULL,'{$_POST['name']}','{$_POST['email']}',
                                        '{$_POST['admissionNo']}','{$_POST['room']}',
                                        '{$_POST['class']}',current_timestamp()
                                    )";
                            if(mysqli_query($conn,$sql)){
                                echo 'student accomandation was registered successfully!' ;
                            }
                    }
                case 'male' :
                     //check if student is already registered.
                     $sql = "SELECT * FROM male_hostel WHERE email = '{$_POST['email']}'" ;  
                     if( mysqli_num_rows(mysqli_query($conn,$sql)) ){
                         echo 'student already applied for accomandation' ;
                     }   
                     //register a new student 
                     else {
                             $sql = "INSERT INTO `male_hostel` ( 
                                         `id`,`name`,`email`,`admission_no`,
                                         `room_no`,`class`,`date_registered`
                                      )
                                     VALUES( 
                                         NULL,'{$_POST['name']}','{$_POST['email']}',
                                         '{$_POST['admissionNo']}','{$_POST['room']}',
                                         '{$_POST['class']}',current_timestamp()
                                     )";
                             if(mysqli_query($conn,$sql)){
                                 echo 'student accomandation was registered successfully!' ;
                             }
                     }
            }                        
        }
        else echo 'Error! student information was incorrect please check and try again.' ;

    }    
?>