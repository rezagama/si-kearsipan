$(document).ready(function(){
  $(".input-group #nama").on("input", function(ev){
    $(".update #kategori").attr('value', ev.target.value);
  });
});
