playbackState = false;
bookmarkList = [];
audio = null;
currentId = 0;
currentBookmark = 0;
stopAtEndSegment = false;

function loadVariables() {
    
    bookmarkList.push(new Bookmark(0, "Beginning", 0));
    bookmarkList.push(new Bookmark(1, "Chuggs", 17));
    bookmarkList.push(new Bookmark(2, "Spicy Riffs", 70));
    bookmarkList.push(new Bookmark(3, "More Chuggs", 102));
    bookmarkList.push(new Bookmark(4, "Back to the Riffs", 110));
    bookmarkList.push(new Bookmark(5, "Spooky Section", 180));
    currentId=6;
    
    filename = document.getElementById("filename");
    filename.innerHTML = "valhalla.mp3";
    audio = document.getElementById("valhalla");
    displayBookmarks();
    console.log("Audio Ready");
}

function Bookmark(id, title, time) {
    this.id = id;
    this.title = title;
    this.time = time;
}

function updateTime() {
    var trackTime = document.getElementById("trackTime");
    
    currTimeS = parseInt(audio.currentTime % 60).toString().padStart(2, "0");
    currTimeM = parseInt((audio.currentTime / 60) % 60);
    currTime = currTimeM + ":" + currTimeS;
    
    durationS = parseInt(audio.duration % 60).toString().padStart(2, "0");
    durationM = parseInt((audio.duration / 60) % 60);
    duration = durationM + ":" + durationS;
    
    trackTime.innerHTML = currTime + ' / ' + duration;
    if (bookmarkList.length > (currentBookmark + 1)) endSegment = bookmarkList[currentBookmark + 1].time;
    else stopAtEndSegment = false;
    if (stopAtEndSegment && (audio.currentTime >= endSegment)) {
        audio.pause();
        togglePlayback();
        stopAtEndSegment = false;
    }
}

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

function createBookmark() {
    if (bookmarkList.length >= 50) {
        alert("Too many bookmarks!");
        return;
    }
    titleInput = document.getElementById("title");
    title = titleInput.value;
    time = audio.currentTime;
    const found = bookmarkList.some(el => el.title == title);
    if (!found) bookmarkList.push(new Bookmark(currentId++, title, time));
    else alert("Title already exists!");
    titleInput.value = "";
    bookmarkList.sort((a, b) => a.time - b.time);
    currentBookmark = bookmarkList.length - 1;
    displayBookmarks();
}

function removeBookmark() {
    bookmarkList.splice(currentBookmark, 1);
    currentBookmark--;
    displayBookmarks();
}

function loadBookmark(id) {
    var bookmark = bookmarkList.find(bm => {
        return bm.id == id;
    });
    const bm = (bookmark) => bookmark.id == id;
    currentBookmark = bookmarkList.findIndex(bm);
    console.log(currentBookmark);
    audio.currentTime = bookmark.time;
    audio.play();
    if (!playbackState) togglePlayback();
    stopAtEndSegment = true;
}

function displayBookmarks() {
    bookmarks = document.getElementById("bookmarks");
    bookmarks.innerHTML = "";
    bookmarkList.forEach(bm => {
        bookmarks.innerHTML += "<li><button class=\"bookmark\" id=\"" + bm.id + "\" onclick=\"loadBookmark(" + bm.id + ")\">" + bm.title + "</button></li>";
    });
}

function rewind() {
    audio.currentTime -=5;
}

function forward() {
    audio.currentTime +=5;
}






