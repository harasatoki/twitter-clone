<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * バリデーション
     */
    public function __construct()
    {
        $this->middleware('valiMiddleware')->only(['store','update']);
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
        $data = $request->all();

        $comment->commentStore($user->id, $data);

        return back();
    }
}
