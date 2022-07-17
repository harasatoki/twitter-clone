<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;
class TweetsController extends Controller
{
    /**
     * バリデーション
     */
    public function __construct()
    {
        $this->middleware('validateTweetMiddleware')->only(['store','update']);
    }

    /**
     *ツイート一覧
     *
     * @param Follower $follower
     * @param Tweet $tweet
     * 
     * @return \Illuminate\View\View
     */
    public function index(Tweet $tweet, Follower $follower)
    {
        $user = auth()->user();
        $followIds = $follower->fetchFollowedIds($user->id);
        $followedIds = $followIds->pluck('followed_id')->toArray();
        $timelines = $tweet->fetchTimelines($user->id, $followedIds);

        return view('tweets.index', [
            'user' => $user,
            'timelines' => $timelines
        ]);
    }

    /**
     *ツイート作成画面
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = auth()->user();

        return view('tweets.create', [
            'user' => $user
        ]);
    }

    /**
     *ツイート内容の保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tweet $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tweet $tweet)
    {
        $userId = auth()->id();
        $tweetData = $request->all();
        $tweet->storeTweet($userId, $tweetData);

        return redirect('tweets');
    }

    /**
     *ツイートツリー表示
     *
     * @param 　Tweet  $tweet
     * @param  Comment  $comment
     * 
     * @return \Illuminate\View\View
     */
    public function show(Tweet $tweet, Comment $comment)
    {
        $user = auth()->user();
        $tweet = $tweet->fetchTweet($tweet->id);
        $comments = $comment->fetchComments($tweet->id);

        return view('tweets.show', [
            'user' => $user,
            'tweet' => $tweet,
            'comments' => $comments,
        ]);
    }

    /**
     *ツイート編集画面
     *
     * @param  Tweet  $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        $user = auth()->user();
        $tweets = $tweet->fetchTweetEdit($user->id, $tweet->id);

        if ( !isset($tweets) ) {
            return redirect('tweets');
        }

        return view('tweets.edit', [
            'user' => $user,
            'tweets' => $tweets
        ]);
    }

    /**
     *編集の適用
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tweet  $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Tweet $tweet, Request $request)
    {
        $tweetData = $request->all();
        $tweet->updateTweet($tweet->id, $tweetData);

        return redirect('tweets');
    }

    /**
     *ツイート削除
     *
     * @param  Tweet  $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tweet $tweet)
    {
        $userId = auth()->id();
        $tweet->destroyTweet($userId, $request->input('tweetId'));

        return redirect('tweets');
    }
}
