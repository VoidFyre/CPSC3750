var btn = document.getElementById("btn");
var animalContainer = document.getElementById("animal-info");
var pageCounter = 1;

btn.addEventListener("click", function() {
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', 'https://learnwebcode.github.io/json-example/animals-' + pageCounter + '.json');
    ourRequest.onload = function() {
        var ourData = JSON.parse(ourRequest.responseText);
        createHTML(ourData);
    };
    ourRequest.send();
    pageCounter++;
    if (pageCounter > 3) {
        btn.classList.add("hidden");
    }
});

function createHTML(petsData) {
    var rawTemplate = document.getElementById("petsTemplate").innerHTML;
    //var rawTemplate = document.getElementById("test").innerHTML;
    var compiledTemplate = Handlebars.compile(rawTemplate);
    var ourGeneratedHTML = compiledTemplate(petsData);
    
    console.log(rawTemplate);
    console.log("Passed Data: " + compiledTemplate(petsData));
    
    
    var petsContainer = document.getElementById("animal-info");
    petsContainer.innerHTML = ourGeneratedHTML;
}

function renderHTML(data) {
    var htmlString = "";
    
    for (i = 0; i < data.length; i++) {
        htmlString += "<p>" + data[i].name + " is a " + data[i].species + " that likes to eat ";
        
        for (ii = 0; ii < data[i].foods.likes.length; ii++) {
            if (ii == 0) {
                htmlString += data[i].foods.likes[ii];
            } else {
                htmlString += " and " + data[i].foods.likes[ii];
            }
            
        }
        
        htmlString += ' and dislikes ';
        
        for (ii = 0; ii < data[i].foods.dislikes.length; ii++) {
            if (ii == 0) {
                htmlString += data[i].foods.dislikes[ii];
            } else {
                htmlString += " and " + data[i].foods.dislikes[ii];
            }
            
        }
        
        htmlString += ".</p>";
        
    }
    
    animalContainer.insertAdjacentHTML('beforeend', htmlString)
}