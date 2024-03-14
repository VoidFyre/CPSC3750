var calcBtn = document.getElementById("calc");
var calcValue = document.getElementById("dist");
var ourData = '';

calcBtn.addEventListener("click", function() {
    calculate();
});

function getData() {
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', 'https://raw.githubusercontent.com/millbj92/US-Zip-Codes-JSON/master/USCities.json');
    ourRequest.onload = function() {
        ourData = JSON.parse(ourRequest.responseText);
    };
    ourRequest.send();
}

function calculate() {
    var zip1 = document.getElementById("zip1").value;
    var zip2 = document.getElementById("zip2").value;

    var loc1 = ourData.find((zip) => zip.zip_code == zip1);
    var loc2 = ourData.find((zip) => zip.zip_code == zip2);
    
    console.log(loc1);
    console.log(loc2);
    lat1 = loc1.latitude;
    lat2 = loc2.latitude;
    st1 = loc1.state;
    st2 = loc2.state;
    cnt1 = loc1.county;
    cnt2 = loc2.county;
    

    var R = 6371;
    var dLat = deg2rad(lat2 - lat1);
    var dLon = deg2rad(loc2.longitude - loc1.longitude);
    var a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) + 
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = Math.round((R * c) * 100)/100;
    calcValue.innerHTML = "The distance from " + cnt1 + ", " + st1 + ", " + zip1 + " to " + cnt2 + ", " + st2 + ", " + zip2 + " is " + d + "km";
}

function deg2rad(deg) {
    return deg * (Math.PI/180);
}