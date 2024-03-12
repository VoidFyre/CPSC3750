<?php
session_start();
?>


<!DOCTYPE html>

<html>
    <head>
        <title>
            Car Display
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/javascript/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport("Car Display");
            </script>
        </header>
        <div class="fullnav" id="fullnav">
            <script>
                topbarImport();
            </script>
        </div>
        
        <div class="content">
            <article>
                <?php
                if (array_key_exists('clearButton', $_POST)) {
                    clear();
                }
                
                function clear() {
                    $cars = [];
                    $_SESSION['cars'] = serialize($cars);
                }
                
                if (isset($_SESSION['cars'])) {
                    echo "<strong><p>Your Cars:</p></strong><ul>";
                    foreach (unserialize($_SESSION['cars']) as $c) {
                        echo "<li><p>".$c."</p></li>";
                    }
                    echo "</ul>";
                }
                
                
                ?>
                
                <form method="post" action="">
                    <input type="submit" name="clearButton" class="button" value="Clear Cars">
                </form>
                
                <ul>
                    <li><a href="carselection.php">Return to car selection page</a></li>
                </ul>
            </article>
        </div>
        
    </body>
</html>