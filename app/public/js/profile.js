(() => {
var __webpack_exports__ = {};
jQuery(document).ready(function () {
  $('#myImage').on('change', function (e) {
    console.log("Aaaaaa");
    var reader = new FileReader();

    reader.onload = function (e) {
      console.log("sdhgfalijd");
      $("#preview").attr('src', e.target.result);
    };

    reader.readAsDataURL(e.target.files[0]);
  });
});
})()
;
