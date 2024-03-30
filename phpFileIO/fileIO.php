<?php

// Create cookie
function createCookie() {
    $cookie_name = "firstVisit";
    $cookie_value = "true";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
}

// Delete cookie
function deleteCookie() {
    // set the expiration date to one hour ago
    setcookie("firstVisit", "", time() - 3600);
}

// Test if number is prime
function isPrime($n)
{
    // Loop through all numbers from 2 to n-1
    for ($x = 2; $x < $n; $x++)
    {
        // If n is divisible by any number other than 1 and itself,
        // it's not prime, so return 0
        if ($n % $x == 0)
        {
            return 0;
        }
    }
    // If no divisor found, n is prime, so return 1
    return 1;
}

// Test if number is square root, helper for isPrime
function isPerfectSquare($n) { 
    $s = (int)sqrt($n); 
    return ($s * $s == $n); 
} 
 
// Test if number is fibonacci
function isFibonacci($n) { 
    return isPerfectSquare(5 * $n * $n + 4)  
        || isPerfectSquare(5 * $n * $n - 4); 
}

// Test if number is Armstrong
function isArmstrong($number){
    $sum = 0;  
    $x = $number;  
    while($x != 0)  
    {  
        $rem = $x % 10;  
        $sum = $sum + $rem*$rem*$rem;  
        $x = $x / 10;  
    }  
     
    // if true then armstrong number
    if ($number == $sum)
        return 1;
     
    // not an armstrong number    
    return 0;    
}

// Reset everything
function resetAll() {
    // Delete cookie
    deleteCookie();
    
    // Empty post
    $_POST = array();
    
    // Delete text files
    unlink('doc/prime.txt');
    unlink('doc/arm.txt');
    unlink('doc/fib.txt');
    unlink('doc/none.txt');

}

// Writes prime numbers to file
function writePrime($primeArr) {
    $prime = fopen("doc/prime.txt", "w");
    
    $lastKey = array_key_last($primeArr);
    foreach ($primeArr as $k => $num) {
        if ($k != $lastKey) {
            fwrite($prime, $num . ", ");
        } else {
            fwrite($prime, $num);
        }
        
    }
    
    fclose($prime);
    
}

// Writes fibonacci numbers to file
function writeFib($fibArr) {
    $fib = fopen("doc/fib.txt", "w");
    
    $lastKey = array_key_last($fibArr);
    foreach ($fibArr as $k => $num) {
        if ($k != $lastKey) {
            fwrite($fib, $num . ", ");
        } else {
            fwrite($fib, $num);
        }
        
    }
    
    fclose($fib);
}

// Writes armstrong numbers to file
function writeArmstrong($armArr) {
    $arm = fopen("doc/arm.txt", "w");
    
    $lastKey = array_key_last($armArr);
    foreach ($armArr as $k => $num) {
        if ($k != $lastKey) {
            fwrite($arm, $num . ", ");
        } else {
            fwrite($arm, $num);
        }
        
    }
    
    fclose($arm);
}

// Writes other numbers to file
function writeNone($noneArr) {
    $none = fopen("doc/none.txt", "w");
    
    $lastKey = array_key_last($noneArr);
    foreach ($noneArr as $k => $num) {
        if ($k != $lastKey) {
            fwrite($none, $num . ", ");
        } else {
            fwrite($none, $num);
        }
        
    }
    
    fclose($none);
}

// Gets prime numbers from file and displays them on page
function getPrime() {
    $file = "doc/prime.txt";
    $prime = fopen($file, "r");
    $str = fread($prime, filesize($file));
    echo '<script>document.addEventListener("DOMContentLoaded", () => {document.getElementById("displayArea").innerHTML = "<b>Prime Numbers:</b><br>' . $str . '";});</script>';
    fclose($prime);
}

// Gets fibonacci numbers from file and displays them on page
function getFib() {
    $file = "doc/fib.txt";
    $fib = fopen($file, "r");
    $str = fread($fib, filesize($file));
    echo '<script>document.addEventListener("DOMContentLoaded", () => {document.getElementById("displayArea").innerHTML = "<b>Fibonacci Numbers:</b><br>' . $str . '";});</script>';
    fclose($fib);
}

// Gets armstrong numbers from file and displays them on page
function getArm() {
    $file = "doc/arm.txt";
    $arm = fopen($file, "r");
    $str = fread($arm, filesize($file));
    echo '<script>document.addEventListener("DOMContentLoaded", () => {document.getElementById("displayArea").innerHTML = "<b>Armstrong Numbers:</b><br>' . $str . '";});</script>';
    fclose($arm);
}

// Gets other numbers from file and displays them on page
function getNone() {
    $file = "doc/none.txt";
    $none = fopen($file, "r");
    $str = fread($none, filesize($file));
    echo '<script>document.addEventListener("DOMContentLoaded", () => {document.getElementById("displayArea").innerHTML = "<b>Other Numbers:</b><br>' . $str . '";});</script>';
    fclose($none);
}

// Run code

// If cookie does not exist, create it
if(!isset($_COOKIE["firstVisit"])) {
    createCookie();
} 
// If cookie does exist and submit button was pressed
else {
    if(array_key_exists('submit', $_POST)) {
        if (isset($_POST['numList'])) {
            // Get list and parse user input
            $tempStr = $_POST['numList'];
            $tempStr = (string)str_replace(" ", "", $tempStr);
            $numArr = explode(",", $tempStr);
            
            $primeArr = [];
            $fibArr = [];
            $armArr = [];
            $noneArr = [];

            // Populate arrays with numbers
            foreach ($numArr as $num) {
                if (isPrime($num)) {
                    $primeArr[] = $num;
                }
                if (isFibonacci($num)) {
                    $fibArr[] = $num;
                }
                if (isArmstrong($num)) {
                    $armArr[] = $num;
                }
                if (!isPrime($num) && !isFibonacci($num) && !isArmstrong($num)){
                    $noneArr[] = $num;
                }
            }
            
            // Populate files with numbers from arrays
            writePrime($primeArr);
            writeArmstrong($armArr);
            writeFib($fibArr);
            writeNone($noneArr);
        }
    }
    // If prime button pressed, display numbers
    else if(array_key_exists('primeBtn', $_POST)) {
        getPrime();
    }
    // If fibonacci button pressed, display numbers
    else if(array_key_exists('fibBtn', $_POST)) { 
        getFib();
    }
    // If armstrong button pressed, display numbers
    else if(array_key_exists('armBtn', $_POST)) { 
        getArm();
    }
    // If none button pressed, display numbers
    else if(array_key_exists('noneBtn', $_POST)) { 
        getNone();
    }
    // If reset button pressed, reset
    else if(array_key_exists('resetBtn', $_POST)) { 
        resetAll();
    }

}










?>