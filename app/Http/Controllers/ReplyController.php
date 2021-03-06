<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use \App\Models\Reply;
use \App\Events\NewReply;

class ReplyController extends Controller
{
    public function show($id)
    {
        $replies = \App\Models\Reply::where('thread_id', $id)
            ->with('user')
            ->get();
        return $replies;
        // return response()->json($replies);
    }

    public function store(ReplyRequest $request)
    {
        $reply = new Reply;
        $reply->body = $request->input('body');
        $reply->thread_id = $request->input('thread_id');
        $reply->user_id = \Auth::user()->id;
        $reply->save();

        broadcast(new NewReply($reply));

        return response()->json($reply);
    }
}
