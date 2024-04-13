<?php

function logout() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    if(isset($_COOKIE['userAccessToken']) && isset($_COOKIE['username'])) {
        
        setcookie('username', "", time() -3600);
        setcookie('userAccessToken', "", time() -3600);
        
        // Update userLastLogin and userAccessKey
        $sql = "UPDATE Users SET userAccesskey = NULL WHERE username=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $_COOKIE['username']);
        
        if ($prepStmt->execute() === TRUE) {
            printConsole("Successfully updated timestamp");
        } else {
            printConsole("Error updating timestamp: " . $prepStmnt->errorInfo());
        }

        $conn->close();
        
    } else {
        printConsole("Error Logging Out");
    }
}

?>