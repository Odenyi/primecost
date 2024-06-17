<?php

require 'vendor/autoload.php'; // Include PHPMailer library
require 'utils/utils.php';
// require 'dbconnect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require $rdir.'/PHPMailer/src/Exception.php';
//require $rdir.'/PHPMailer/src/PHPMailer.php';
//require $rdir.'/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
   
    if ($name == "" || $email ==""  || $message == ""){
        echo "Please fill in all the requirements ";
       
    }
    else{
        //    try{ // Use a prepared statement to insert data
        //     $stmt = $pdo->prepare("INSERT INTO contact (name, email, phone_number, message) VALUES (:name, :email, :phone, :message)");
            
        //     // Bind the parameters to the prepared statement
        //     $stmt->bindParam(':name', $name);
        //     $stmt->bindParam(':email', $email);
        //     $stmt->bindParam(':phone', $phone);
        //     $stmt->bindParam(':message', $message);

        //     // Execute the prepared statement
        //     $stmt->execute();
                
        //     } catch (Exception $e) {
        //         echo 2;
        //         exit;
        //     }
        //     $pdo = null;
        $messagetosend = "Greetings,<br>You have received a message from prime-costqs.com Contact Form. Here is some information about the client:<br>"
        . "name: {$name},<br>"
        . "email: {$email}<br>"
        . "and the message is:<br>'{$message}'<br><br>Regards,<br>Prime Cost QS";

        $client_message = "Dear {$name},<br><br>Thank you for contacting Prime Cost Limited. Your request has been received and you be contacted soon should you have any question or clarification do not hesitate to contact {$recipients[0]['email']} or {$recipients[0]['phone']}. <br><br>Regards,<br>Primecost Limited.";

        //$sendsms = "You have a new message from prime-costqs.com Contact Form.name: {$name},phone: {$phone}";
        
        $client_email = trim($email);
       
        
        

        

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = $HOST;
            $mail->SMTPAuth = true;
            $mail->Username = $emailfrom;
            $mail->Password = $pass;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            
            //Recipients
            $mail->setFrom($emailfrom, $emailfrom_uname);
            foreach ($recipients as $recipient) {
                // send to mail
                $mail->addAddress($recipient['email'], $recipient['name']);
                //sendsms
                // sendSMS($recipient['phone'],$sendsms);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $messagetosend;

            $mail->send();

            $mail->clearAddresses();  // clear so not to send duplicate email
            $mail->addAddress($client_email, $name);
            $mail->Body = $client_message;
            $mail->send();



            echo 1;
            
            
            
        } catch (Exception $e) {
            echo "" ;
            
        }

       
    }

    
}
else{
    echo "method not allowed";
}
              
function sendSMS($recipient,$text){
    global $API_KEY;
    global $SHORTCODE;

   
    

	$mobile = $recipient; // recipient
	$message = $text; //message to besent

    $finalURL = "https://dev.meppcommunications.com/sms/sendsms";
     
 $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $finalURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 15,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode([
    "mobile"=>$mobile,
    "response_type"=>"json",
    "sender_name"=>$SHORTCODE,
    "service_id"=>0,
    "message"=>$message]
),
  CURLOPT_HTTPHEADER => array(
    "h_api_key:{$API_KEY}",
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
}
?>
