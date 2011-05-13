 $(document).ready(function() { 
	$('<p class=\"removeAll\">3</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 1</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	$('<p class=\"removeAll\">1</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 2</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	$('<p class=\"removeAll\">4</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 3</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	
   $("#priority").click(function() {
	$(".removeAll").detach();
	$('<p class=\"removeAll\">4</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 3</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	$('<p class=\"removeAll\">3</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 1</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	$('<p class=\"removeAll\">1</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 2</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	});
	
	$("#newest").click(function() {
	$(".removeAll").detach();
	$('<p class=\"removeAll\">3</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 1</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	$('<p class=\"removeAll\">1</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 2</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	$('<p class=\"removeAll\">4</p>').appendTo('#viewVotesCol');
	$('<p class=\"removeAll\">Question 3</p>').appendTo('#feedCol');
	$('<p class=\"removeAll\"><input type=\"checkbox\" /></p>').appendTo('#answerCol');
	});
});
