<?php

function createTable() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        // sql to create table
        $sql = "CREATE TABLE userHSCollection (
        favID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        cardID VARCHAR(255),
        userID INT(6) UNSIGNED,
        FOREIGN KEY (userID) REFERENCES Users(userID)
        )";
        
        if ($conn->query($sql) === TRUE) {
            printConsole("Created Table userHSCollection");
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
        $sql = "DROP TABLE userHSCollection";
        
        if ($conn->query($sql) === TRUE) {
            printConsole("Dropped Table userHSCollection");
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

//resetTable();

checkAccessKey();

?>