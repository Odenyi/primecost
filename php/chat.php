<?php
require '/var/www/html/mywebsite/php/utils/utils.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST["text"];
    if(!$text){
        echo "Message is blank";
        exit;
    }
    // Check if the cookie is already set
    if (!isset($_COOKIE["my_chat"])) {
        // Set the cookie with a one-month expiration
        $cookie_value = uniqid(); // You can use any unique identifier as the cookie value
        $cookie_expiration = time() + 7 * 24 * 60 * 60; // One month from now
        setcookie("my_chat", $cookie_value, $cookie_expiration, "/");
        
        }
    
        // Cookie is already set, retrieve its value
        $cookie_value = $_COOKIE["my_chat"];
        $status = "2";
        $now = new DateTime("now",new DateTimeZone('Africa/Nairobi'));
        $date_send = $now->format('Y-m-d H:i:s');
        
       
    // Connect to MySQL
        $mysqli = new mysqli($mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase);

        // Check connection
        if ($mysqli->connect_error) {
            echo $mysqli->connect_error;
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Insert data into MySQL
        $sql = "INSERT INTO chat (message, date_send, cookie, status) VALUES ('$text', '$date_send', '$cookie_value', '$status')";

        if ($mysqli->query($sql) === TRUE) {
            echo 1;
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

        // Close MySQL connection
        $mysqli->close();

            
                
        }

else{
    echo "Request not allowed";
}