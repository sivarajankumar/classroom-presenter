window.onload = function() {
	document.getElementById("frButton").onclick = showHide;
	document.getElementById("mcButton").onclick = showHide;
	document.getElementById("createSurvey").onclick = showHide;
};

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

function printToScreen(data){
    $("#display").html(data);
}

// creates a new free-response survey
function onCreateFree() {
    var text = submitform.elements["textfeed"].value;
    // var type = submitsurvey.elements["typeSurvey"].value;
    if ( text.length == 0 )
	{
		alert("Please enter a free-response survey in the text box before submitting.");
	}
	else
	{
        createFR(24104, text, printToScreen);
    }
}

$("#timeline").live('click', function(event){
	mypopup();
});
function mypopup(){
    mywindow = window.open("https://cubist.cs.washington.edu/~chriacua/Incognito/instr/graph.php", "mywindow", "location=0,status=1,scrollbars=0,  width=300,height=300");
    mywindow.moveTo(0, 0);
}