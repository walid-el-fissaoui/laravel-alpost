<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted as EventsCommentPosted;
use App\Models\Post;
use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResource;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentedPostMarkDown;
use App\Mail\CommentPosted;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function show(Post $post)
    {
        // return new CommentResource($post->comments->first());
        // return new CommentResource($post);
        // return CommentResource::collection($post->comments); /** this is the lazy loading  */
        return CommentResource::collection($post->comments()->with('user')->get()); /** this is the eager loading  */
    }

    public function store(StoreComment $request ,  Post $post)
    {
        /** automaticaly find the post with $id passed */

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id
        ]);

        // Mail::to($post->user->email)->send(new CommentedPostMarkDown($comment));
        event(new EventsCommentPosted($comment));
        // $delay = now()->addMinutes(1);
        // Mail::to($post->user->email)->later($delay,new CommentedPostMarkDown($comment));

        return redirect()->back();
    }
}
