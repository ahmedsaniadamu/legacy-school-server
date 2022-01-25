<?php 
   
   $db_setup = [
       'host' => '***********',
       'username' => '***********',
       'password' => '******',
       'db-name' => '*******8'
   ] ;   
 //database connection 
$conn = mysqli_connect($db_setup['host'],$db_setup['username'],$db_setup['password'],$db_setup['db-name']);
 if(!$conn) echo 'cannot connect to the database'. mysqli_connect_error() ;

?>
