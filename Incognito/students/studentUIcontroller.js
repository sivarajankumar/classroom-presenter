/*
 * This file is similar to the instructor UI controller except that
 * it handles events on the student side. So events like mouse clicks
 * or updates will be sent through this function. In addition, like the 
 * instructor UI controller, this controller will handle the all of the 
 * state during the student's visit to Incognito. 
 
$question = $_GET['texthome'];
echo $question;
*/

var currentSession;
var timestamp;

function getContent(){

}

function onUpdate(){

}

function onSubmit(){
	var text = submitform.elements["texthome"].value; // Haven't figured out the jQuery for this yet.
	var uid = $.cookie('uid');
	if ( text.length == 0 )
	{
		alert("Please enter a question or comment in the text box before submitting.");
	}
	else
	{
		var type = $('input[name=submitType]:checked', '#submitform').val();
		// alert( type );
		var sid = 23456;
		var uid = $.cookie('uid');
		//var uid = 444;
		var dataString;
		var numvotes;
		if (type == 'Q')
		{
			var answered = 0;
			numvotes = 0;
			//dataString = 'text=' + text + '&sid=' + sid + '&answered=' + answered + '&numvotes=' + numvotes + '&type=' + type;
			dataString = 'type=' + type + '&numvotes=' + numvotes + '&text=' + text + '&sid=' + sid + '&uid=' + uid;
			$.ajax({
				type: "POST",
				url: "scripts/submit_question.php",
				data: dataString,
				success: function(response){
					// alert( response );
				}
			});
		}
		else if (type == 'F')
		{
			numvotes = 0;
			var isread = 0;
			//dataString = 'text=' + text + '&sid=' + sid + '&numvotes=' + numvotes + '&isread=' + isread + '&type=' + type;
			dataString = 'type=' + type + '&numvotes=' + numvotes + '&text=' + text + '&sid=' + sid + '&uid=' + uid;
			$.ajax({
				type: "POST",
				url: "scripts/submit_question.php",
				data: dataString,
				success: function(){
					// alert( 'Success!' );
				}
			});
		}
	}
}
