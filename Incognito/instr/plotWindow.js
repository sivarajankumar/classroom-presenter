 
 $(document).ready(function() {
 	//alert("HI");
	doTimer();
 	//alert("WTF");
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
	//alert("WTF4");
	getActivity("23456", currentTime);	//$.cookie("sid")
	//alert("WTF6");
	currentTime = currentTime+5;
	t=setTimeout("timedCount()",5000);
}

function doTimer(){
	//alert("WTF");
	if (!timer_is_on)
	  {
	 // alert("WTF2");
	  timer_is_on=1;
	  timedCount();
	  //alert("WTF3");
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
	//alert("WTF5");
	//alert(str);
	//alert(curTime);
    // get(file, data, callback, type); (only "file" is required)
    $.post(      
    "scripts/timeline.php", //Ajax file
    { id: str,
	  time: curTime	},  // create an object will all values
    //function that is called when server returns a value.
    function(data){		
		//alert(data[0]);
		//alert(data[1]);
		var temp = data[1];
		if ((data[1] - subtotal) < 0) {
			data[1] = 0;
		} else {
			data[1] = data[1] - subtotal;
		}
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