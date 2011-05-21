/* This file contains all of frontend interface
for instructors to interact with the state in the 
database. */

// This function takes a session id and question text, 
// then creates a new multiple choice survey. 
function createMC(sessionId, questionText, getSurvey, choices) {
	
	$.post("scripts/create_survey.php", 
			{sid: sessionId, text:questionText, type:'mc', choices: choices},
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
// and a handler, get's the surveys associated with the setting. In addition
// you can filter by open and closed surveys. Note that you can pass a negative
// 1 if you do note care. 
//
// Filter args: 'fr' Filters everything except free response surveys
//				'mc' Filters everything except multiple choice surveys
//				'none' Does not filter anything
//
// Sort args:	'mr' Sorts by the most recent entries
//				'none' No sorting applied
function getSurvey(surveyId, filter, sort, open, handler) {
	
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
