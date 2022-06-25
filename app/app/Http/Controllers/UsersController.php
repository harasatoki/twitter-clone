<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * ユーザー一覧
     * 
     *@param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $users = $user->getAllUsers(auth()->user()->id);

        return view('users.index', [
            'users'  => $users
        ]);
    }
    // フォロー
    /**
     * フォロー機能
     *
     * @param Request $request
     * @return void
     */
    public function follow(Request $request)
    {
        $follower = auth()->user();
        
        // フォローしているか
        $isFollowing = $follower->isFollowing($request->input('id'));

        if(!$isFollowing) {
            // フォローしていなければフォローする
            $follower->follow($request->input('id'));
        }

        return response()->json();
    }

    // フォロー解除
    /**
     * unfolow機能
     *
     * @param Request $request
     * @return void
     */
    public function unfollow(Request $request)
    {
        $follower = auth()->user();
        // フォローしているか
        $isFollowing = $follower->isFollowing($request->input('id'));

        if($isFollowing) {
            // フォローしていればフォローを解除する
            $follower->unfollow($request->input('id'));
        }
        return response()->json();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * ユーザー詳細
     *
     * @param  User $user
     * @param Tweet $tweet
     * @param Follower $follower
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user,Tweet $tweet, Follower $follower)
    {
        $loginUser = auth()->user();
        $isFollowing = $loginUser->isFollowing($user->id);
        $isFollowed = $loginUser->isFollowed($user->id);

        $timelines = $tweet->getUserTimeLine($user->id);
        $tweetCount = $tweet->getTweetCount($user->id);
        $followCount = $follower->getFollowCount($user->id);
        $followerCount = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'loginUser'  =>$loginUser,
            'user'           => $user,
            'isFollowing'   => $isFollowing,
            'isFollowed'    => $isFollowed,
            'timelines'      => $timelines,
            'tweetCount'    => $tweetCount,
            'followCount'   => $followCount,
            'followerCount' => $followerCount
        ]);
    }

    /**
     * ユーザー編集
     *
     * @param  User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
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
        $data = $request->all();
        $validator = Validator::make($data, [
            'screenName'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'name'          => ['required', 'string', 'max:255'],
            'profileImage' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        $user->updateProfile($data);

        return redirect('users/'.$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
