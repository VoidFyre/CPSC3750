<?php
require $_SERVER["DOCUMENT_ROOT"] . "/script/userDB-config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/print-console.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/logout-script.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/check-user.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/login-script.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Void Fyre - Log In
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/script/topbar-import.js"></script>
        
        <script type="text/javascript" src="/script/recaptcha-verify.js"></script>
        <?php if(!checkAccessKey()) : ?>
        <script src="https://www.google.com/recaptcha/api.js?onload=onLoadCallback&render=explicit" async defer></script>
        <?php endif; ?>
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
                
                <?php if(checkAccessKey()) : ?>
                <p>Already Logged in as: <?php echo $_COOKIE['username']; ?></p>
                
                <form id="logoutform" name="logoutform" method="post" action="">
                    <input type="submit" name="logout" value="Log Out">
                </form>
                
                <?php else : ?>
                
                <h2>Log In</h2>
                <hr>
                
                <?php if(!empty($errors)) : ?>
                <p class="error-banner"><?php echo implode('</p><p class="error-banner">', $errors) ?></p>
                
                <?php endif; ?>
                
                
                <form id="loginform" name="loginform" method="post" action="">
                    <label for="username">Username</label><br>
                    <input class="form-input" type="text" id="username" name="username" autocomplete="username" required><br>
                    
                    <label for="password">Password</label><br>
                    <input class="form-input" type="password" id="password" name="password" autocomplete="current-password" required><br><br>
                    
                    <span class="center-span"><div id="divRecaptcha" class="g-recaptcha"></div></span>
                    <input type="hidden" id="recaptcha-token" name="recaptcha-token">
                    <label for="stayLoggedIn">Stay Logged In</label><br>
                    <input class="form-input" type="checkbox" id="stayLoggedIn" name="stayLoggedIn"><br>
                    
                    <input type="submit" name="login" value="Log In">
                </form>
                
                <span class="center-span"><a class="buttonLink" href="register.php">Don't have an account?</a></span>
                
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