<?php
header("Content-type: text/xml");
$DB_HOST = 'localhost';
$DB_USER = 'voidfyre_admin';
$DB_PASSWORD = 'V0idFyreVFG';
$DB_NAME = 'voidfyre_p3UserDB';

function addFavorite($cardID, $userID) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    // Check connection
    if (!$conn->connect_error) {
        $sql = "INSERT INTO userHSCollection (cardID, userID)
        VALUES (?, ?)";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("si", $cardID, $userID);

        if ($prepStmt->execute() == TRUE) {
            echo "Added card with ID: " + $cardID + " to favorites.";
        } else {
            echo "Could not add to favorites";
        }
        
        $conn->close();
    }
}

function removeFavorite($cardID, $userID) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    // Check connection
    if (!$conn->connect_error) {
        $sql = "DELETE FROM userHSCollection WHERE cardID=? AND userID=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("si", $cardID, $userID);

        if ($prepStmt->execute() == TRUE) {
            echo "Removed card with ID: " + $cardID + " from favorites.";
        } else {
            echo "Could not remove from favorites";
        }
        
        $conn->close();
    }
}

function checkFavorite($cardID, $userID) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    // Check connection
    if (!$conn->connect_error) {
        $sql = "SELECT * FROM userHSCollection WHERE cardID=? AND userID=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("si", $cardID, $userID);

        $prepStmt->execute();

        $result = $prepStmt->get_result();
    
        if ($result->num_rows > 0) {
            echo "true";
        } else {
            echo "false";
        }
        
        $conn->close();
    }
}

function getFavorites($userID) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    // Check connection
    if (!$conn->connect_error) {
        $sql = "SELECT * FROM userHSCollection WHERE userID=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("i", $userID);

        $prepStmt->execute();

        $result = $prepStmt->get_result();
    
        if ($result->num_rows > 0) {
            echo "<?xml version=\"1.0\" ?>\n";
            echo "<favorites>\n";
            while ($fav = $result->fetch_assoc()) {
                echo "<fav>" . $fav['cardID'] . "</fav>\n";
            }
            echo "</favorites>\n";
        } else {
            echo "false";
        }
        
        $conn->close();
    }
}

$cardID = $_GET['cardID'];
$userID = $_GET['userID'];
$func = $_GET['func'];

switch ($func) {
    case "add":
        addFavorite($cardID, $userID);
        break;
    case "remove":
        removeFavorite($cardID, $userID);
        break;
    case "check":
        checkFavorite($cardID, $userID);
        break;
    case "get":
        getFavorites($userID);
        break;
}

?>