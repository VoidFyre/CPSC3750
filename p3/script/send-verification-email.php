<?php

function generateEmailVerifyKey() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 50; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendVerificationEmail($email) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $verifyCode = generateEmailVerifyKey();
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "UPDATE Users SET verifyCode = ? WHERE email = ?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("ss", $verifyCode, $email);
        
        if ($prepStmt->execute() === TRUE) {
            printConsole("Successfully updated verification code");
        } else {
            printConsole("Error updating verification: " . $prepStmnt->errorInfo());
        }
        
        $conn->close();
    }
    
    $subject = "Verify your email address with voidfyre.space";
        
        $message = "<!DOCTYPE html>
        <html>
            <head>
                <title>
                    Registration Email
                </title>
            </head>
            <body>
                <p>Thank you for registering for voidfyre.space!</p>
                <p>Please verify your email address with the following link:</p>
                <br>
                <a href=\"http://voidfyre.space/verifyemail?verifyCode=" . $verifyCode . "\">Verify Your Email</a>
            </body>
        </html>";
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: voidfyre.space <noreply@voidfyre.space>' . "\r\n";
        
        mail($email, $subject, $message, $headers);
}

?>