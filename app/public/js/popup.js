/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/popup.js ***!
  \*******************************/
jQuery(document).ready(function () {
  $('.modal_pop').hide();
  $('.show_pop').on('click', function () {
    $('.modal_pop').fadeIn();
  });
  $('.js-modal-close').on('click', function () {
    $('.modal_pop').fadeOut();
  });
});
/******/ })()
;
