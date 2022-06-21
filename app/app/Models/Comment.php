<?php

namespace App\Models;

use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    /**
     * ユーザーリレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメント取得
     *
     * @param Int $tweetId
     * @return void
     */
    public function fetchComments(Int $tweetId)
    {
        return $this->with('user')->where('tweet_id', $tweetId)->get();
    }

    /**
     * コメント保存
     *
     * @param Int $userId
     * @param Array $data
     * @return void
     */
    public function commentStore(Int $userId, Array $commentData)
    {
        $this->user_id = $userId;
        $this->tweet_id = $commentData['tweet_id'];
        $this->text = $commentData['text'];
        $this->save();
        return;
    }
}
