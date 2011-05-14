 $(document).ready(function() {
	var place;
	alert("Please print");  
	getCourses(cookieSession_uwid, function(data) {
		place = data;
		alert(data); 
		$("#courseInfo").html(place);
	});
	
	
   $(".joinButton").live('click',function(event) {
		joinSession(cookieSession_uwid, $(this).attr('id'));
	});
   
	$(".quitButton").live('click',function(event) { 
		exitSession(cookieSession_uwid, $(this).attr('id'));
	});
	
	$(".courseRemoveButton").live('click',function(event) {
		deleteCourse(cookieSession_uwid, $(this).attr('id'));
		getCourses(cookieSession_uwid, function(data) {
			place = data;
			$("#courseInfo").html(place); 
		});
		
	});

});
 
 
 
 
 



