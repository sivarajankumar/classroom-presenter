/* This file contains the interface that the front-end will
use to interact with all of the state held in the database. */

// This function handles submitting a free response answer given
// a survey id and the text answer from the student. In addition
// the front end must provide the user id to handle inappropriate 
// answers. 
//
// TODO: In the future we may pass a handler for to
//		 handle success conditions. 
function submitFreeResponse(surveyId, studentAnswer, userId) {
	
	$.post("scripts/submit_survey_answer.php",
			{sid: surveyId, answer: studentAnswer, type: "fr", uid: userId});;
}

// This function handles submitting a multiple choice answer given
// a survey id and the choice that the student gave. 
function submitMultipleChoice(surveyId, choice) {
	
	$.post("scripts/submit_survey_answer.php", 
			{sid: surveyId, answer: choice, type: "mc"});
}

// This function handles getting the surveys on the student side given
// the session id as well as arguments for filtering and sorting. In
// addition you must provide a function handler to handle the HTTP response. 
//
// Filtering arguments: 'fr' This will filter everything besides free response
//						'mc' This will filter everything besides multiple choice
//						'none' This will not filter any surveys
//
// Sorting arguments: 	'mr' This will sort the results by the most recent surveys
//						'none' This will not order the results
function getSurvey(sessionId, filter, sort, handler) {
	
	$.post("scripts/get_survey.php",
			{sid: sessionId, filter: filter, sort: sort},
			function(data) {
				handler(data);
			});
}
