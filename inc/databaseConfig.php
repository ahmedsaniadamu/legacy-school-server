<?php 
   
   $db_setup = [
       'host' => 'localhost',
       'username' => '',
       'password' => '**********' ,
       'db-name' => 'legacy_school'
   ] ;

 //database connection 
$conn = mysqli_connect($db_setup['host'],$db_setup['username'],$db_setup['password'],$db_setup['db-name']);
 if(!$conn) echo 'cannot connect to the database'. mysqli_connect_error() ;

?>