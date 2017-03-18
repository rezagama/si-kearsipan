$(document).ready(function(){
  var quill = new Quill('#reply-field', {
    theme: 'snow',
    placeholder: 'Edit pesan ...'
  });

  $('.ql-editor').html($("textarea#isi_pesan").text());

  $('.ql-editor').bind("DOMSubtreeModified", function(){
    $("textarea#isi_pesan").html($(this).html());
  });
});
