<?php
// this file is for handling contact page which is responsible for sending mail and return a status
 require_once './inc/headers.php';
 require_once './inc/databaseConfig.php';
 //php mailer config files
 require_once('./inc/Exception.php') ;
 require_once('./inc/SMTP.php');
 require_once('./inc/PHPMailer.php') ;
 use PHPMailer\PHPMailer\{ PHPMailer , Exception , SMTP } ;

 //function to prevent xss attact
 $secure_input = fn($input) => htmlspecialchars($input) ;

//check if entered value is not empty
 if( isset( $_POST['email'] , $_POST['subject'] , $_POST['messege']) ){
     
     $email = $secure_input($_POST['email']) ;
     $subject = $secure_input($_POST['subject']) ;
     $messege =  $secure_input($_POST['messege']) ;
     
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
    $mail->Subject = $subject;
    $mail -> setFrom($email) ;
    $mail -> isHTML(true) ;
     #email body
    $mail -> Body = <<<emailbody
                        <h1> $messege  </h1>
                 emailbody;
    $mail -> addAddress('saniahmed813@gmail.com') ;
    
    if( $mail -> send() ){
        //insert the record into the database
        $sql =   <<<query
                      INSERT INTO `contact_us` (`id`, `email`, `subject`, `messege`, `date`)
                      VALUES (
                                NULL,
                                '{$email}', 
                                '{$subject}', 
                                '{$messege}',
                                current_timestamp()
                            )
                 query;
       if( mysqli_query($conn,$sql) ) {
           //send a response code to the client if the mail is sent successfully
           echo '1' ;
       }
    }
    $mail -> smtpClose() ;
 }

?>