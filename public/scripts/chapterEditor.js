tinymce.init({
  selector: "#chapterContent",
  language: "fr_FR",
  height: 800,
  plugins: [
    "advlist autolink link image lists charmap preview hr",
    "searchreplace visualchars fullscreen media",
    "save table directionality paste"
  ],
  content_css: "css/content.css",
  toolbar:
    "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link image media | preview ",
  statusbar: false
});

tinymce.init({
  selector: "#chapterExcerpt",
  language: "fr_FR",
  height: 200,
  menubar: false,
  toolbar:
    "undo redo | bold italic | alignleft aligncenter | forecolor backcolor",
  statusbar: false
});

document.addEventListener("DOMContentLoaded", function() {
  let actionbtnElems = document.querySelectorAll(".fixed-action-btn");
  let actionbtnInstances = M.FloatingActionButton.init(actionbtnElems, {
    hoverEnabled: false
  });
});
