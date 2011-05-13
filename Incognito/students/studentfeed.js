function getFeed(sid)
{
	var data;
	$.ajax({
		type: "POST",
		url: "../../DB/lookup_questions.php",
		data: "sid="+sid,
		success: function(msg){
			data = new Array();
			for (var i = 0; i < msg.length; i++)
			{
				data[i] = new Array();
				data[i][0] = msg[i].text;
				data[i][1] = msg[i].votes;
				if (msg[i].type == 'Q')
				{
					data[i][2] = msg[i].answered;
				}
				else if (msg[i].type == 'F')
				{
					data[i][2] = msg[i].isread;
				}
				data[i][3] = msg[i].type;
			}
		}
	});
	return data;
}