$(document).ready(function(){
  var datepicker = $('.date').find('input');

  $('.datepicker').datepicker({
    format: 'dd/mm/yyyy'
  });
  
  $(datepicker).change(function(ev){
    $(datepicker).attr('value', ev.target.value);
  });
});
