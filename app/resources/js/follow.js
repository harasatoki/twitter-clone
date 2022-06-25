const { data } = require("jquery");

jQuery(document).ready(function () {
    $('.follow').on('click',function(){
        console.log("follow");
        let $this=$(this)
        userId=$this.data('id')
        $.ajax({
            type: "post", //HTTP通信の種類
            url:'/users/follow', //通信したいURL
            dataType: 'json',
            data:{"id":userId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
        .done((res)=>{
            console.log("follow success")
            document.getElementById('follow-'+userId).style.display = 'none'
            document.getElementById('unfollow-'+userId).style.display = 'inline'
        })
        .fail((error)=>{
            console.log(error.statusText)
        })
    });
    $('.unfollow').on('click',function(){
        console.log("delete")
        let $this=$(this)
        userId=$this.data('id')
        $.ajax({
            type: "post", //HTTP通信の種類
            url:'/users/unfollow', //通信したいURL
            dataType: 'json',
            data:{'id':userId,
            '_method': 'DELETE'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
        .done((res)=>{
            console.log("delete saccess")
            document.getElementById('follow-'+userId).style.display = 'inline'
            document.getElementById('unfollow-'+userId).style.display = 'none'
        })
        .fail((error)=>{
            console.log(error.statusText)
        })
    });
});
