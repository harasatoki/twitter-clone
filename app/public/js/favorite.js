(() => {
var __webpack_exports__ = {};
jQuery(document).ready(function () {
  $('.favorite').on('click', function () {
    var $this = $(this);
    tweetId = $this.data('tweetid');
    $.ajax({
      type: "post",
      url: '/favorites/store',
      dataType: 'json',
      data: {
        "tweet_id": tweetId
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function (res) {
      document.getElementById('favorite-' + tweetId).style.display = 'none';
      document.getElementById('unfavorite-' + tweetId).style.display = 'inline';
      document.getElementById('favorite-count-' + tweetId).innerHTML = res['countFavorite'];
    }).fail(function (error) {
      alert("通信に失敗しました");
    });
  });
  $('.unfavorite').on('click', function () {
    var $this = $(this);
    tweetId = $this.data('tweetid');
    $.ajax({
      type: "delete",
      url: '/favorites/destroy',
      dataType: 'json',
      data: {
        'tweet_id': tweetId,
        '_method': 'DELETE'
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }).done(function (res) {
      document.getElementById('favorite-' + tweetId).style.display = 'inline';
      document.getElementById('unfavorite-' + tweetId).style.display = 'none';
      document.getElementById('favorite-count-' + tweetId).innerHTML = res['countFavorite'];
    }).fail(function (error) {
      alert("通信に失敗しました");
    });
  });
});
})()
;
