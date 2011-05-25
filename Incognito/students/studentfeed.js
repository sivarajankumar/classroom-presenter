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
    $sid = $.cookie('sid'); 
    if($sid){
        getFeed($sid, $.cookie('uid'), window.filter, window.sort, printToScreen);
    }else{
        alert('No Session is open at the moment. Hint: What class are you in right now? Join it in the Settings page!');
    }
}

// Handles the event of when the newest sort link has been clicked
function onNewestSortChange() {
	$("#newest").html("font-weight: bold");
	$("#priority").html("font-weight: normal");
    window.sort = "Newest";
    $sid = $.cookie('sid');
    if($sid != null){
        getFeed($sid, $.cookie('uid'), window.filter, window.sort, printToScreen);
    }else{
        alert('No Session is open at the moment. Hint: What class are you in right now? Join it in the Settings page!');
    }
}

// Handles the event of when the priority sort link has been clicked
function onPrioritySortChange() {
	$("#newest").html("font-weight: normal");
	$("#priority").html("font-weight: bold");
    window.sort = "Priority";
    $sid = $.cookie('sid');
    if($sid != null){
        getFeed($sid, $.cookie('uid'), window.filter, window.sort, printToScreen);
    }else{
        alert('No Session is open at the moment. Hint: What class are you in right now? Join it in the Settings page!');
    }
}

// On initial window load, initialize events and reset
// filter and sort variables
window.onload = function() {
    filter = "None";
    sort = "Newest"; // default to sorting by newest
    $sid = $.cookie('sid');
    $uid = $.cookie('uid');

    if($sid){
        getFeed($sid, $uid, window.filter, window.sort, printToScreen);
    }else{
        alert('No Session is open at the moment. Hint: What class are you in right now? Join it in the Settings page!');
    } 
    $('#filter').change(onFilterChange);
    $('#newest').click(onNewestSortChange);
    $('#priority').click(onPrioritySortChange);
    $('.check').live('click', function () {
        onVote(this.id.substr(7) ,this.id.charAt(6), $uid, this.checked);
    });
};

setInterval("refreshFeed()", 2000); // refresh every 2000 milliseconds

function refreshFeed() {
    $uid = $.cookie('uid');
    $sid = $.cookie('sid');
    
    if($sid != null)
        getFeed($sid, $uid, window.filter, window.sort, printToScreen);
}

