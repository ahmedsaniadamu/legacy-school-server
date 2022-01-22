<?php
  /* a php file for handling all login admin , student , teacher based on usertype recieved
    from client side */

  require_once './inc/headers.php' ;
  require_once './inc/databaseConfig.php' ;
   
  $_POST = json_decode( file_get_contents('php://input') , true ) ;
  
  //detect which user is trying to login.
  if( isset( $_POST['user'] , $_POST['email'] , $_POST['password'])){
    $sql = '' ;

      switch($_POST['user']){
           case 'student' : 
                $sql = " SELECT * FROM students  WHERE email = '{$_POST['email']}'" ;
            break;
           case 'teacher' :
                 $sql = " SELECT * FROM teachers  WHERE email = '{$_POST['email']}'" ;
            break ;
           case 'admin' : 
                $sql = " SELECT * FROM admin  WHERE email = '{$_POST['email']}'" ;
            break ;
       }

       $result = mysqli_query($conn,$sql) ;
         //verify email address
         if(mysqli_num_rows($result)){
                #verify  password using password hashing.
                $user_login = mysqli_fetch_assoc($result) ;
                if( password_verify( $_POST['password'] , $user_login['password'] ) ){
                        //add  success status code to the  array.
                        $user_login['status'] = 1 ;
                        echo  json_encode($user_login) ;
                }  
                else echo json_encode([
                                        'status' => 0 , 
                                        'messege' => 'Error! your password is incorrect'
                                    ]) ;               
        }
        //display email login error
         else echo json_encode([ 
                                'status' => 0 , 
                                'messege' => 'Error! your email address is incorrect'
                             ]) ;

  }

?>