$(document).ready(function(){
  var quill = new Quill('#reply-field', {
    theme: 'snow',
    placeholder: 'Tulis pesan ...'
  });

  $('.ql-editor').bind("DOMSubtreeModified", function(){
    $("textarea#isi_pesan").html($(this).html());
  });
});
