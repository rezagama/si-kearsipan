$(document).ready(function(){
  var quill = new Quill('#reply-field', {
    theme: 'snow',
    placeholder: 'Edit pesan ...',
    modules: {
      toolbar: [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['image', 'code-block'],
        [{ 'align': [] }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
      ]
    },
  });

  $('.ql-editor').html($("textarea#isi_pesan").text());

  $('.ql-editor').bind("DOMSubtreeModified", function(){
    $("textarea#isi_pesan").html($(this).html());
  });
});
