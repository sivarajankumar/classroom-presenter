 /* This file handles the events for Student Settings page. */
 function printToScreen(data){
	$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
	//initially puts courses on page
	getCourses("schwer@cs.washington.edu",printToScreen);
	//user joins a session
   $(".joinButton").live('click',function(event) {
		joinSession($.cookie("session"), $(this).attr('id'));
	});
   
    //user leaves a session
	$(".quitButton").live('click',function(event) { 
		exitSession($.cookie("session"), $(this).attr('id'));
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		alert($(this).attr('id'));
		//deleteCourse($.cookie("session"), $(this).attr('id'));
		//place = getCourses($.cookie("session"),printToScreen);
	});

	//user change alias name
	$("#aliasChangeButton").click(function(event){
		var alias = $("#aliasName").val();
		$.cookie("session", alias, { path: '/' });
		$("#cook").html("Hello " + alias);
	});


});



