<?php
session_start();
?>


<!DOCTYPE html>

<html>
    <head>
        <title>
            Car Selection
        </title>
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="/javascript/topbar-import.js"></script>
    </head>
    
    <body>
        <header id="header">
            <script>
                headerImport("Car Selection");
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
                if (isset($_POST['form_cars'])) {
                    if (!empty($_SESSION['cars'])) {
                        $cars = array_unique(
                            array_merge(unserialize($_SESSION['cars']),
                            $_POST['form_cars']));
                            $_SESSION['cars'] = serialize($cars);
                    } else {
                        $_SESSION['cars'] = serialize($_POST['form_cars']);
                    }
                    
                    echo "<p>Your Products have been registered!</p>";
                }
                ?>
                
                <form method="post" action="">
                    <label for="form_cars"><p>Choose Cars:</p></label><br>
                    <select id="form_cars" name="form_cars[]" multiple="multiple" size="8">
                        <option value="porche">Porsche 911 Turbo</option>
                        <option value="nissan">Nissan GTR Nismo</option>
                        <option value="audi">Audi R8</option>
                        <option value="toyota">Toyota Supra</option>
                        <option value="chevrolet">Chevrolet Corvette ZR1</option>
                        <option value="subaru">Subaru WRX STI</option>
                        <option value="ford">Ford Mustang GT500</option>
                        <option value="honda">Honda Civic Type R</option>
                    </select>
                    <br><br>
                    <button type="submit" name="submit" value="choose">Submit Form</button>
                </form>
                <ul>
                    <li><a href="cardisplay.php">Go to display page</a></li>
                </ul>
                
                
            </article>
        </div>
        
    </body>
</html>