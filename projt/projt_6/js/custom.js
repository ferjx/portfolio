

// MASKED INPUT PLUGIN index
jQuery(function() {
   $(".phone").mask("+999 99 999-99-99");
});


// Slider - JS
function setSlider(n){
  var pos = {1: 0, 2: 17, 3: 50, 4: 100};
  $("#slider").slider("value", pos[n]);
}

// Slider - JS
$( function() {
  $( "#slider" ).slider({
    animate: true,
    stop: function(event, ui){
      if( ui.value > 75 ) ui.value = 100;
      else
      if( ui.value <= 75 && ui.value > 33 ) ui.value = 50;
      else
      if( ui.value <= 33 && ui.value > 8 ) ui.value = 17;
      else
      if( ui.value <= 8 ) ui.value = 0;
      
      setTimeout(function(){
        $("#slider").slider("value", ui.value);
      }, 0);
      return false;
    }
  });
  
  setSlider(2);

});


// Textarea
$( function() {

  jQuery('textarea').autoResize({
    extraSpace: 100
  });
  
});
