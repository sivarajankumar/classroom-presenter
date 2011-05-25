 /* This file handles the events for Student Settings page. */
 function printToScreen(data){
	$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
	var alias;
    var cookie = readCookie('uid');
    if(cookie != null) {
    
        //initially puts courses on page
        getCourses(333, printToScreen);
        //user joins a session
        $(".joinButton").live('click',function(event) {
            joinSession(333, $(this).attr('id'));
            getCourses(333,printToScreen);
            
            // Set a cookie to reflect the session the student just joined
            $.cookie("sid",$(this).attr('id'));
        });
       
        //user leaves a session
        $(".quitButton").live('click',function(event) { 
            exitSession(333, $(this).attr('id'));
            getCourses(333,printToScreen);
            
            // Delete the 333 corresponding to session the student is in
            $.cookie("course", null);
        });
        
        //user deletes a course
        $(".courseRemoveButton").live('click',function(event) {
            removeCourse(333, $(this).attr('id'));
            getCourses(333,printToScreen);
        });

        //user change alias name, studentID, newAlias
        $("#aliasChangeButton").click(function(event){
            alias = $("#aliasName").val();
            $.cookie("alias", alias, { path: '/' });
            $("#cook").html("Hello " + alias);
            addAlias(333, alias);
        });

    }
});


// Having problems reading in cookies using JQuery
// Fix using Javascript
function readCookie(name) {  
  
    var cookiename = name + "=";  
    var ca = document.cookie.split(';');  
    for(var i=0;i < ca.length;i++)  
    {
        var c = ca[i];  
        while (c.charAt(0)==' ') c = c.substring(1,c.length);  
        if (c.indexOf(cookiename) == 0) return c.substring(cookiename.length,c.length);  
    }
    return null;
    
}  
