let curColor = "white";
let counter = 0;

function selectColor(color) {
    colorSelector = document.getElementById("colorSelection");
    colorSelector.style.background = color;
    curColor = color;
}

function changeButtonColor() {
    self = document.activeElement;
    countEl = document.getElementById("counter");
    
    self.style.background = curColor;
    counter += parseInt(self.innerHTML);
    countEl.innerHTML = "Button Sum: " + counter;
}

function createButton() {
    viewBox = document.getElementById("viewBox");
    viewRect = viewBox.getBoundingClientRect();
    
    buttonText = (Math.floor(Math.random() * 100)).toString();
    buttonTop = Math.floor(Math.random() * (viewRect.height - 50))
    buttonLeft = Math.floor(Math.random() * (viewRect.width - 200))
    
    btn = document.createElement("BUTTON");
    btn.innerHTML = buttonText;
    btn.className = "funnyButton";
    btn.onclick = function(){changeButtonColor()};
    btn.style.background = curColor;
    btn.style.top = buttonTop + "px";
    btn.style.left = buttonLeft + "px";
    
    
    viewBox.appendChild(btn);
}

