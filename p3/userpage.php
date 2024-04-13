<?php
require $_SERVER["DOCUMENT_ROOT"] . "/script/userDB-config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/logout-script.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/print-console.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/check-user.php";

$subpage = "userHome";

$passChangeSuccess = false;

$errors = array();

function checkEmailVerified() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $email;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "SELECT * FROM Users WHERE email=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $email);
        
        $prepStmt->execute();
        
        $result = $prepStmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['emailVerified'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {

            printConsole("No User Found");
            return false;
        }
        
        $conn->close();
    }
}

function verifyPassword($oldPass) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $errors;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "SELECT * FROM Users WHERE username=?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $_COOKIE['username']);
        
        $prepStmt->execute();
        
        $result = $prepStmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($oldPass, $user['password'])) {
                return true;
            } else {
                $errors[] = "Incorrect Password!";
                return false;
            }
        } else {
            $errors[] = "Incorrect Password!";
            printConsole("No User Found");
            return false;
        }
        
        $conn->close();
    }
}

function changePassword($oldPass, $newPass1, $newPass2) {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $errors;
    
    if ($newPass1 == $newPass2 && $newPass1 == $oldPass) {
        $errors[] = "New Password Cannot be the same as old password!";
        return false;
    }
    
    if (verifyPassword($oldPass) && $newPass1 == $newPass2) {
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
        
        $pass_hash = password_hash($newPass1, PASSWORD_DEFAULT);
    
        // Check connection
        if ($conn->connect_error) {
            printConsole("Connection failed: " . $conn->connect_error);
        } else {
            printConsole("Connection successful");
            $sql = "UPDATE Users SET password = ? WHERE username=?";
        
            $prepStmt = $conn->prepare($sql);
            
            $prepStmt->bind_param("ss", $pass_hash, $_COOKIE['username']);
            
            if ($prepStmt->execute() === TRUE) {
                printConsole("Successfully updated password");
                return true;
            } else {
                printConsole("Error updating password: " . $prepStmnt->errorInfo());
                return false;
            }
            
            $conn->close();
        }
    } else {
        $errors[] = "New passwords do not match!";
        return false;
    }
    
    
}

if ($_GET['subpage']) {
    $subpage = $_GET['subpage'];
}

if (isset($_POST['changePass'])) {
    if (changePassword($_POST['oldPass'], $_POST['newPass1'], $_POST['newPass2'])) {
        $_POST = array();
        $passChangeSuccess = true;
    } else {
        $_POST = array();
    }
    
}

if (isset($_POST['logout'])) {
    logout();
    $_POST = array();
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Void Fyre - User
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/script/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport("User Page");
            </script>
        </header>
        
        <div id="fullnav" class="fullnav">
            <script>
                topbarImport();
            </script>
            
            <nav class="sidebar" id="sidebar">
                <div class="mobileNavBtn" id="mobileNavBtn">&#8801;</div>
                <ul>
                    <h3>Page Navigation</h3>
                    <li class=""><a href="https://voidfyre.space/userpage?subpage=userHome">User Home</a></li>
                    <li class=""><a href="https://voidfyre.space/userpage?subpage=changePassword">Change Password</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="content">
            <article>
                
                <?php if(!checkAccessKey()) : ?>
                <!-- Display if no user is logged in -->
                <h2>No User Logged In</h2>
                <span class="center-span">
                    <a class="buttonLink" href="http://voidfyre.space/login?prevURL=https://voidfyre.space/userpage">Go to Login Page</a>
                </span>
                
                <?php else : ?>
                
                <!-- Display if user is logged in -->
                <?php if($subpage == "userHome") : ?>
                <!-- Display if user is logged in and on user home page -->
                
                <h2><?php echo $_COOKIE['username'] ?></h2>
                <hr>
                <p><b>Email: </b><?php echo $email ?></p>
                <!-- Display if email is not verified -->
                <?php if(!checkEmailVerified()) : ?>
                
                <p class="error-banner">Email has not been verified yet!</p>
                
                <?php endif; ?>
                
                <form id="logoutForm" name="logoutForm" method="post" action="">
                    <input type="submit" name="logout" value="Log Out">
                </form>
                
                <?php endif; ?>
                
                <?php if($subpage == "changePassword") : ?>
                <!-- Display if user is logged in and on password change page -->
                <h2>Change Password</h2>
                <hr>
                
                <?php if(!empty($errors)) : ?>
                <p class="error-banner"><?php echo implode('</p><p class="error-banner">', $errors) ?></p>
                
                <?php elseif($passChangeSuccess) : ?>
                <p class="success-banner">Password Successfully Updated!</p>
                
                <?php endif; ?>
                
                <form id="passChangeForm" name="passChangeForm" method="post" action="">
                    <label for="oldPass">Current Password</label><br>
                    <input class="form-input" type="password" id="oldPass" name="oldPass" required><br>
                    
                    <label for="newPass1">New Password</label><br>
                    <input class="form-input" type="password" id="newPass1" name="newPass1" required><br>
                    
                    <label for="newPass2">Confirm New Password</label><br>
                    <input class="form-input" type="password" id="newPass2" name="newPass2" required><br><br>
                    
                    <input type="submit" name="changePass" value="Update Password">
                </form>
                
                <?php endif; ?>
                
                <?php endif; ?>
            </article>
        </div>
        
        <footer id="footer" class="mainfooter">
            <script>
                footerImport();
            </script>
        </footer>
        <script type="text/javascript" src="/script/mobile-menu-toggle.js"></script>
        <?php
        
        if (checkAccessKey()) {
            echo '<script>document.getElementById("userPageLink").textContent = "' . $_COOKIE['username'] . '\'s Profile";</script>';
        }
        
        ?>
    </body>
</html>