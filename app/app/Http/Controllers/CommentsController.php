<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\ValidateComment;

class CommentsController extends Controller
{
    /**
     * コメント内容の保存
     *
     * @param App\Http\Requests\ValidateComment  $request
     * @param Comment $comment
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateComment $request, Comment $comment)
    {
        $userId = auth()->id();
        $commentData = $request->all();
        $comment->commentStore($userId, $commentData);

        return back();
    }
}
