 
 $(document).ready(function() {
	doTimer();
});

 var feedPoints = []; //keeps track of all [x,y] points
 var options = {
        lines: { show: true },
        points: { show: true },
        xaxis: { tickDecimals: 0, tickSize: 5 }
    };
	
var subtotal = 0;
var t; //timer
var currentTime = 0; //used to keep track of where to plot on x-axis
var timer_is_on=0;

function timedCount(){
	getActivity(subtotal, currentTime);
	currentTime = currentTime+5;
	t=setTimeout("timedCount()",5000);
}

function doTimer(){
	if (!timer_is_on)
	  {
	  timer_is_on=1;
	  timedCount();
	  }
}

function stopCount(){
	//alert(subtotal);
	clearTimeout(t);
	timer_is_on=0;
}

/*$("#test1").live('click', function(event){
	doTimer();
});

$("#test2").live('click', function(event){
	stopCount();
});*/

// Function to handle ajax.
function getActivity(str, curTime){
    // get(file, data, callback, type); (only "file" is required)
    $.get(      
    "testingajax.php", //Ajax file
    { id: str,
	  time: curTime	},  // create an object will all values
    //function that is called when server returns a value.
    function(data){	
		
		var temp = data[1];
		data[1] = data[1] - subtotal;
		subtotal = temp;
		//alert(subtotal);
		feedPoints.push(data);
		var plotarea = $("#graphPage");  
		plotarea.css("height", "250px");  
		plotarea.css("width", "250px");  
		$.plot( plotarea , [feedPoints], options );	
		//var obj = jQuery.parseJSON(data);
		//alert(obj.name
    },
    //How you want the data formated when it is returned from the server.
    "json"
    );   
}