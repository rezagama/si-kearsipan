$(document).ready(function(){
  var quill = new Quill('#reply-field', {
    theme: 'snow',
    placeholder: 'Balas pesan ...',
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

  $('.ql-editor').bind("DOMSubtreeModified", function(){
    $("textarea#balasan").html($(this).html());
  });
});
