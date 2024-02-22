// Noah Doering
// 2/22/2024
// CPSC 3750
// program exam #1 
// A

// GLOBAL
let primeList = [];
let compositeList = [];

// jquery
$(document).ready(function(){
    
    // start button click event
    $("#start").click(function(){
        createLists();
    });
    
    $("#getPrimeSum").click(function(){
        primeSum();
    });
    
    $("#getCompositeSum").click(function(){
        compositeSum();
    });
    
});

function primeSum() {
    // get area to print sum
    sumBox = document.getElementById("primeSum");
    
    // get sum
    sum = primeList.reduce((partialSum, a) => partialSum + a, 0);
    
    // print sum
    sumBox.innerHTML = 'Sum of Primes: ' + sum;
}

function compositeSum() {
    // get area to print sum
    sumBox = document.getElementById("compositeSum");
    
    // get sum
    sum = compositeList.reduce((partialSum, a) => partialSum + a, 0);
    
    // print sum
    sumBox.innerHTML = 'Sum of Composites: ' + sum;
}

// function to check if number is prime
function isPrime(num) { // returns boolean
  if (num <= 1) return false; // negatives, 0, and 1
  if (num % 2 === 0 && num > 2) return false; // even numbers
  const s = Math.sqrt(num); // store the square to loop faster
  for(let i = 3; i <= s; i += 2) { // start from 3, stop at the square, increment in twos
      if(num % i === 0) return false; // modulo shows a divisor was found
  }
  return true;
}

function changeColors(primeHTML, compositeHTML) {
    setInterval(function(){
        // generating random colors
        var randomColor1 = "#000000".replace(/0/g,function(){
            return (~~(Math.random()*16)).toString(16);
        });
        
        var randomColor2 = "#000000".replace(/0/g,function(){
            return (~~(Math.random()*16)).toString(16);
        });
        
        // change background colors
        primeHTML.style.backgroundColor = randomColor1;
        compositeHTML.style.backgroundColor = randomColor2;
    }, 5000);
}

function createLists() {
    // get user-input number
    let maxNumber = document.getElementById("numberInput").value;
    
    // populating number lists
    if(maxNumber >= 1) {
        for (let i = 1; i <= maxNumber; i++) {
            if(isPrime(i)) primeList.push(i);
            else compositeList.push(i);
        }
        
        printLists();
    }
    
    else alert("Input a valid number");
}

function printLists() {
    // find article
    article = document.getElementById("primes");
    
    // writing empty lists to HTML
    article.innerHTML += '<ul class="halfList" id="primeList"><h3>Prime List</h3></ul>';
    article.innerHTML += '<ul class="halfList" id="compositeList"><h3>Composite List</h3></ul>';
    
    //finding lists
    primeHTML = document.getElementById("primeList");
    compositeHTML = document.getElementById("compositeList");
    
    // start changing colors
    changeColors(primeHTML, compositeHTML);
    
    // printing numbers to lists
    primeList.forEach((num) => {
        primeHTML.innerHTML += '<li>' + num + '</li>';
    });
    
    primeHTML.innerHTML += '<li><button id="getPrimeSum" onclick="primeSum()">SUM</button></li><li id="primeSum"></li>';
    
    compositeList.forEach((num) => {
        compositeHTML.innerHTML += '<li>' + num + '</li>';
    });
    
    compositeHTML.innerHTML += '<li><button id="getCompositeSum" onclick="compositeSum()">SUM</button></li><li id="compositeSum"></li>';
}