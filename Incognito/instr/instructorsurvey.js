window.onload = function() {
//alert("DOES IT GET HEREf");
	document.getElementById("frButton").onclick = showHide;
	document.getElementById("mcButton").onclick = showHide;
	document.getElementById("createSurvey").onclick = showHide;
};

function showHide() {
//alert("DOES IT GET HEREffffffffffffaaaaaaaaaaaa");
	if(document.getElementById("createSurvey").checked){
	
			//alert("DOES IT GET HEREffffffffffff");
		document.getElementById("createSurveyArea").style.display = 'none';
		document.getElementById("example").style.display = 'none';
	} else {
		document.getElementById("createSurveyArea").style.display = 'block';
		
			//alert("DOES IT GET HEREaaaaaaaaaaaaaa");
		if (document.getElementById("frButton").checked) {
			//alert("DOES IT GET HERE");
			document.getElementById("multArea").style.display = 'none';
			document.getElementById("freeArea").style.display = 'block';
		} else if(document.getElementById("mcButton").checked) {
			//alert("OR HERE");
			document.getElementById("multArea").style.display = 'block';
			document.getElementById("freeArea").style.display = 'none';
		}
	}	
}
