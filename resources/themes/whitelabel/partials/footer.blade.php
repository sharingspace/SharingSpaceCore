<!-- JAVASCRIPT FILES -->
    
<script type="text/javascript" src="/assets/js/scripts.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
  
  $("#display_about").click(function(e){
    var about_height = '0px';

    if (!$('#about_panel').is(':visible')) {
      $("#about_panel").slideToggle('fast');
      about_height = $("#about_panel p").height()+60+'px';
    }
    else {
      $("#about_panel").slideToggle('fast');
    }

    $("#about_panel").parent().css('height', about_height);
    if ($('.wl_usercover').length) {
      $(".wl_usercover").slideToggle();
    }

    return false;
  });

  $('.close_about').on('click', function(c){
    $("#about_panel").slideToggle('fast');
    $("#about_panel").parent().css('height', 0);
    if ($('.wl_usercover').length) {
      $(".wl_usercover").slideToggle();
    }
  });
});
</script>