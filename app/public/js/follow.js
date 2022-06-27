(() => { 
var __webpack_exports__ = {};
jQuery(document).ready(function () {
  $('.follow').on('click', function () {
    var $this = $(this);
    userId = $this.data('id');
    $.ajax({
      type: "post",
      url: '/users/follow',
      dataType: 'json',
      data: {
        "userId": userId
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function (res) {
      document.getElementById('follow-' + userId).style.display = 'none';
      document.getElementById('unfollow-' + userId).style.display = 'inline';

      if (document.getElementById('followerCount') != null) {
        document.getElementById('followerCount').innerHTML = res['followerCount'];
      }
    }).fail(function (error) {});
  });
  $('.unfollow').on('click', function () {
    var $this = $(this);
    userId = $this.data('id');
    $.ajax({
      type: "delete",
      url: '/users/unfollow',
      dataType: 'json',
      data: {
        'userId': userId,
        '_method': 'DELETE'
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function (res) {
      document.getElementById('follow-' + userId).style.display = 'inline';
      document.getElementById('unfollow-' + userId).style.display = 'none';

      if (document.getElementById('followerCount') != null) {
        document.getElementById('followerCount').innerHTML = res['followerCount'];
      }
    }).fail(function (error) {});
  });
});
})()
;
