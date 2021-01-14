<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Mail;
use App\Jobs\ThrottledMail;


class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        // Comment::create
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        // Mail::to($post->user)->send(
        //     new CommentPostedMarkdown($comment)
        // );

        // $when = now()->addMinutes(1);

        // Mail::to($post->user)->queue(
        //     new CommentPostedMarkdown($comment)
        // );

        ThrottledMail::dispatch(new CommentPostedMarkdown($comment), $post->user);

        NotifyUsersPostWasCommented::dispatch($comment);

        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        // $request->session()->flash('status', 'Comment was created!');

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
