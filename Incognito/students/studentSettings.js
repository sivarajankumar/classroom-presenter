 /* This file handles the events for Student Settings page. */
 function printToScreen(data){
	$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
    var alias;
    $uid = $.cookie('uid');
    if($uid != null) {
    
        //initially puts courses on page
        getCourses($uid, printToScreen);
        //user joins a session
        $(".joinButton").live('click',function(event) {
            joinSession($uid, $(this).attr('id'));
            getCourses($uid,printToScreen);
            
            // Set a cookie to reflect the session the student just joined
            $.cookie("sid",$(this).attr('id'),{expires: 1, path: '/'});
        });
       
        //user leaves a session
        $(".quitButton").live('click',function(event) { 
            exitSession($uid, $(this).attr('id'));
            getCourses($uid, printToScreen);
            
            // Delete the 333 corresponding to session the student is in
            $.cookie("sid", "", {expires: -1, path: '/'});
        });
        
        //user deletes a course
        $(".courseRemoveButton").live('click',function(event) {
            removeCourse($uid, $(this).attr('id'));
            getCourses($uid, printToScreen);
        });

        //user change alias name, studentID, newAlias
        $("#aliasChangeButton").click(function(event){
            alias = $("#aliasName").val();
            $.cookie("alias", alias, { expires: 1, path: '/' });
            $("#cook").html("Hello " + alias);
            addAlias($uid, alias);
        });

    }
});

setInterval("refreshFeed()", 1000); // refresh every 1000 milliseconds

function refreshFeed() {
    $uid = $.cookie('uid');
    if($uid != null) {
        getCourses($uid, printToScreen);
    }
}
