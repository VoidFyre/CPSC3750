<?php
require $_SERVER["DOCUMENT_ROOT"] . "/script/userDB-config.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/print-console.php";
require $_SERVER["DOCUMENT_ROOT"] . "/script/check-user.php";
require $_SERVER["DOCUMENT_ROOT"] . "/cpsc3750/script/hearthstone-favorite.php";
?>

<!DOCTYPE html>

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
                <span class="center-span"><a class="buttonLink" href="collectAppInfo.html">Stats</a></span>
                
                <span class="center-span"><a class="buttonLink" href="collectAppAPIInfo.html">API Info</a></span>
                
                <span class="center-span"><a class="buttonLink" href="collectAppFavorites.php">Go to Favorites</a></span>
                
                <h2>Search</h2>
                <hr>
                
                <?php if(checkAccessKey()) : ?>
                <p>Logged in as: <?php echo $username ?></p>
                
                <?php else : ?>
                <p>No user Logged in</p>
                
                <?php endif; ?>
                
                <input class="form-input" type="text" id="cardName" placeholder="Name"><br><br>
                <button id="nameBtn" onclick="search('name');">Search All or by Name</button><br><br>
                <input class="form-input" type="text" id="cardClass" placeholder="Class"><br><br>
                <div class="hintList" id="classHints">
                    <!-- Hints Display Here -->
                </div>
                <button id="classBtn" onclick="search('class');">Search By Class</button><br><br>
                <input class="form-input" type="text" id="cardRace" placeholder="Race"><br><br>
                <div class="hintList" id="raceHints">
                    <!-- Hints Display Here -->
                </div>
                <button id="raceBtn" onclick="search('race');">Search By Race</button><br><br>
                <input class="form-input" type="text" id="cardQuality" placeholder="Quality"><br><br>
                <div class="hintList" id="qualityHints">
                    <!-- Hints Display Here -->
                </div>
                <button id="qualityBtn" onclick="search('quality');">Search By Quality</button><br><br>
                <input class="form-input" type="text" id="cardFaction" placeholder="Faction"><br><br>
                <div class="hintList" id="factionHints">
                    <!-- Hints Display Here -->
                </div>
                <button id="factionBtn" onclick="search('faction');">Search By Faction</button><br><br>
                <input class="form-input" type="text" id="cardType" placeholder="Type"><br><br>
                <div class="hintList" id="typeHints">
                    <!-- Hints Display Here -->
                </div>
                <button id="typeBtn" onclick="search('type');">Search By Type</button><br>
                
                <label for="imageFilter">Only Cards with Images</label><br>
                <input class="form-input" type="checkbox" id="imageFilter" checked>
                
                <h3>Optional Tags</h3>
                <label for="cost">Cost</label><br>
                <input class="form-input" type="text" id="cost"><br>
                
                <label for="attack">Attack</label><br>
                <input class="form-input" type="text" id="attack"><br>
                
                <label for="health">Health</label><br>
                <input class="form-input" type="text" id="health"><br>
                
                <label for="collectible">Collectible</label><br>
                <input class="form-input" type="checkbox" id="collectible"><br>
                
                <label for="durability">Durability</label><br>
                <input class="form-input" type="text" id="durability"><br>
                
                <input type="hidden" name="userID" id="userID" value="<?php echo $userID ?>">
                
            </article>
            <article>
                <h2 id="resultsH">Search Results</h2>
                <hr>
                <div id="cardDisplay" class="grid">
                    <!-- Cards Print Here -->
                </div>
                
            </article>
        </div>
        
        <footer id="footer" class="mainfooter">
            <script>
                footerImport();
            </script>
        </footer>
        <script type="text/javascript" src="/script/mobile-menu-toggle.js"></script>
        <script type="text/javascript" src="script/hearthstone.js"></script>
    </body>
</html>