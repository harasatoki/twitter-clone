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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getComments(Int $tweetId)
    {
        return $this->with('user')->where('tweet_id', $tweetId)->get();
    }
    public function commentStore(Int $userId, Array $data)
    {
        $this->user_id = $userId;
        $this->tweet_id = $data['tweet_id'];
        $this->text = $data['text'];
        $this->save();
        return;
    }

}
