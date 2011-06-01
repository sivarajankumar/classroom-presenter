function printToScreen(data){
    $("#feed").html(data);
}

// Function called to create a survey after
// onclick event of create button
function onSurvey() {
    $sid = $.cookie('sid');

    if($sid) {
    
        // Get the question from the form
        var qtext = $('#questiontext').val();
        
        // Iterate through all of the options and create
        // a json array string from them
        var options = new Array();
        var i = 0;
        
        // * is in case we need to id the options
        $("input[id*='option']").each( function() {
            options[i] = $(this).val();
            i += 1;
        });
        
        // create a string from an array in JSON format
        var json_options = JSON.stringify(options);

        // Make the call to the backend to add the MC survey
        createMC($sid, qtext, printToScreen, json_options);
        
    } else {
        alert("Must open a session to create a Multiple Choice. \nHint: \n    What class are you currently teaching? \n    Open the class session in the settings page!");
    }
    
};

$("#timeline").live('click', function(event){
	mypopup();
});
