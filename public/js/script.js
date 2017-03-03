$(document).ready(function(){
  $("#menu-toggle").click(function(e) {
       e.preventDefault();
       $("#wrapper").toggleClass("active");
   });

   function getUrlParameter(sParam) {
      var sPageURL = decodeURIComponent(window.location.search.substring(1)),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : sParameterName[1];
          }
      }
   }

   function setActiveMenu(selectedMenu){
     var phrases = [];

     $('.main-menu').each(function(){
         var phrase = '';
         $(this).find('li').each(function(){
             var current = $(this);

             current.removeClass('active');
             if(current.attr('id') == selectedMenu){
               current.addClass('active');
             }

             if(current.children().size() > 0) {return true;}
         });
     });
   }
   // note the comma to separate multiple phrases
   console.log(getUrlParameter('page'));
   setActiveMenu(getUrlParameter('page'));

   
});
