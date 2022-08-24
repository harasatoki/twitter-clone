(() => {
const __webpack_exports__ = {};
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
    }).fail(function (error) {
      alert("ユーザーフォローの通信に失敗しました\n通信環境、データ通信の許可設定、セキュリティの確認をしてください");
    });
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
    }).fail(function (error) {
      alert("ユーザーフォロー削除の通信に失敗しました\n通信環境、データ通信の許可設定、セキュリティの確認をしてください");
    });
  });
});
})()
;
