// Global variables for hints
var classes = Array();
var races = Array();
var types = Array();
var qualities = Array();
var factions = Array();

// Getting hint divs
classHints = document.getElementById("classHints");
raceHints = document.getElementById("raceHints");
typeHints = document.getElementById("typeHints");
factionHints = document.getElementById("factionHints");
qualityHints = document.getElementById("qualityHints");

// Getting inputs
classInput = document.getElementById("cardClass");
raceInput = document.getElementById("cardRace");
typeInput = document.getElementById("cardType");
factionInput = document.getElementById("cardFaction");
qualityInput = document.getElementById("cardQuality");


// Adding listeners to inputs
classInput.addEventListener("keyup", function() {
    suggest("class", classInput.value);
});
classInput.addEventListener("focusout", function() {
    closeSuggest();
});

raceInput.addEventListener("keyup", function() {
    suggest("race", raceInput.value);
});
raceInput.addEventListener("focusout", function() {
    closeSuggest();
});

typeInput.addEventListener("keyup", function() {
    suggest("type", typeInput.value);
});
typeInput.addEventListener("focusout", function() {
    closeSuggest();
});

factionInput.addEventListener("keyup", function() {
    suggest("faction", factionInput.value);
});
factionInput.addEventListener("focusout", function() {
    closeSuggest();
});

qualityInput.addEventListener("keyup", function() {
    suggest("quality", qualityInput.value);
});
qualityInput.addEventListener("focusout", function() {
    closeSuggest();
});

// Apply suggestion to input
function inputSuggestion(suggestion, input) {
    switch (input) {
        case "class":
            classInput.value = suggestion;
            break;
        case "race":
            raceInput.value = suggestion;
            break;
        case "type":
            typeInput.value = suggestion;
            break;
        case "faction":
            factionInput.value = suggestion;
            break;
        case "quality":
            qualityInput.value = suggestion;
            break;
    }
}

// Close all suggestion divs
function closeSuggest() {
    classHints.classList.remove("open");
    raceHints.classList.remove("open");
    typeHints.classList.remove("open");
    factionHints.classList.remove("open");
    qualityHints.classList.remove("open");
}

// Suggest value to user
// Arguments:
// currentSearch: input user is typing in
// searchStr: string input by user
function suggest(currentSearch, searchStr) {
    
    // Get current input user is typing in
    switch (currentSearch) {
        case "class":
            if (classInput.value !=="") classHints.classList.add("open");
            if (classInput.value === "") classHints.classList.remove("open");
            
            classes.forEach(function(cClass) {
                
                if (cClass.toLowerCase().includes(searchStr.toLowerCase())){
                    btn = document.createElement("button");
                    btn.innerText = cClass;
                    btn.onmousedown = function() {inputSuggestion(cClass, "class")};
                    classHints.appendChild(btn);
                }
            });
            
            break;
        case "race":
            console.log("Test");
            if (raceInput.value !=="") raceHints.classList.add("open");
            if (raceInput.value === "") raceHints.classList.remove("open");
            
            races.forEach(function(cRace) {
                
                if (cRace.toLowerCase().includes(searchStr.toLowerCase())){
                    btn = document.createElement("button");
                    btn.innerText = cRace;
                    btn.onmousedown = function() {inputSuggestion(cRace, "race")};
                    raceHints.appendChild(btn);
                }
            });
            break;
        case "type":
            if (typeInput.value !=="") typeHints.classList.add("open");
            if (typeInput.value === "") typeHints.classList.remove("open");
            
            types.forEach(function(cType) {
                
                if (cType.toLowerCase().includes(searchStr.toLowerCase())){
                    btn = document.createElement("button");
                    btn.innerText = cType;
                    btn.onmousedown = function() {inputSuggestion(cType, "type")};
                    typeHints.appendChild(btn);
                }
            });
            break;
        case "faction":
            if (factionInput.value !=="") factionHints.classList.add("open");
            if (factionInput.value === "") factionHints.classList.remove("open");
            
            factions.forEach(function(cFaction) {
                
                if (cFaction.toLowerCase().includes(searchStr.toLowerCase())){
                    btn = document.createElement("button");
                    btn.innerText = cFaction;
                    btn.onmousedown = function() {inputSuggestion(cFaction, "faction")};
                    factionHints.appendChild(btn);
                }
            });
            break;
        case "quality":
            if (qualityInput.value !=="") qualityHints.classList.add("open");
            if (qualityInput.value === "") qualityHints.classList.remove("open");
            
            qualities.forEach(function(cQual) {
                
                if (cQual.toLowerCase().includes(searchStr.toLowerCase())){
                    btn = document.createElement("button");
                    btn.innerText = cQual;
                    btn.onmousedown = function() {inputSuggestion(cQual, "quality")};
                    qualityHints.appendChild(btn);
                }
            });
            break;
    }
}

