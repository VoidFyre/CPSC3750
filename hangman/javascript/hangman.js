selectedWord = "";
let cheat = false;
gameEnded = false;
attemptsLeft = 10;
guessedLetters = [];
statusDiv = document.getElementById("status");
wordToGuess = document.getElementById("wordToGuess");
img = document.getElementById("img");

function startGame() {
    // Fetch a new word from the server
    fetch('/cpsc3750/getHangmanWord.php')
        .then(response => response.json())
        .then(data => {
            if(data.word) {
                if (cheat) alert(data.word);
                setupGame(data.word);
            } else {
                console.error('Error fetching word:', data.error);
            }
        }).catch(error => console.error('Error:', error));
        gameEnded = false;
        statusDiv.innerHTML = '';
}

function setupGame(word) {
    selectedWord = word;
    attemptsLeft = 10;
    wordToGuess.style.color = "white";
    guessedLetters = Array(selectedWord.length).fill('_');
    updateWordDisplay();
    generateLetterButtons();
}

function updateWordDisplay() {
    wordToGuess.innerText = guessedLetters.join(' ');
}

function gameOver() {
    statusDiv.innerText = 'Game Over! You Lost.';
    wordToGuess.style.color = "red";
    selectedWord.split('').forEach((letter, index) => {
        guessedLetters[index] = letter.toUpperCase();
        updateWordDisplay();
    });
    
    gameEnded = true;
}

function generateLetterButtons() {
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lettersDiv = document.getElementById('letters');
    lettersDiv.innerHTML = ''; // Clear previous buttons
    letters.split('').forEach(letter => {
        const button = document.createElement('button');
        button.id = letter;
        button.textContent = letter;
        button.onclick = () => guessLetter(letter);
        lettersDiv.appendChild(button);
    });
}

function guessLetter(letter) {
    console.log('Guessed letter:', letter);
    // Implement the guessing logic here
    // This is where you would update the displayed word or handle incorrect guesses
    if (gameEnded) return;
    const guess = letter.toLowerCase();
    
    document.getElementById(letter).disabled = true;
   
    if (guess && !gameEnded) {
        if (selectedWord.includes(guess)) {
            selectedWord.split('').forEach((letter, index) => {
                if (letter === guess) {
                    guessedLetters[index] = guess.toUpperCase();
                }
            });
        
            updateWordDisplay();
        
            if (!guessedLetters.includes('_')) {
                statusDiv.innerText = 'Congratulations! You won!';
                gameEnded = true;
            }
        } else {
            attemptsLeft--;
            img.src="/cpsc3750/images/hangman" + (10-attemptsLeft) + ".png"
            statusDiv.innerText = `Attempts Left: ${attemptsLeft}`;

            if (attemptsLeft === 0) {
                gameOver();
            }
        }
    }
}

// Initially start the game
startGame();

function toggleCheats() {
    var check = document.getElementById("cheat");
    if (check.checked) {
        cheat = true;
    } else {
        cheat = false;
    }
}