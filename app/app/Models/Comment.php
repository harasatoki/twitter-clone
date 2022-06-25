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
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメント取得
     *
     * @param int $tweetId
     * 
     * @return array
     */
    public function fetchComments(int $tweetId)
    {
        return $this->with('user')->where('tweet_id', $tweetId)->get();
    }

    /**
     * コメント保存
     *
     * @param int $userId
     * @param array $data
     * 
     * @return void
     */
    public function commentStore(int $userId, array $commentData) : void
    {
        $this->user_id = $userId;
        $this->tweet_id = $commentData['tweet_id'];
        $this->text = $commentData['text'];
        $this->save();
    }
}
