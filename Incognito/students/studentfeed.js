// Makes the call to retrieve feed data
function getFeed(sid, uid, filter, sort, callback) {
    // Make the HTTP request
    $.post("scripts/studentfeed_lookup_questions.php",
    {sid: sid, uid: uid, filter: filter, sort: sort, callback: callback},
    function(data) {
        callback(data);
    });
}

// Makes the call to send a vote in
function onVote(id, type, uid, vote) {
    // Make the HTTP request
    $.post("scripts/submit_vote.php",
    {id: id, type: type, uid: uid, vote: vote},
    function(data) {
        // alert('Success!');
    });
}

var filter;
var sort;

// Prints the data to the feed div
function printToScreen(data){
    $("#feed").html(data);
}

// Handles the event of when the filter select boxes change
function onFilterChange() {
    window.filter = $("#filter option:selected").text();
    // Once we can get session ID from the backend, we retrieve
    // feeds from the correct session.
    var cookie = readCookie('uid');
    if(cookie != null)
        getFeed(23456, $.cookie('uid'), window.filter, window.sort, printToScreen);
}

// Handles the event of when the newest sort link has been clicked
function onNewestSortChange() {
    window.sort = "Newest";
    var cookie = readCookie('uid');
    if(cookie != null)
        getFeed(23456, $.cookie('uid'), window.filter, window.sort, printToScreen);
}

// Handles the event of when the priority sort link has been clicked
function onPrioritySortChange() {
    window.sort = "Priority";
    var cookie = readCookie('uid');
    if(cookie != null)
        getFeed(23456, cookie, window.filter, window.sort, printToScreen);
}

// On initial window load, initialize events and reset
// filter and sort variables
window.onload = function() {
    filter = "None";
    sort = "Newest"; // default to sorting by newest
    var cookie = readCookie('uid');
    getFeed(23456, cookie, window.filter, window.sort, printToScreen);

    $('#filter').change(onFilterChange);
    $('#newest').click(onNewestSortChange);
    $('#priority').click(onPrioritySortChange);
    $('.check').live('click', function () {
        onVote(this.id.substr(7),this.id.charAt(6),cookie,this.checked);
    });
};

setInterval("refreshFeed()", 2000); // refresh every 2000 milliseconds

function refreshFeed() {
    var cookie = readCookie('uid');
    if(cookie != null)
        getFeed(23456, cookie, window.filter, window.sort, printToScreen);
}

// Having problems reading in cookies using JQuery
// Fix using Javascript
function readCookie(name) {  
  
    var cookiename = name + "=";  
    var ca = document.cookie.split(';');  
    for(var i=0;i < ca.length;i++)  
    {
        var c = ca[i];  
        while (c.charAt(0)==' ') c = c.substring(1,c.length);  
        if (c.indexOf(cookiename) == 0) return c.substring(cookiename.length,c.length);  
    }
    return null;
    
}  