// Get suggestion data
function getSuggestionData() {
    const data = null;

    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    // Send suggestion data to global variables
    xhr.addEventListener('readystatechange', function () {
    	if (this.readyState === this.DONE) {
    		apiInfo = JSON.parse(this.responseText);
    		
    		apiInfo.classes.forEach(function(cClass) {
    		    classes.push(cClass);
    		});
            
            apiInfo.races.forEach(function(cRace) {
                races.push(cRace);
            });
    		apiInfo.types.forEach(function(cType) {
    		    types.push(cType);
    		});
    		apiInfo.qualities.forEach(function(cQual) {
    		    qualities.push(cQual);
    		});
    		apiInfo.factions.forEach(function(cFact) {
    		    factions.push(cFact);
    		});
    	}
    });
    
    xhr.open('GET', 'https://omgvamp-hearthstone-v1.p.rapidapi.com/info');
    xhr.setRequestHeader('X-RapidAPI-Key', '249064afcfmshdf0ac49a7d7063fp185ecbjsn3a1c4e63f744');
    xhr.setRequestHeader('X-RapidAPI-Host', 'omgvamp-hearthstone-v1.p.rapidapi.com');
    
    xhr.send(data);
    
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
            
            
            singleCardData.innerHTML = str;
    	}
    });
    
    
    
    xhr.open('GET', url);
    xhr.setRequestHeader('X-RapidAPI-Key', '249064afcfmshdf0ac49a7d7063fp185ecbjsn3a1c4e63f744');
    xhr.setRequestHeader('X-RapidAPI-Host', 'omgvamp-hearthstone-v1.p.rapidapi.com');
    
    xhr.send(data);
}



// Search for cards
// Arguments: 
//   type: Type of search to perform
// Types = "all", "class", "race", "quality", "faction", "type"
function search(type) {
    cardName = document.getElementById("cardName").value;
    
    if(cardName === "" && type == "name") {
        type = "all";
    }
    
    enableButtons();
    
    // Changing results header to "Searching..."
    resultsH = document.getElementById("resultsH");
    resultsH.textContent = "Searching...";
    
    // Clearing any previous search results
    clearResults();
    
    imgFilter = document.getElementById("imageFilter").checked;
    
    url = "https://omgvamp-hearthstone-v1.p.rapidapi.com/cards";
    
    // Setting URL based on search type
    switch(type) {
        case "all":
            url += "?";
            break;
        case "name":
            url += "/" + cardName + "?";
            break;
        case "class":
            cardClass = document.getElementById("cardClass").value;
            if (cardClass === "") {
                alert("Enter a Class!");
                return;
            }
            url += "/classes/" + cardClass + "?";
            break;
        case "race":
            cardRace = document.getElementById("cardRace").value;
            if (cardRace === "") {
                alert("Enter a Race!");
                return;
            }
            url += "/races/" + cardRace + "?";
            break;
        case "quality":
            cardQuality = document.getElementById("cardQuality").value;
            if (cardQuality === "") {
                alert("Enter a Quality!");
                return;
            }
            url += "/qualities/" + cardQuality + "?";
            break;
        case "faction":
            cardFaction = document.getElementById("cardFaction").value;
            if (cardFaction === "") {
                alert("Enter a Faction!");
                return;
            }
            url += "/factions/" + cardFaction + "?";
            break;
        case "type":
            cardType = document.getElementById("cardType").value;
            if (cardType === "") {
                alert("Enter a Type!");
                return;
            }
            url += "/types/" + cardType + "?";
            break;
    }
    
    // Getting optional tags
    // Name search only supports collectible optional tag
    if (type == "name") {
        cost = "";
        attack = "";
        health = "";
        durability = "";
    } else {
        cost = document.getElementById("cost").value;
        attack = document.getElementById("attack").value;
        health = document.getElementById("health").value;
        durability = document.getElementById("durability").value;
    }
    
    collectible = document.getElementById("collectible").checked;
    
    if (type == "all" && (!cost && !attack && !health && !collectible && !durability)) {
        alert("Page Will run out of memory if searching for all with no optional parameters. This API does not have the ability to only return a certain number of entries.");
        return;
    }
    
    // Adding any optional tags to the URL query
    var query = "";
    if (cost !== "") {
        query += "cost=" + cost;
    }
    
    if (attack !== "") {
        if (!query.endsWith('?')) query += "&";
        query += "attack=" + attack;
    }
    
    if (health !== "") {
        if (!query.endsWith('?')) query += "&";
        query += "health=" + health;
    }
    
    if (collectible) {
        if (!query.endsWith('?')) query += "&";
        query += "collectible=1";
    }
    
    if (durability !== "") {
        if (!query.endsWith('?')) query += "&";
        query += "durability=" + durability;
    }
    
    if (!query.endsWith('?')) query += "&";
    query += "locale=enUS";
    
    url += query;
    
    const data = null;
    
    // Sending request to API server
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    xhr.addEventListener('readystatechange', function () {
    	if (this.readyState === this.DONE) {
    		if (type == "all") {
    		    if (imgFilter) {
    		        printResults(this.responseText, true, true);
    		    } else printResults(this.responseText, true);
    		} else {
    		    if (imgFilter) {
    		        printResults(this.responseText, false, true);
    		    } else printResults(this.responseText);
    		}
    	}
    });
    
    console.log("Sending request to:\n" + url);
    
    xhr.open('GET', url);
    xhr.setRequestHeader('X-RapidAPI-Key', '249064afcfmshdf0ac49a7d7063fp185ecbjsn3a1c4e63f744');
    xhr.setRequestHeader('X-RapidAPI-Host', 'omgvamp-hearthstone-v1.p.rapidapi.com');
    
    xhr.send(data);
}

