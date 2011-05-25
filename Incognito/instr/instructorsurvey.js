function showHide() {
	if(document.getElementById("createSurvey").checked){
		document.getElementById("createSurveyArea").style.display = 'none';
		document.getElementById("example").style.display = 'none';
	} else {
		document.getElementById("createSurveyArea").style.display = 'block';
		if (document.getElementById("frButton").checked) {
			document.getElementById("multArea").style.display = 'none';
			document.getElementById("freeArea").style.display = 'block';
		} else if(document.getElementById("mcButton").checked) {
			document.getElementById("multArea").style.display = 'block';
			document.getElementById("freeArea").style.display = 'none';
		}
	}	
}

// Creates a new free-response survey
function onCreateFree() { 
    // check to see if there is a session in session. 
    // If thre is no session, then no free response is
    // created.
    $sid = $.cookie('sid');
    
    if($sid){
        var text = submitform.elements["textfeed"].value;
        // var type = submitsurvey.elements["typeSurvey"].value;
        if ( text.length == 0 )  {
            alert("Please enter a free-response survey in the text box before submitting.");
        } else {
            createFR($sid, text, startSurvey);
        }
    }else{
        alert("Must open a session to create a Free Response. \nHint: \n    What class are you currently teaching? \n    Open the class session in the settings page!");
    }
}

$("#timeline").live('click', function(event){
	mypopup();
});
function mypopup(){
    mywindow = window.open("https://cubist.cs.washington.edu/~ashen/Incognito/instr/graph.php", "mywindow", "location=0,status=1,scrollbars=0,  width=300,height=300");
    mywindow.moveTo(0, 0);
}
