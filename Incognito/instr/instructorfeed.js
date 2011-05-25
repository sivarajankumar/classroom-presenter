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
        // alert("Success!");
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
    $sid = $.cookie('sid');
    getFeed($sid, window.filter, window.sort, printToScreen);
}

// Handles the event of when the newest sort link has been clicked
function onNewestSortChange() {
	$("#newest").css({'font-weight': 'bold', 'color': 'black'});
	$("#priority").css({'font-weight': 'normal', 'color': '#A00000'});
    window.sort = "Newest";
    $sid = $.cookie('sid');
    getFeed($sid, window.filter, window.sort, printToScreen);
}

// Handles the event of when the priority sort link has been clicked
function onPrioritySortChange() {
	$("#newest").css({'font-weight': 'normal', 'color': '#A00000'});
	$("#priority").css({'font-weight': 'bold', 'color': 'black'});
    window.sort = "Priority";
    $sid = $.cookie('sid');
    getFeed($sid, window.filter, window.sort, printToScreen);
}

window.onload = function() {
    filter = "None";
    sort = "Newest"; // default to sorting by newest
    $sid = $.cookie('sid');
    getFeed($sid, window.filter, window.sort, printToScreen);
    $('#filter').change(onFilterChange);
    $('#newest').click(onNewestSortChange);
    $('#priority').click(onPrioritySortChange);
    $('.check').live('click', function () {
        onMarkAnswered(this.id.charAt(6),this.id.substr(7),this.checked);
    });
	$("#newest").css({'font-weight': 'bold', 'color': 'black'});
	$("#priority").css({'font-weight': 'normal'});
};
$("#timeline").live('click', function(event){
	mypopup();
});
function mypopup(){
    mywindow = window.open("https://cubist.cs.washington.edu/~ashen/Incognito/instr/graph.php", "mywindow", "location=0,status=1,scrollbars=0,  width=300,height=300");
    mywindow.moveTo(0, 0);
}

setInterval("feedRefresh()", 2000) // Refreshes the feed page every 2 seconds

function feedRefresh() {
    $sid = $.cookie('sid');
	getFeed($sid, window.filter, window.sort, printToScreen);
}

