

<?php 
 require_once './inc/headers.php' ;
 require_once './inc/databaseConfig.php' ;
 //check if user email exist.
 $sql = "SELECT token FROM reset_password_token";
 //all database reset password tokens
 $reset_password_tokens = [] ;
 $result = mysqli_query($conn,$sql) ;
 if(mysqli_num_rows($result) > 0) {
      while( $row = mysqli_fetch_assoc($result)){
          $reset_password_tokens[] = $row['token'] ;
      }
       if(in_array('3XcLgq', $reset_password_tokens)) echo 'password updated' ;
 }
?>
