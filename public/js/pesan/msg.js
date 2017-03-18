$(document).ready(function(){
  var quill = new Quill('#reply-field', {
    theme: 'snow',
    placeholder: 'Balas pesan ...'
  });

  $('.ql-editor').bind("DOMSubtreeModified", function(){
    $("textarea#balasan").html($(this).html());
  });
});
