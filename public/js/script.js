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
     removeSelectedMenu();
     switch (selectedMenu) {
       case 'admin':
         $('#akun').addClass('active');
         break;
       default:
         $('#dashboard').addClass('active');
         break;
     }
   }

   function removeSelectedMenu(){
     $('.main-menu').each(function(){
         $(this).find('li').each(function(){
             var current = $(this);
             current.removeClass('active');
             if(current.children().size() > 0) {return true;}
         });
     });
   }

   $(':file').on('fileselect', function(event, numFiles, label) {
       var input = $(this).parents('.input-group').find(':text'),
           log = numFiles > 1 ? numFiles + ' files selected' : label;
       if( input.length ) {
           input.val(log);
       } else {
           if( log ) alert(log);
       }

   });

   $(":file").change(function(){
     readURL(this);
   });

   $(document).on('change', ':file', function() {
     initFileInputListener();
   });

   function initFileInputListener(){
     var input = $(':file'),
         numFiles = input.get(0).files ? input.get(0).files.length : 1,
         label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

     input.trigger('fileselect', [numFiles, label]);
   }

   function readURL(input) {
       var types =  ['jpg', 'jpeg', 'png'];
       if (input.files && input.files[0]) {
         var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
             isValid = types.indexOf(extension) > -1;  //is extension in acceptable types

        if (isValid) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
       }
   }

   setActiveMenu(getUrlParameter());
});
