function getFeed(sid, uid, filter, sort)
{
	var data;
	$.ajax({
		type: "POST",
		url: "../../DB/lookup_questions.php",
		data: "sid="+sid+"&filter=none&sort=none",
		success: function(msg){
			data = new Array();
			for (var i = 0; i < msg.length; i++)
			{
				data[i] = new Array();
				data[i][0] = msg[i].votes;
				data[i][1] = msg[i].text;
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