(() => {
const __webpack_exports__ = {};
jQuery(document).ready(function () {
  $('#myImage').on('change', function (e) {
    const reader = new FileReader();

    reader.onload = function (e) {
      $("#preview").attr('src', e.target.result);
    };

    reader.readAsDataURL(e.target.files[0]);
  });
});
})()
;
