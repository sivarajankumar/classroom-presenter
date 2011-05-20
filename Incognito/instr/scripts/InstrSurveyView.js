/* This file contains all of frontend interface
for instructors to interact with the state in the 
database. */

// This function takes a session id and question text, 
// then creates a new multiple choice survey. In addition,
// you must provide an array of choices. 
function createMC(sessionId, questionText, getSurvey, choices) {
	
	// Encode the choices as a json string
	var jsonChoices = JSON.stringify(choices);
	
	$.post("scripts/create_survey.php", 
			{sid: sessionId, text:questionText, type:'mc', choices:jsonChoices},
			function(data) {
				getSurvey(data);
			});
}

//This function takes a session id and question text, 
//then creates a new free response survey. 
function createFR(sessionId, questionText, getSurvey) {
	
	$.post("scripts/create_survey.php", 
			{sid: sessionId, text:questionText, type:'fc'},
			function(data) {
				getSurvey(data);
			});
}