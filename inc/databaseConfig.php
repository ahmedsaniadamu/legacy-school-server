<?php 
   
   $db_setup = [
       'host' => 'sql3.freemysqlhosting.net',
       'username' => 'sql3467355',
       'password' => 'yQxE523HGP',
       'db-name' => 'sql3467355'
   ] ;   
 //database connection 
$conn = mysqli_connect($db_setup['host'],$db_setup['username'],$db_setup['password'],$db_setup['db-name']);
 if(!$conn) echo 'cannot connect to the database'. mysqli_connect_error() ;

?>