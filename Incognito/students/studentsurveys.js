// Makes the call to retrieve feed data
function getFeed(sid, username, filter, sort, callback) {
    // Make the HTTP request
    $.post("scripts/studentfeed_lookup_questions.php",
    {sid: sid, username: username, filter: filter, sort: sort, callback: callback},
    function(data) {
        callback(data);
    });
}

var filter;
var sort;
var survey_id;

// Called after the free response survey form has been submitted
function freeCallback(v,m,f){

    // checks if the submit button was pressed
    if(v) {
        var cookie = readCookie('uid');
        if(cookie != null) {
            // window.survey_id.substr(9) parse the sid out of the string
            // f.response is the answer that the customer submitted
            submitFreeResponse(window.survey_id.substr(9), f.response, 333);
            $.prompt('Survey Successfully Submitted: ' + f.response, {prefix:'surveyPopup'});
        } else {
            $.prompt('Survey Failed to Submit', {prefix:'surveyPopup'});
        }
    }
}

function multiCallback(v,m,f) {
    if(v) {
        var option = f.option;
    
        $.prompt('Survey Successfully Submitted: ' + option, {prefix:'surveyPopup'});
    } else {
        $.prompt('Survey Failed to Submit', {prefix:'surveyPopup'});
    }
}

// Prints to survey feed div
function printToScreen(data) {
	$("#feed").html(data);
}

// Handles the event of when the filter select boxes change
function onFilterChange() {
    window.filter = $("#filter option:selected").text();
    // Once we can get session ID from the backend, we retrieve
    // feeds from the correct session.
    // getFeed(23456, "ashen", window.filter, window.sort, printToScreen);
}

// Handles the event of when the newest sort link has been clicked
function onNewestSortChange() {
    window.sort = "Newest";
    // getFeed(23456, "ashen", window.filter, window.sort, printToScreen);
}

// Handles the event of when the priority sort link has been clicked
function onPrioritySortChange() {
    window.sort = "Priority";
    // getFeed(23456, "ashen", window.filter, window.sort, printToScreen);
}


// On initial window load, initialize events and reset
// filter and sort variables
window.onload = function() {
    filter = "fr";
    sort = "none"; // default to sorting by newest
    var cookie = readCookie('sid');
    getSurvey(cookie, "none", "none", printToScreen);
    
    $('.respond').live('click', function () {
        survey_id = $(this).attr("id");
        var question = $(this).parent().find('.question').text();
        var stype = $(this).parent().find('.surveytype').text();
        
        // Handle the types of survey
        if(stype == 'Free Response') {
            var survey_text = question + '<br /><input type="text" id="' + survey_id + '" name="response" value="Respond here" />';
            $.prompt(survey_text,{ callback: freeCallback, buttons: { Submit: true, Cancel: false }, prefix:'surveyPopup'});
        } else if(stype == 'Multiple Choice') {
            var option1 = "Test1";
            var option2 = "Test2";
            var option3 = "Test3";
            var option4 = "Test4";
            
            var survey_text = question + '<br /><br /><input type="radio" name="option" value="1">' + option1 + '</input><br /><input type="radio" name="option" value="2">' + option2 + '</input><br /><input type="radio" name="option" value="3">' + option3 + '</input><br /><input type="radio" name="option" value="4">' + option4 + '</input><br /><br />';
            $.prompt(survey_text,{ callback: multiCallback, buttons: { Submit: true, Cancel: false }, prefix:'surveyPopup'});
        }
    });
    
};

setInterval("refreshFeed()", 2000); // refresh every 2000 milliseconds

function refreshFeed() {
    var cookie = readCookie("sid");
	getSurvey(cookie, "none", "none", printToScreen);
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