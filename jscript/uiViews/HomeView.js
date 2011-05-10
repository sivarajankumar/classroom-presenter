/*
 * This file contains all of the functions necessary to update the home
 * portion of the website. In addition, this javascript file contains 
 * all of the fields necessary to maintain the state of the home part 
 * of Incognito.  
 */

var data;

window.onload = function() {
	$.ajax({
		type: "POST",
		url: "lookup_questions.php",
		data: "sid=22222",
		success: function(msg){
			data = json_decode(msg);
			alert( data );
			}
	});
};