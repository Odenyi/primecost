<?php
require '../utils/utils.php';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["cookie"])) {

    $cookie_value = $_GET["cookie"];

    // Connect to MySQL
    $mysqli = new mysqli($mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase);

    // Check connection
    if ($mysqli->connect_error) {
        echo json_encode(["error" => $mysqli->connect_error]);
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Select data from MySQL based on the cookie value
    $sql = "SELECT * FROM chat WHERE cookie = '$cookie_value' ORDER BY date_send ASC";

    $result = $mysqli->query($sql);
   

    if ($result) {
        // Fetch and store the data in an array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "message" => $row['message'],
                "date_send" => $row['date_send'],
                "status" => $row['status']
                // Add more fields as needed
            ];
        }
        $result->free();

        // Echo the data as JSON
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $mysqli->error]);
    }

    // Close MySQL connection
    $mysqli->close();
} 
else {
    echo json_encode(["error" => "Cookie 'my_chat' not set."]);
}