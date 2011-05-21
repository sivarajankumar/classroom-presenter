/* This file contains all of frontend interface
for instructors to interact with the state in the 
database. */

// This function takes a session id and question text, 
// then creates a new multiple choice survey. 
function createMC(sessionId, questionText, getSurvey) {
	
	$.post("scripts/create_survey.php", 
			{sid: sessionId, text:questionText, type:'mc'},
			function(data) {
				getSurvey(data);
			});
}

//This function takes a session id and question text, 
//then creates a new free response survey. 
function createFR(sessionId, questionText, getSurvey) {
	$.post("scripts/create_survey.php", 
			{sid: sessionId, text:questionText, type:'fr'},
			function(data) {
				getSurvey(data);
			});
}

// This function takes a survey id and opens the survey.
function startSurvey(sessionId) {
	$.post("scripts/start_survey.php",
			{sid: sessionId});
}

// This function takes a survey id and closes the survey
//This function takes a survey id and opens the survey.
function stopSurvey(sessionId) {
	$.post("scripts/close_survey.php",
			{sid: sessionId});
}

// This function, given a surveyId, a filter setting, a sort setting, 
// and a handler, get's the surveys associated with the setting. 
//
// Filter args: 'fr' Filters everything except free response surveys
//				'mc' Filters everything except multiple choice surveys
//				'none' Does not filter anything
//
// Sort args:	'mr' Sorts by the most recent entries
//				'none' No sorting applied
function getSurvey(surveyId, filter, sort, handler) {
	
	$.post("scripts/get_survey.php",
			{sid: surveyId, filter: filter, sort: sort},
			function(data) {
				handler(data);
			});
}

// This function takes a handler and a survey id. The function will
// then do an AJAX call to the get survey script, which will respond
// back with the survey results, which will be passed to the handler. 
function getResults(surveyId, handler) {
	
	$.post("scripts/get_results.php",
			{sid: surveyId},
			function(data) {
				handler(data);
			});
}

function printToScreen(data){
    $("#feed").html(data);
}

setInterval("feedRefresh()", 2000) // Refreshes the feed page every 2 seconds

function feedRefresh() {
    var cookie = readCookie('sid');
    if (cookie != null)
        getSurvey(cookie, 'fr', 'none', printToScreen);
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