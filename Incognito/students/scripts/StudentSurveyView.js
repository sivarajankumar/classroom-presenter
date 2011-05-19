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
			{sid: surveyId, answer: studentAnswer, type:'fr', uid: userId});;
}