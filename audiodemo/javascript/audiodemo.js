//Initiating globals
playbackState = false;
bookmarkList = [];
audio = null;
currentId = 0;
currentBookmark = 0;
stopAtEndSegment = false;

//Loads required variables when page is loaded
function loadVariables() {
    bookmarkList.push(new Bookmark(0, "Beginning", 0));
    bookmarkList.push(new Bookmark(1, "Chuggs", 17));
    bookmarkList.push(new Bookmark(2, "Spicy Riffs", 70));
    bookmarkList.push(new Bookmark(3, "More Chuggs", 102));
    bookmarkList.push(new Bookmark(4, "Back to the Riffs", 110));
    bookmarkList.push(new Bookmark(5, "Spooky Section", 180));
    
    //creating phantom bookmark with high timestamp so that "last" bookmark is registered properly
    bookmarkList.push(new Bookmark("phantom", "PHANTOM", 10000, false));
    currentId=6;
    
    filename = document.getElementById("filename");
    filename.innerHTML = "valhalla.mp3";
    audio = document.getElementById("valhalla");
    displayBookmarks();
    console.log("Audio Ready");
}

//Bookmark class
function Bookmark(id, title, time, display=true) {
    this.id = id;
    this.title = title;
    this.time = time;
    this.display = display;
}

//This function is called every time the audio object has a time update
function updateTime() {
    //getting time element from HTML
    var trackTime = document.getElementById("trackTime");
    
    //Retrieving and formatting current time
    currTimeS = parseInt(audio.currentTime % 60).toString().padStart(2, "0");
    currTimeM = parseInt((audio.currentTime / 60) % 60);
    currTime = currTimeM + ":" + currTimeS;
    
    //Retrieving and formatting song duration
    durationS = parseInt(audio.duration % 60).toString().padStart(2, "0");
    durationM = parseInt((audio.duration / 60) % 60);
    duration = durationM + ":" + durationS;
    
    //printing time to page
    trackTime.innerHTML = currTime + ' / ' + duration;
    
    //Pause audio if time has reached beginning of next bookmark
    endSegment = bookmarkList[currentBookmark + 1].time;
    if (stopAtEndSegment && (audio.currentTime >= endSegment)) {
        togglePlayback();
        stopAtEndSegment = false;
    }
    
    //updating current bookmark
    const bm = (bookmark) => bookmark.time > audio.currentTime;
    currentBookmark = bookmarkList.findIndex(bm) - 1;
    console.log(currentBookmark);
}

//Toggles playblack button
function togglePlayback() {
    var btn = document.getElementById("togglePlayback");

    if (playbackState) {
    audio.pause();
    btn.innerHTML = "&#9658;";
    btn.title = "Play";
    playbackState = false;
    } else {
    audio.play();
    btn.innerHTML = "&#10074;&#10074";
    btn.title = "Pause";
    playbackState = true;
    }
}

//Creates a bookmark at the current timestamp
function createBookmark() {
    //Makes sure there are less than 50 bookmarks
    if (bookmarkList.length >= 50) {
        alert("Too many bookmarks!");
        return;
    }

    //getting Title and current time
    titleInput = document.getElementById("title");
    title = titleInput.value;
    time = audio.currentTime;

    //Add title if it doesn't already exist
    const found = bookmarkList.some(el => el.title == title);
    if (!found) bookmarkList.push(new Bookmark(currentId++, title, time));
    else alert("Title already exists!");

    //reset input field
    titleInput.value = "";

    //sorts bookmark list by time then displays list
    bookmarkList.sort((a, b) => a.time - b.time);
    displayBookmarks();
}

//removes current bookmark
function removeBookmark() {
    //checks that there are at least 7 bookmarks before deleting one
    //check is set at 7 to maintain 6 + the phantom
    if (bookmarkList.length > 7) {
        bookmarkList.splice(currentBookmark, 1);
    displayBookmarks();
    }
    else alert("There Cannot be Less Then 6 Bookmarks!");
}

//loads bookmark when clicked
function loadBookmark(id) {
    //finds bookmark by id
    var bookmark = bookmarkList.find(bm => {
        return bm.id == id;
    });
    audio.currentTime = bookmark.time;
    
    //assures that playback button maintains the correct state when song automatically stops
    const bm = (bookmark) => bookmark.id == id;
    currentBookmark = bookmarkList.findIndex(bm);
    if (!playbackState) togglePlayback();
    else audio.play();
    stopAtEndSegment = true;
}

//prints the list of bookmarks to the page
function displayBookmarks() {
    bookmarks = document.getElementById("bookmarks");
    bookmarks.innerHTML = "";
    bookmarkList.forEach(bm => {
        if (bm.display) {
            bookmarks.innerHTML += "<li><button class=\"bookmark\" id=\"" + bm.id + "\" onclick=\"loadBookmark(" + bm.id + ")\">" + bm.title + "</button></li>";
        }
    });
}

//rewind 5 seconds
function rewind() {
    audio.currentTime -=5;
}

//fast forward 5 seconds
function forward() {
    audio.currentTime +=5;
}






