<?php
require $_SERVER["DOCUMENT_ROOT"] . "/script/userDB-config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/print-console.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/send-verification-email.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/register-script.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/check-user.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Void Fyre - Register
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
                <h2>Register Account</h2>
                <hr>
                
                <?php if(checkAccessKey()) : ?>
                
                <p>You are already logged in.</p>
                <p>Log out before registering a new account.</p>
                
                <?php else : ?>
                
                <?php if(!empty($errors)) : ?>
                <p class="error-banner"><?php echo implode('</p><p class="error-banner">', $errors) ?></p>
                
                <?php endif; ?>
                
                <form id="register" name="register" method="post" action="">
                    <label for="username">Username</label><br>
                    <input class="form-input" type="text" id="username" name="username" minlength="3" maxlength="30" autocomplete="off" value="<?php echo isset($fields['username']) ? _e($fields['username']) : '' ?>" required><br>
                    
                    <label for="email">Email</label><br>
                    <input class="form-input" type="email" id="email" name="email" autocomplete="email" value="<?php echo isset($fields['email']) ? _e($fields['email']) : '' ?>" required><br>
                    
                    <label for="password">Password</label><br>
                    <input class="form-input" type="password" id="password" name="password" minlength="8" autocomplete="off" required><br>
                    
                    <label for="password2">Confirm Password</label><br>
                    <input class="form-input" type="password" id="password2" name="password2" minlength="8" autocomplete="off" required><br><br>
                    
                    <input type="submit" name="submit" value="Register Account">
                    
                </form>
                
                <span class="center-span"><a class="buttonLink" href="login.php">Have an account already?</a></span>
                
                <?php endif; ?>
                
            </article>
        </div>
        
        <footer id="footer" class="mainfooter">
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