<?php
//a php file for sending email and password token to users that forget their password
require_once './inc/headers.php' ;
require_once './inc/databaseConfig.php' ;
//php mailer config files
require_once('./inc/Exception.php') ;
require_once('./inc/SMTP.php');
require_once('./inc/PHPMailer.php') ;
use PHPMailer\PHPMailer\{ PHPMailer , Exception , SMTP } ;
 
$_POST = json_decode( file_get_contents('php://input') , true ) ;

if(isset($_POST['user'] , $_POST['token'] , $_POST['email'] )){
       //the mailer object.
       $mail = new PHPMailer(true) ;
       //php mailer setup
       $mail->isSMTP() ;
       $mail->Host = 'smtp.gmail.com' ;
       $mail->SMTPAuth = 'true' ;
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS ;
       $mail -> Port = '465' ;
       $mail->Username = 'saniahmed813@gmail.com' ;
       $mail -> Password = 'aluedzdlkkgciwoj' ;
   
       #php mailer body
       $mail->Subject = 'legacy school reset password token.';
       $mail -> setFrom('support.legacyschool@gmail.com') ;
       $mail -> isHTML(true) ;
        #email body
       $mail -> Body = <<<emailbody
                           <h1> 
                              copy this 6 digit code below and use it 
                               as your forgot password token.
                           </h1>
                           <p>
                               your 6 digit code is :  <b> {$_POST['token']} </b>
                           </p>
                           <p> 
                              if your experiencing some problems please contact us
                              we will reply as soon as possible                            
                           </p>
                           <i> legacy school support team. </i>
                    emailbody;
       $mail -> addAddress( $_POST['email']) ;
       if( $mail -> send() ){
            //update token if user already exist.
            $sql = "SELECT * FROM reset_password_token WHERE email='{$_POST['email']}'" ;
            $result = mysqli_query($conn,$sql) ;
            if( mysqli_num_rows($result)) {
                //update token in the database.
                 $sql = "UPDATE reset_password_token SET token='{$_POST['token']}'
                         WHERE email = '{$_POST['email']}'" ;
                if( mysqli_query($conn,$sql) ) echo 1 ;
            }
            #if user does not exist insert a new user.
            else {
                 //add user record to the database
                    $sql = "INSERT INTO `reset_password_token`(`id`,`email`,`token`,`user`) 
                    VALUES(NULL,'{$_POST['email']}','{$_POST['token']}' ,'{$_POST['user']}')
                    " ;
                    if(mysqli_query($conn,$sql)) echo 1 ;   
            }
       }
       $mail -> smtpClose() ;
}

?>