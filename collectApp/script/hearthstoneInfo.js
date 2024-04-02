// Collects info from API
function collectInfo() {
    const data = null;

    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    xhr.addEventListener('readystatechange', function () {
    	if (this.readyState === this.DONE) {
    		writeInfo(this.responseText);
    	}
    });
    
    xhr.open('GET', 'https://omgvamp-hearthstone-v1.p.rapidapi.com/info');
    xhr.setRequestHeader('X-RapidAPI-Key', '249064afcfmshdf0ac49a7d7063fp185ecbjsn3a1c4e63f744');
    xhr.setRequestHeader('X-RapidAPI-Host', 'omgvamp-hearthstone-v1.p.rapidapi.com');
    
    xhr.send(data);
}

// Writes info to page
function writeInfo(data) {
    // Convert JSON into object format
    apiInfo = JSON.parse(data);
    
    infoDiv = document.getElementById("apiInfo");
    
    str = "";
    
    // For each item, print key name and length of value list
    for (const [key, value] of Object.entries(apiInfo)) {
        if (key == "patch") {
            str += `<p><b>${key}</b>: ${value}</p><br>`;
        } else
        str += `<p><b>${key}</b>: ${value.length}</p><br>`;
    }
    
    infoDiv.innerHTML += str;
}