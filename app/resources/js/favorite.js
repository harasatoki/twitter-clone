jQuery(document).ready(function () {
    $('.favorite').on('click',function(){
        let $this=$(this)
        tweetId=$this.data('tweetid')
        $.ajax({
            type: "post", 
            url:'/favorites/store', 
            dataType: 'json',
            data:{
                "tweet_id":tweetId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
        .done((res)=>{
            document.getElementById('favorite-'+tweetId).style.display = 'none'
            document.getElementById('unfavorite-'+tweetId).style.display = 'inline'
            document.getElementById('favorite-count-'+tweetId).innerHTML =res['countFavorite']
        })
        .fail((error)=>{
            alert("ツイートのいいね機能の通信に失敗しました\n通信環境、データ通信の許可設定、セキュリティの確認をしてください")
        })
    });
    $('.unfavorite').on('click',function(){
        let $this=$(this)
        tweetId=$this.data('tweetid')
        $.ajax({
            type: "delete", 
            url:'/favorites/destroy', 
            dataType: 'json',
            data:{
                'tweet_id':tweetId,
                '_method': 'DELETE'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
        .done((res)=>{
            document.getElementById('favorite-'+tweetId).style.display = 'inline'
            document.getElementById('unfavorite-'+tweetId).style.display = 'none'
            document.getElementById('favorite-count-'+tweetId).innerHTML = res['countFavorite']
        })
        .fail((error)=>{
            alert("ツイートのいいね機能削除の通信に失敗しました\n通信環境、データ通信の許可設定、セキュリティの確認をしてください")
        })
    });
});
