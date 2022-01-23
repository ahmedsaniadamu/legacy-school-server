<?php 
    /* // a php that select and all users
 require_once './inc/headers.php' ;
 require_once './inc/databaseConfig.php' ;
 
   
 $_POST = json_decode( file_get_contents('php://input') , true ) ;

 if(isset($_POST['user'])){
      $sql = '' ;
      $response_data = [] ;

      switch($_POST['user']){
           case  'fetch_all_students' :
             $sql = "SELECT * FROM students" ;
            break ;
            case  'fetch_all_teachers' :
             $sql = "SELECT * FROM teachers" ;
            break ;
            case  'fetch_all_fhostel' :
             $sql = "SELECT * FROM female_hostel" ;
            break ;
            case  'fetch_all_mhostel' :
               $sql = "SELECT * FROM male_hostel" ;
              break ;
      }

      $result = mysqli_query($conn,$sql) ;
      while($row = mysqli_fetch_assoc($result)){
           $response_data[] = $row ;
      }
      echo json_encode($response_data) ;
 } */
 require_once './inc/headers.php' ;
 $_POST = json_decode( file_get_contents('php://input') , true ) ;

 if(isset($_POST['user'])) echo 'connected'.$_POST['user'];
 else echo 'pending..' ;

?>