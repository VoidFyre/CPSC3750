<?php

$DB_HOST = 'localhost';
$DB_USER = 'voidfyre_admin';
$DB_PASSWORD = 'V0idFyreVFG';
$DB_NAME = 'voidfyre_p3UserDB';

function printConsole($str) {
    echo "<script>console.log(`$str`);</script>";
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
        $sql = "CREATE TABLE DemoTable (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fName VARCHAR(30) NOT NULL,
        lName VARCHAR(30) NOT NULL,
        email VARCHAR(50)
        )";
        
        if ($conn->query($sql) === TRUE) {
            printConsole("Created Table DemoTable");
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
        $sql = "DROP TABLE DemoTable";
        
        if ($conn->query($sql) === TRUE) {
            printConsole("Dropped Table DemoTable");
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

function insertData($fName, $lName, $email) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "INSERT INTO DemoTable (fName, lName, email)
        VALUES (?, ?, ?)";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("sss", $fName, $lName, $email);
        
        if ($prepStmt->execute() === TRUE) {
            printConsole("Successfully added entry");
        } else {
            printConsole("Error adding entry: " . $prepStmnt->errorInfo());
        }
        
        $conn->close();
    }
}

function getData() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        // sql to get data
        
        $sql = "SELECT fName, lName, email FROM DemoTable ORDER BY lName";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            echo '<table><th>First Name</th><th>Last Name</th><th>Email</th>';
            while($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['fName'] . '</td><td>' . $row['lName'] . '</td><td>' . $row['email'] . '</td></tr>';
            }
            echo '</table>';
        } else {
            echo "<p>0 results</p>";
        }
        
        $conn->close();
    }
}

function searchLast($lName) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "SELECT fName, lName, email FROM DemoTable WHERE lName=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $lName);
        
        $prepStmt->execute();
        
        $result = $prepStmt->get_result();
        
        if ($result->num_rows > 0) {
            // output data of each row
            echo '<table><th>First Name</th><th>Last Name</th><th>Email</th>';
            while($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row['fName'] . '</td><td>' . $row['lName'] . '</td><td>' . $row['email'] . '</td></tr>';
            }
            echo '</table>';
        } else {
            echo "<p>0 results</p>";
        }
        
        $conn->close();
    }
}

//resetTable();

if (isset($_POST['submit'])) {
    if (isset($_POST['fName'])) {
        insertData($_POST['fName'], $_POST['lName'], $_POST['email']);
    } else {
        printConsole("Nothing to insert");
    }
    
}

?>

<html>
    <head>
        <title>
            Create DB
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/script/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport("Create DB");
            </script>
        </header>
        
        <div class="fullnav" id="fullnav">
            <script>
                topbarImport();
            </script>
        </div>
        
        <div class="content">
            <article>
                <h2>Data Form</h2>
                <hr>
                <form id="demoForm" name="demoForm" method="post" action="">
                    <label for="fName">First Name</label><br>
                    <input class="form-input" type="text" name="fName" id="fName" required><br>
                    <label for="lName">Last Name</label><br>
                    <input class="form-input" type="text" name="lName" id="lName" required><br>
                    <label for="email">Email Address</label><br>
                    <input class="form-input" type="email" name="email" id="email" required><br>
                    <button type="submit" id="submit" name="submit">Submit</button><br><br>
                </form>
            </article>
            
            <article>
                <h2>User Data</h2>
                <hr>
                <form id="buttonForm" name="buttonForm" method="post" action="">
                    <button type="submit" id="getData" name="getData">Get Data</button><br><br>
                    <input type="hidden" name="resetForm" id="resetForm" value="false">
                </form>
                <form id="buttonForm2" name="buttonForm2" method="post" action="">
                    <input class="form-input" type="text" name="searchLastInput" id="searchLastInput" required><br>
                    <button type="submit" id="searchLast" name="searchLast">Search By Last Name</button>
                </form>
                    <?php
                        if (isset($_POST['getData'])) {
                            if ($_POST['resetForm'] == "false") {
                                printConsole("Called getData()");
                                getData();
                            } else if ($_POST['resetForm'] == "true") {
                                resetTable();
                            }
                            
                        }
                        
                        if (isset($_POST['searchLast'])) {
                            printConsole("Called searchLast()");
                            searchLast($_POST['searchLastInput']);
                        }
                    ?>
            </article>
        </div>
        
        <footer class="mainfooter" id="footer">
            <script>
                footerImport();
            </script>
        </footer>
    </body>
</html>