 $(document).ready(function() {
   $("#joinCourseButton").click(function() {
	 $('<p>Test</p>').appendTo('#courseInfo');
	});
   
	$("#courseSubmitButton").click(function(e) { 
	var test = $("input#courseName").val();
	$("<p class=\"" + test +"\">" + $("input#courseName").val() + "<button id=\"" + test + "\" type=\"submit\" class=\"courseRemoveButton\">X</button>" + "<button id=\"" + test + "\" class=\"updateClassButton\" type=\"submit\">Update Student Members</button>  </p>").appendTo('#courseInfo');
	});
	
$(".courseRemoveButton").live('click',function(event) {
	var removeThis = $(this).attr('id');
	$("." + removeThis).detach();
});

$(".updateClassButton").live('click',function(event) {
	alert("Class members updated!");
});

});
 
 
 
 
 



