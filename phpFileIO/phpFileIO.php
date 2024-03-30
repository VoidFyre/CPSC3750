<?php
    require 'script/fileIO.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            PHP File I/O
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/script/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport("File I/O");
            </script>
        </header>
        
        <div class="fullnav" id="fullnav">
            <script>
                topbarImport();
            </script>
        </div>
        
        <div class="content">
            <article>
                <form id="numForm" action="" method="post">
                    <label for="numList">Number List</label><br>
                    <textarea class="form-input" id="numList" name="numList"></textarea><br>
                    <input type="submit" value="Submit" name="submit" type="submit"><br><br>
                    <input type="submit" value="Prime" name="primeBtn"><br><br>
                    <input type="submit" value="Fibonacci" name="fibBtn"><br><br>
                    <input type="submit" value="Armstrong" name="armBtn"><br><br>
                    <input type="submit" value="None" name="noneBtn"><br><br>
                    <input type="submit" value="Reset" name="resetBtn">
                </form><br>
                
                <p id="displayArea">Numbers will display here</p>
                
            </article>
        </div>
        
        <footer class="mainfooter" id="footer">
            <script>
                footerImport();
            </script>
        </footer>
    </body>
</html>