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
