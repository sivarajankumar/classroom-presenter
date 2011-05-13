  $(document).ready(function(){
    $('#txtValue').keyup(function(){
      sendValue($(this).val());
    }); 
  });
  
  function sendValue(str){
    $.post("ajax.php",{ sendValue: str },
    function(data){
      $('#display').html(data.returnValue);
    }, "json");
  }