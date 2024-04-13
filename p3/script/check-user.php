<?php

$username = "";
$email = "";
$userID = 0;

function checkAccessKey() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $username, $email, $userID;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check user cookie
    if(isset($_COOKIE['userAccessToken']) && isset($_COOKIE['username'])) {
        
        // Check connection
        if ($conn->connect_error) {
            printConsole("Connection failed: " . $conn->connect_error);
        } else {
            printConsole("Connection successful");
            $sql = "SELECT * FROM Users WHERE username=? AND userAccessKey=?";
            
            $prepStmt = $conn->prepare($sql);
            
            $prepStmt->bind_param("ss", $_COOKIE['username'], $_COOKIE['userAccessToken']);
            
            $prepStmt->execute();
            
            $result = $prepStmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $username = $user['username'];
                $email = $user['email'];
                $userID = $user['userID'];
                printConsole("User ID: " . $userID);
                printConsole("Already Logged In");
                return true;
            } else {
                printConsole("Account Token Error");
                return false;
            }
            
            $conn->close();
        }
        
    } else {
        printConsole("No User Logged In");
        return false;
    }
}

?>