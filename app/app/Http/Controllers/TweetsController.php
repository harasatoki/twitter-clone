<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\Favorite;
class TweetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('valiMiddleware')->only(['store','update']);
    }
    /**
     *ツイート一覧
     *
     * @param Follower $follower
     * @param Tweet $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Tweet $tweet, Follower $follower)
    {
        $user = auth()->user();
        $followIds = $follower->followingIds($user->id);
        // followed_idだけ抜き出す
        $followingIds = $followIds->pluck('followed_id')->toArray();
        $timelines = $tweet->getTimelines($user->id, $followingIds);

        return view('tweets.index', [
            'user'      => $user,
            'timelines' => $timelines
        ]);
    }

    /**
     *ツイート作成画面
     *
     * @return \Illuminate\Http\Response
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
    public function store(Request $request,Tweet $tweet)
    {
        $user = auth()->user();
        $data = $request->all();
        $tweet->tweetStore($user->id, $data);

        return redirect('tweets');
    }

    /**
     *ツイートツリー表示
     *
     * @param 　Tweet  $tweet
     * @param  Comment  $comment
     * @param  Favorite $favorite
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet, Comment $comment,Favorite $favorite)
    {
        $user = auth()->user();
        $tweet = $tweet->getTweet($tweet->id);
        $comments = $comment->getComments($tweet->id);
        $favoriteId=$favorite->fetchFavorite($user->id,$tweet->id);

        return view('tweets.show', [
            'user'     => $user,
            'tweet' => $tweet,
            'comments' => $comments,
            'favoriteId'=>$favoriteId
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
        $tweets = $tweet->getTweetEdit($user->id, $tweet->id);

        if (!isset($tweets)) {
            return redirect('tweets');
        }

        return view('tweets.edit', [
            'user'   => $user,
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
    public function update(Tweet $tweet)
    {
        $tweet->tweetUpdate($tweet->id, $data);

        return redirect('tweets');
    }

    /**
     *ツイート削除
     *
     * @param  Tweet  $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Tweet $tweet)
    {
        $user = auth()->user();
        $tweet->tweetDestroy($user->id, $request->input('tweetId'));

        return back();
    }
}
