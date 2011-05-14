function getFeed(sid, filter, sort, callback) {
  // Make the HTTP request
  $.post("../../DB/lookup_questions.php",
    {sid: sid, filter: filter, sort: sort, callback: callback},
    function(data) {
      callback(data);
    });
}