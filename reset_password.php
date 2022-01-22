<?php
require_once './inc/headers.php' ;
require_once './inc/databaseConfig.php' ;
   
$_POST = json_decode( file_get_contents('php://input') , true ) ;

if(isset($_POST['user'] , $_POST['password'] , $_POST['email'] , $_POST['token'] )){
      //check if user email exist.
        $sql = "SELECT token FROM reset_password_token";
        //all database reset password tokens
        $reset_password_tokens = [] ;
        $result = mysqli_query($conn,$sql) ;
        if(mysqli_num_rows($result) > 0) {
            while( $row = mysqli_fetch_assoc($result)){
                $reset_password_tokens[] = $row['token'] ;
            }
            // check if user input a correct token
            if(in_array($_POST['token'], $reset_password_tokens)){
                $new_password = password_hash($_POST['password'] ,PASSWORD_DEFAULT ) ;
                //check which user is trying to update password
                switch($_POST['user']){

                    case  'admin' :
                        $sql = " UPDATE admin SET password = '{$new_password}' 
                                WHERE email ='{$_POST['email']}'
                              " ;                         
                      break ;
                   case 'teacher' :
                        $sql = "UPDATE teachers SET password = '{$new_password}'
                                WHERE email = '{$_POST['email']}'
                              " ;                        
                     break ;
                  case 'student' :
                        $sql = "UPDATE students SET password = '{$new_password}'
                                WHERE email = '{$_POST['email']}'
                              " ; 
                     break ;                     
                }
                if(mysqli_query($conn,$sql)) echo 'your password is updated successfully!';
                else echo 'an unknown error occured. try again.';                 
            }
            else echo 'you entered an incorrect token' ;
       }
}
else echo 'an unkown error occured!'
?>