function disableButtons() {
    // Getting buttons
    nameBtn = document.getElementById("nameBtn");
    classBtn = document.getElementById("classBtn");
    raceBtn = document.getElementById("raceBtn");
    factionBtn = document.getElementById("factionBtn");
    qualityBtn = document.getElementById("qualityBtn");
    typeBtn = document.getElementById("typeBtn");
    
    // Enabling Buttons
    nameBtn.disabled = true;
    classBtn.disabled = true;
    raceBtn.disabled = true;
    qualityBtn.disabled = true;
    factionBtn.disabled = true;
    typeBtn.disabled = true;
}

function enableButtons() {
    // Getting buttons
    nameBtn = document.getElementById("nameBtn");
    classBtn = document.getElementById("classBtn");
    raceBtn = document.getElementById("raceBtn");
    factionBtn = document.getElementById("factionBtn");
    qualityBtn = document.getElementById("qualityBtn");
    typeBtn = document.getElementById("typeBtn");
    
    // Enabling Buttons
    nameBtn.disabled = false;
    classBtn.disabled = false;
    raceBtn.disabled = false;
    qualityBtn.disabled = false;
    factionBtn.disabled = false;
    typeBtn.disabled = false;
}

// Clears results from the page
function clearResults() {
    disp = document.getElementById("cardDisplay");
    disp.innerHTML = "";
}

// Prints results to the page
// Arguments:
//   Data: The JSON data
//   all: If the user searched for all cards (JSON for all cards is formatted     differently)
//   filterImgs: If the user wishes to filter out cards with no image links
function printResults(data, all = false, filterImgs = false) {
    
    enableButtons();
    
    // Changing results header to "Search Results"
    resultsH = document.getElementById("resultsH");
    resultsH.textContent = "Search Results";
    
    disp = document.getElementById("cardDisplay");
    
    // Printing cards based on search type
    if (all) {
        // Converting JSON to list format
        sets = JSON.parse(data);

        Object.values(sets).forEach(function(cards) {
           cards.forEach(function(card) {
            
                // Skip card if it doesn't have an image link
                if(filterImgs) {
                    if (!('img' in card)) return;
                }
                
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
            });
            
        });
        
    }
    else {
        // Converting JSON to list format
        try {
            cards = JSON.parse(data);
        } catch (e) {
            console.log(e);
            return;
        }
        
        cards.forEach(function(card) {
            
            // Skip card if it doesn't have an image link
            if(filterImgs) {
                if (!('img' in card)) return;
            }
            
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

        });
    }
}

getSuggestionData();


