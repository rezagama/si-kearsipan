$(document).ready(function(){
  var quill = new Quill('#reply-field', {
    theme: 'snow',
    placeholder: 'Edit pengumuman ...',
    modules: {
      toolbar: [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['image', 'code-block'],
        [{ 'align': [] }],
      ]
    },
  });

  $('.ql-editor').html($("textarea#isi").text());

  $('.ql-editor').bind("DOMSubtreeModified", function(){
    $("textarea#isi").html($(this).html());
  });
});
