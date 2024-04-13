var favorites = Array();

function addFavorite(cardId) {
    userId = document.getElementById("userID").value;
    
    url = "https://voidfyre.space/cpsc3750/hearthstone-manage-favorites.php?cardID=" + cardId + "&userID=" + userId + "&func=add";
    
    const xhr = new XMLHttpRequest();
    
    xhr.open('GET', url, false);
    xhr.send();
    
    if (xhr.readyState == XMLHttpRequest.DONE) {
        if (xhr.status == 200) {
            console.log(xhr.responseText);
        }
    }
    
    findSingleCard(cardId);
}

function removeFavorite(cardId) {
    userId = document.getElementById("userID").value;
    
    
    url = "https://voidfyre.space/cpsc3750/hearthstone-manage-favorites.php?cardID=" + cardId + "&userID=" + userId + "&func=remove";
    
    const xhr = new XMLHttpRequest();

    xhr.open('GET', url, false);
    xhr.send();
    
    if (xhr.readyState == XMLHttpRequest.DONE) {
        if (xhr.status == 200) {
            console.log(xhr.responseText);
        }
    }
    
    findSingleCard(cardId);
}

function checkFavorite(cardId) {
    userId = document.getElementById("userID").value;
    
    
    url = "https://voidfyre.space/cpsc3750/hearthstone-manage-favorites.php?cardID=" + cardId + "&userID=" + userId + "&func=check";
    
    const xhr = new XMLHttpRequest();
    
    xhr.open('GET', url, false);
    xhr.send();
    if (xhr.responseText == "true") {
        return true;
    } else {
        return false;
    }
}

function getFavorites() {
    favorites = Array();
    userId = document.getElementById("userID").value;
    
    url = "https://voidfyre.space/cpsc3750/hearthstone-manage-favorites.php?cardID=none&userID=" + userId + "&func=get";
    
    const xhr = new XMLHttpRequest();
    
    xhr.open('GET', url, false);
    xhr.send();
    favs = xhr.responseXML.getElementsByTagName("fav");
    for (i = 0; i < favs.length; i++) {
        fav = favs[i].firstChild.nodeValue;
        favorites.push(fav);
    }
}

// Find and display a single card
// Arguments: 
// cardId: id of card to find
function findSingleCard(cardId) {
    // Toggles info panel open(mobile only)
    toggleInfo(false);
    
    singleCardData = document.getElementById("singleCardData");
    
    singleCardData.innerHTML = "<p>Finding Card...</p>";
    
    url = "https://omgvamp-hearthstone-v1.p.rapidapi.com/cards/" + cardId + "?locale=enUS";
    
    const data = null;
    
    // Sending request to API server
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    // Adding information of card to aside panel
    xhr.addEventListener('readystatechange', function () {
    	if (this.readyState === this.DONE) {
            card = JSON.parse(this.responseText);
            
            str = "<p><b>Card Id:</b> " + card[0].cardId + "</p>";
            str += "<p><b>dbfId:</b> " + card[0].dbfId + "</p>";
            str += "<p><b>Name:</b> " + card[0].name + "</p>";
            
            if (card[0].img) str += "<h2>Images:</h2><br><img class=\"full\" src=\"" + card[0].img + "\" alt=\"Image File Invalid\">";
            if (card[0].imgGold) str += "<img class=\"full\" src=\"" + card[0].imgGold + "\" alt=\"Image File Invalid\">";
            
            if (card[0].cardSet) str += "<p><b>Card Set:</b> " + card[0].cardSet + "</p>";
            if (card[0].type) str += "<p><b>Type:</b> " + card[0].type + "</p>";
            if (card[0].rarity) str += "<p><b>Rarity:</b> " + card[0].rarity + "</p>";
            if (card[0].cost) str += "<p><b>Cost:</b> " + card[0].cost + "</p>";
            if (card[0].attack) str += "<p><b>Attack:</b> " + card[0].attack + "</p>";
            if (card[0].health) str += "<p><b>Health:</b> " + card[0].health + "</p>";
            if (card[0].elite) str += "<p><b>Elite:</b> " + card[0].elite + "</p>";
            if (card[0].race) str += "<p><b>Race:</b> " + card[0].race + "</p>";
            if (card[0].playerClass) str += "<p><b>Player Class:</b> " + card[0].playerClass + "</p>";
            if (card[0].text) str += "<p><b>Text:</b> " + card[0].text + "</p>";
            if (card[0].flavor) str += "<p><b>Flavor:</b> " + card[0].flavor + "</p>";
            
            if (checkFavorite(card[0].cardId)) {
                str += "<span class=\"center-span\"><button style=\"width: 100%;\" id=\"unfavorite\" onclick=\"removeFavorite('" + card[0].cardId + "');\">Unfavorite</button></span>";
            } else {
                str += "<span class=\"center-span\"><button style=\"width: 100%;\" id=\"favorite\" onclick=\"addFavorite('" + card[0].cardId + "');\">Favorite</button></span>";
            }
            
            
            
            singleCardData.innerHTML = str;
            
    	}
    });
    
    
    
    xhr.open('GET', url);
    xhr.setRequestHeader('X-RapidAPI-Key', '249064afcfmshdf0ac49a7d7063fp185ecbjsn3a1c4e63f744');
    xhr.setRequestHeader('X-RapidAPI-Host', 'omgvamp-hearthstone-v1.p.rapidapi.com');
    
    xhr.send(data);
}

function displayFavorites() {
    disp = document.getElementById("cardDisplay");
    disp.innerHTML = "";
    favorites.forEach(function(fav) {
        
        url = "https://omgvamp-hearthstone-v1.p.rapidapi.com/cards/" + fav + "?locale=enUS";
        
        const data = null;
    
        // Sending request to API server
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        
        // Adding information of card to aside panel
        xhr.addEventListener('readystatechange', function () {
        	if (this.readyState === this.DONE) {
                card = JSON.parse(this.responseText);
                card = card[0];
                
                // Generating HTML for card
                str = '<div class="gallery">';
                
                str += '<button onclick="findSingleCard(\'' + card.cardId + '\');">';
                
                if ('imgGold' in card) {
                    str += '<img src="' + card.imgGold + '" alt="Image File Invalid">';
                }
                else if ('img' in card) {
                    str += '<img src="' + card.img + '" alt="Image File Invalid">';
                } else str += '<img src="">';
                
                str += "</button>";
                
                str += '<div class="desc">';
                
                str += 'Name: ' + card.name + '<br>';
                str += 'Set: ' + card.cardSet + '<br>';
                str += 'Type: ' + card.type;
                
                str += '</div></div>';
                
                disp.innerHTML += str;
                
        	}
        });
        
        
        
        xhr.open('GET', url);
        xhr.setRequestHeader('X-RapidAPI-Key', '249064afcfmshdf0ac49a7d7063fp185ecbjsn3a1c4e63f744');
        xhr.setRequestHeader('X-RapidAPI-Host', 'omgvamp-hearthstone-v1.p.rapidapi.com');
        
        xhr.send(data);
    });
}

function updateFavorites() {
    getFavorites();
    displayFavorites();
}

updateFavorites();