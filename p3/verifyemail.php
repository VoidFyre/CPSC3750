<?php
require $_SERVER["DOCUMENT_ROOT"] . "/script/userDB-config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/print-console.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/send-verification-email.php";

$verifyCode = $_GET['verifyCode'];
$email = $_GET['email'];
$codeChecked = false;

function checkVerifyCode() {
    global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $verifyCode, $codeChecked;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    printConsole($verifyCode);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "SELECT * FROM Users WHERE verifyCode = ?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $verifyCode);
        
        $prepStmt->execute();
        
        $result = $prepStmt->get_result();
        
        if ($result->num_rows > 0) {
            printConsole("User Found");
            $codeChecked = true;
            return true;
        } else {
            printConsole("No User Found");
            return false;
        }
        
        $conn->close();
    }
}

if ($verifyCode && checkVerifyCode()) {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        printConsole("Connection failed: " . $conn->connect_error);
    } else {
        printConsole("Connection successful");
        $sql = "UPDATE Users SET emailVerified = '1', verifyCode = NULL WHERE verifyCode = ?";
        
        $prepStmt = $conn->prepare($sql);
        
        $prepStmt->bind_param("s", $verifyCode);
        
        if ($prepStmt->execute() === TRUE) {
            printConsole("Successfully updated verification");
        } else {
            printConsole("Error updating verification: " . $prepStmnt->errorInfo());
        }
        
        $conn->close();
    }
}

if (isset($_POST['resend']) && $email) {
    sendVerificationEmail($email);
    $_POST = array();
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Email Verification
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/script/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport();
            </script>
        </header>
        
        <div class="fullnav" id="fullnav">
            <script>
                topbarImport();
            </script>
        </div>
        
        <div class="content">
            <article>
                <?php if($verifyCode) : ?>
                <?php if($codeChecked) : ?>
                <p>Your email address has been verified.</p>
                <p>Thank you!</p>
                <span class="center-span"><a class="buttonLink" href="https://voidfyre.space/login">Go to Login</a></span>
                
                <?php else : ?>
                
                <p>This verification code is no longer active.</p>
                <span class="center-span"><a class="buttonLink" href="https://voidfyre.space">Go to Home</a></span>
                
                <?php endif; ?>
                
                <?php else : ?>
                
                <?php if($email) : ?>
                
                <p>A verification email will be sent to you shortly.</p>
                <p>Please check your junk folder if you do not see it.</p>
                <br>
                <p>If you can't find it, send another verification code.</p>
                <form id="resendForm" name="resendForm" method="post" action="">
                    <input type="submit" name="resend" value="Resend Email">
                </form>
                
                <span class="center-span"><a class="buttonLink" href="https://voidfyre.space">Go to Home</a></span>
                
                <?php else : ?>
                
                <p>There is nothing to see here.</p>
                <span class="center-span"><a class="buttonLink" href="https://voidfyre.space">Go to Home</a></span>
                
                <?php endif; ?>
                <?php endif; ?>
                
            </article>
        </div>
        
        <footer class="mainfooter" id="footer">
            <script>
                footerImport();
            </script>
        </footer>
        <?php
        
        if (checkAccessKey()) {
            echo '<script>document.getElementById("userPageLink").textContent = "' . $_COOKIE['username'] . '\'s Profile";</script>';
        }
        
        ?>
    </body>
</html>