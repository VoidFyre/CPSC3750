<?php
require $_SERVER["DOCUMENT_ROOT"] . "/script/userDB-config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/print-console.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/check-user.php";
require $_SERVER["DOCUMENT_ROOT"] . "/cpsc3750/script/hearthstone-favorite.php";
?>

<html>
    <head>
        <title>
            Hearthstone Cards
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/script/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport("Hearthstone Cards");
            </script>
        </header>
        
        <div class="fullnav" id="fullnav">
            <script>
                topbarImport();
            </script>
            
            <aside id="info" class="">
                <div class="mobileInfoBtn" id="mobileInfoBtn">&#9432;</div>
                <h3>Card Information</h3>
                <div id="singleCardData">
                    <p>Select a Card to Display</p>
                    <!-- Card Displays Here -->
                </div>
            </aside>
        </div>
        
        <div class="content">
            <article>
                <?php if(checkAccessKey()) : ?>
                
                <h2><?php echo $username ?>'s Favorites</h2>
                
                <button id="reload" onclick="updateFavorites();">Reload</button>
                <span class="center-span"><a class="buttonLink" href="collectApp.php">Back to Search</a></span>
                <input type="hidden" name="userID" id="userID" value="<?php echo $userID ?>">
                <hr>
                <div id="cardDisplay" class="grid">
                    <!-- Cards Print Here -->
                </div>
                
                <?php else : ?>
                <h2>No User</h2>
                <p>Login to see your favorites!</p>
                <span class="center-span"><a class="buttonLink" href="http://voidfyre.space/login?prevURL=https://voidfyre.space/cpsc3750/collectAppFavorites">Log In</a></span>
                
                <?php endif; ?>
            </article>
        </div>
        
        <footer id="footer" class="mainfooter">
            <script>
                footerImport();
            </script>
        </footer>
        <script type="text/javascript" src="/script/mobile-menu-toggle.js"></script>
        <?php if(checkAccessKey()) : ?>
        
        <script type="text/javascript" src="script/hearthstone-favorites.js"></script>
        
        <?php endif; ?>
    </body>
</html>