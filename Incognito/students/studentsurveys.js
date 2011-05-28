var filter;
var sort;
var survey_id;
var question;

// Called after the submit button click event happens
// for free-response surveys
function freeCallback(v,m,f){

    $uid = $.cookie("uid");
    
    // checks if the submit button was pressed
    if($uid != null && v) {
        // window.survey_id.substr(9) parse the sid out of the string
        // f.response is the answer that the customer submitted
        submitFreeResponse(window.survey_id.substr(9), f.response, $uid);
        $.prompt('<br />Survey Successfully Submitted<br /><br />', {prefix:'surveyPopup'});
        
    } else {
        $.prompt('<br />Survey Failed to Submit<br /><br />', {prefix:'surveyPopup'});
    }
}

// Called after the submit  button click event happens
// for multiple-choice surveys
function multiCallback(v,m,f) {
    if(v) {
        
        // Convert underscores back to spaces
        $choice = f.option.replace(/_/g,' ');
        
        submitMultipleChoice(window.survey_id.substring(9), $choice);
        $.prompt('Survey Successfully Submitted', {prefix:'surveyPopup'});
    } else {
        $.prompt('Survey Failed to Submit', {prefix:'surveyPopup'});
    }
}

// Prints to survey feed div
function printToScreen(data) {
	$("#feed").html(data);
}

// Handles the event of multiple-choice survey popup
function multiPopup(data) {

    var survey_text = window.question + '<br /><br />' + data + '<br />';
    $.prompt(survey_text,{ callback: multiCallback, buttons: { Submit: true, Cancel: false }, prefix:'surveyPopup'});
}

// On initial window load, initialize events and reset
// filter and sort variables
window.onload = function() {

    filter = "none";
    sort = "none"; // default to sorting by newest
    $sid = $.cookie("sid");
    if($sid != null)
        getSurvey($sid, window.filter, window.sort, printToScreen);
    
    $('.respond').live('click', function () {
        survey_id = $(this).attr("id");
        question = $(this).parent().parent().find('.question').text();
        var stype = $(this).parent().parent().find('.surveytype').text();

        // Handle the types of survey
        if(stype == 'Free Response') {
        
            var survey_text = '<br />' + question + '<br /><br /><input type="text" id="' + survey_id + '" name="response" value="Respond here" height="1000" size="30" maxlength="120"/><br /><br />';
            $.prompt(survey_text,{ callback: freeCallback, buttons: { Submit: true, Cancel: false }, prefix:'surveyPopup'});
        } else if(stype == 'Multiple Choice') {
            getChoices(survey_id.substring(9), multiPopup);
        }
    });
    
};

setInterval("refreshFeed()", 2000); // refresh every 2000 milliseconds

function refreshFeed() {
    $sid = $.cookie("sid");
    if($sid != null)
        getSurvey($sid, window.filter, window.sort, printToScreen);
}
