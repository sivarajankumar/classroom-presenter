 var data1 = []; 
 var options = {
        lines: { show: true },
        points: { show: true },
        xaxis: { tickDecimals: 0, tickSize: 5 }
    };


	
var c=1;
var t;
var currentTime = 0;
var timer_is_on=0;

function timedCount(){
	sendToGetValue(c, currentTime);
	c=c+1;
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
	alert("got her");
	clearTimeout(t);
	timer_is_on=0;
}

$("#test1").live('click', function(event){
	doTimer();
});

$("#test2").live('click', function(event){
	stopCount();
});

// Function to handle ajax.
function sendToGetValue(str, curTime){
    // get(file, data, callback, type); (only "file" is required)
    $.get(      
    "testingajax.php", //Ajax file
    { id: str,
	  time: curTime	},  // create an object will all values
    //function that is called when server returns a value.
    function(data){	
		data1.push(data);
		var plotarea = $("#graphPage");  
		plotarea.css("height", "250px");  
		plotarea.css("width", "250px");  
		$.plot( plotarea , data1, options );	
		//var obj = jQuery.parseJSON(data);
		//alert(obj.name
    },
    //How you want the data formated when it is returned from the server.
    "json"
    );   
}

// Function to handle ajax.
function sendValue(str){
    // get(file, data, callback, type); (only "file" is required)
    $.get(      
    "testingajax.php", //Ajax file
    { d: str },  // create an object will all values
    //function that is called when server returns a value.
    function(data){
        $('#placeHere2').html(data);
    },
    //How you want the data formated when it is returned from the server.
    "html"
    );   
}