<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * バリデーション
     */
    public function __construct()
    {
        $this->middleware('valiCommentMiddleware')->only(['store']);
    }

    /**
     * コメント内容の保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Comment $comment
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comment $comment)
    {
        $user = auth()->user();
        $commentData = $request->all();
        $comment->commentStore($user->id, $commentData);

        return back();
    }
}
