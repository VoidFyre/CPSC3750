// initialize the counter and the array
var numbernames=0;
var names = new Array();
var input = document.getElementById("newname");
input.addEventListener("keypress", function(event) {
    if (event.keyCode == 13) {
        event.stopImmediatePropogation();
        event.preventDefault();
        document.getElementById("addname").click();
    }
});

function SortNames() {
   // Get the name from the text field
   thename=document.theform.newname.value;
   thename=thename.toUpperCase();
   // Add the name to the array
   names[numbernames]=thename;
   // Increment the counter
   numbernames++;
   // Sort the array
   
   names.sort();
   var numberList = new Array();
   for (let i = 0; i < names.length; i++) {
       numberList[i] = (i + 1).toString() + "." + names[i];
   }
   document.theform.sorted.value=numberList.join("\n");
}

