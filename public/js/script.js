$(document).ready(function(){
  $("#menu-toggle").click(function(e) {
       e.preventDefault();
       $("#wrapper").toggleClass("active");
   });

   function getUrlParameter() {
     var lastIdx = document.URL.lastIndexOf('/') + 1;
     var selectedMenu = document.URL.substr(lastIdx);
     return selectedMenu;
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

   console.log(getUrlParameter());
   setActiveMenu(getUrlParameter());


});
