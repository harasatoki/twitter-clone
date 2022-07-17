<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * バリデーション
     */
    public function __construct()
    {
        $this->middleware('validateUserMiddleware')->only( ['update'] );
    }

    /**
     * ユーザー一覧
     * 
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function index(User $user)
    {
        $users = $user->fetchAllUsers(auth()->id());

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * フォロー一覧
     * 
     * @param User $user
     * @param Follower $follower
     * 
     * @return \Illuminate\View\View
     */
    public function following(User $user, Follower $follower)
    {
        $followingIds = $follower->fetchfollowingIds($user->id);
        $followingUsers=collect([]);
        foreach($followingIds as $followingId){
            $followingUsers=$followingUsers->concat([$user->fetchUser($followingId->followed_id)]);
        };
        
        return view('users.following',[
            'followingUsers' => $followingUsers,
            'user' => $user
        ]);
    }

    /**
     * フォロワー一覧
     * 
     * @param User $user
     * @param Follower $follower
     * 
     * @return \Illuminate\View\View
     */
    public function follower(User $user, Follower $follower)
    {
        $followerIds = $follower->fetchfollowerIds($user->id);
        $followerUsers=collect([]);
        foreach($followerIds as $followerId){
            $followerUsers=$followerUsers->concat([$user->fetchUser($followerId->following_id)]);
        };
        
        return view('users.follower',[
            'followerUsers' => $followerUsers,
            'user' => $user
        ]);
    }

    /**
     * フォロー機能
     *
     * @param Request $request
     * @param Follower $follower
     * 
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request, Follower $follower)
    {
        $loginUser = auth()->user();
        $isFollowing = $loginUser->isFollowing( $request->input('userId') );

        if(!$isFollowing) {
            $loginUser->follow( $request->input('userId') );
        }

        $followerCount = $follower->fetchFollowerCount($request->input('userId'));

        return response()->json(['followerCount'=>$followerCount]);
    }

    /**
     * unfolow機能
     *
     * @param Request $request
     * @param Follower $follower
     * 
     * @return \Illuminate\Http\Response
     */
    public function unfollow(Request $request, Follower $follower)
    {
        $loginUser = auth()->user();
        $isFollowing = $loginUser->isFollowing( $request->input('userId') );

        if( $isFollowing ) {
            $loginUser->unfollow( $request->input('userId') );
        }

        $followerCount = $follower->fetchFollowerCount($request->input('userId'));

        return response()->json(['followerCount'=>$followerCount]);
    }

    /**
     * ユーザー詳細
     *
     * @param  User $user
     * @param Tweet $tweet
     * @param Follower $follower
     * 
     * @return \Illuminate\View\View
     */
    public function show(User $user, Tweet $tweet, Follower $follower)
    {
        $loginUser = auth()->user();
        $isFollowing = $loginUser->isFollowing($user->id);
        $isFollowed = $loginUser->isFollowed($user->id);

        $timelines = $tweet->fetchUserTimeLine($user->id);
        $tweetCount = $tweet->fetchTweetCount($user->id);
        $followCount = $follower->fetchFollowCount($user->id);
        $followerCount = $follower->fetchFollowerCount($user->id);

        return view('users.show', [
            'loginUser'  =>$loginUser,
            'user' => $user,
            'isFollowing' => $isFollowing,
            'isFollowed' => $isFollowed,
            'timelines' => $timelines,
            'tweetCount' => $tweetCount,
            'followCount' => $followCount,
            'followerCount' => $followerCount
        ]);
    }

    /**
     * ユーザー編集
     *
     * @param  User $user
     * 
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        if($user->id == auth()->id()){
            return view('users.edit', ['user' => $user]);
        }else{
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $userData = $request->all();
        $user->updateProfile( $userData );

        return redirect( 'users/'.$user->id );
    }
}
