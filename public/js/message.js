$("#message_bar").click(function(){
  $(this).slideToggle("normal", "easeInOutBack");
});
$(this).slideToggle("normal", "easeInOutBack", function(){
  $("#message_bar").slideToggle("normal", "easeInOutBack");
});