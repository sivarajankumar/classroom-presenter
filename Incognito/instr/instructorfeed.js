// Makes the call to the backend to retrieve feed data
function getFeed(sid, filter, sort, callback) {
    // Make the HTTP request
    $.post("scripts/lookup_questions.php",
    {sid: sid, filter: filter, sort: sort, callback: callback},
    function(data) {
        callback(data);
    });
}

// Makes the call to mark a Q/F as answered
function onMarkAnswered(type, id, flag) {
    // Make the HTTP request
    $.post("scripts/answer_question.php",
    {type: type, id: id, flag: flag},
    function(data) {
        alert("Success!");
    });
}

var filter;
var sort;

function printToScreen(data){
    $("#feed").html(data);
}

// Handles the event of when the filter select boxes change
function onFilterChange() {
    window.filter = $("#filter option:selected").text();
    // Once we can get session ID from the backend, we retrieve
    // feeds from the correct session.
    getFeed(23456, window.filter, window.sort, printToScreen);
}

// Handles the event of when the newest sort link has been clicked
function onNewestSortChange() {
    window.sort = "Newest";
    getFeed(23456, window.filter, window.sort, printToScreen);
}

// Handles the event of when the priority sort link has been clicked
function onPrioritySortChange() {
    window.sort = "Priority";
    getFeed(23456, window.filter, window.sort, printToScreen);
}

window.onload = function() {
    filter = "None";
    sort = "Newest"; // default to sorting by newest
    getFeed(23456, window.filter, window.sort, printToScreen);
    $('#filter').change(onFilterChange);
    $('#newest').click(onNewestSortChange);
    $('#priority').click(onPrioritySortChange);
    $('.check').live('click', function () {
        onMarkAnswered(this.id.charAt(6),this.id.substr(7),this.checked);
    });
};

setInterval("feedRefresh()", 2000) // Refreshes the feed page every 2 seconds

function feedRefresh() {
	getFeed(23456, window.filter, window.sort, printToScreen);
}
