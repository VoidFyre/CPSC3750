<?php

$DB_HOST = 'localhost';
$DB_USER = 'voidfyre_admin';
$DB_PASSWORD = 'V0idFyreVFG';
$DB_NAME = 'voidfyre_p3UserDB';

$emailAddr = "";

$whitelist = array('username', 'email');
$errors = array();
$fields = array();

function _e($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
}

function createTable() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        // sql to create table
        $sql = "CREATE TABLE Users (
        userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(50) NOT NULL,
        emailVerified INT(1) NOT NULL,
        verifyCode VARCHAR(60),
        userCreated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        userLastLogin TIMESTAMP,
        userAccessKey VARCHAR(255)
        )";
        
        if ($conn->query($sql) === TRUE) {
            printConsole("Created Table Users");
        } else {
            printConsole("Error creating table: " . $conn->error);
        }
        
        $conn->close();
    }
}

function dropTable() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        // sql to drop table
        $sql = "DROP TABLE Users";
        
        if ($conn->query($sql) === TRUE) {
            printConsole("Dropped Table Users");
        } else {
            printConsole("Error dropping table: " . $conn->error);
        }
        
        $conn->close();
    }
}

function resetTable() {
    dropTable();
    createTable();
}

function register($username, $email, $password) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $emailAddr;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $emailAddr = $email;

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "INSERT INTO Users (username, email, password, emailVerified, verifyCode)
        VALUES (?, ?, ?, 0, NULL)";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("sss", $username, $email, $pass_hash);
        
        if ($prepStmt->execute() === TRUE) {
            printConsole("Successfully added entry");
        } else {
            printConsole("Error adding entry: " . $prepStmnt->errorInfo());
        }
        
        sendVerificationEmail($email);
        
        $conn->close();
    }
}

function validateNewUser($username, $email) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "SELECT userID FROM Users WHERE username=? OR email=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("ss", $username, $email);
        
        $prepStmt->execute();
        
        $result = $prepStmt->get_result();
        
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
        
        $conn->close();
    }
}

//resetTable();

if (isset($_POST['submit'])) {
    // Perform Field Whitelisting
    foreach($whitelist as $key) {
        $fields[$key] = $_POST[$key];
    }
    if (!validateNewUser($_POST['username'], $_POST['password'])) {
        printConsole("Username or Email already in use!");
        $errors[] = "Username or Email already in use!";
    } else if ($_POST['password'] != $_POST['password2']) {
        $errors[] = "Passwords Do Not Match!";
    } else {
        register($_POST['username'], $_POST['email'], $_POST['password']);
        header('Location: http://voidfyre.space/verifyemail?email=' . $emailAddr);
    }
    
}

?>