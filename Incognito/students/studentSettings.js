 /* This file handles the events for Student Settings page. */
 function printToScreen(data){
	$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
	var alias; 	
	//initially puts courses on page
	getCourses($.cookie("netid"),printToScreen);
	//user joins a session
   $(".joinButton").live('click',function(event) {
		joinSession($.cookie("netid"), $(this).attr('id'));
	});
   
    //user leaves a session
	$(".quitButton").live('click',function(event) { 
		exitSession($.cookie("netid"), $(this).attr('id'));
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		removeCourse($.cookie("netid"), $(this).attr('id'));
		getCourses($.cookie("netid"),printToScreen);
	});

	//user change alias name, studentID, newAlias
	$("#aliasChangeButton").click(function(event){
		alias = $("#aliasName").val();
		$.cookie("alias", alias, { path: '/' });
		$("#cook").html("Hello " + alias);
		addAlias($.cookie("netid"), alias);
	});


});



