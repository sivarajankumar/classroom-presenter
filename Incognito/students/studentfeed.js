// Makes the call to the backend to retrieve feed data
function getFeed(sid, username, filter, sort, callback) {
  // Make the HTTP request
  $.post("../../DB/studentfeed_lookup_questions.php",
    {sid: sid, username: username, filter: filter, sort: sort, callback: callback},
    function(data) {
      callback(data);
    });
}
