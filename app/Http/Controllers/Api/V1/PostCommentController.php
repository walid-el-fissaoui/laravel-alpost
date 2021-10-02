<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Events\CommentPosted as EventsCommentPosted;

class PostCommentController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post , Request $request)
    {
        $perPage = $request->input('per_page') ?? null ; 
        return CommentResource::collection($post->comments()->with('user')->paginate($perPage)->appends([
            'per_page' => $perPage
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post ,Request $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id
        ]);

        event(new EventsCommentPosted($comment));
        
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post , Comment $comment)
    {
        return new CommentResource($comment);
        // return response()->json(['commments' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post , Comment $comment)
    {
        $comment->content = $request->content;
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post , Comment $comment)
    {
        $comment->delete();

        return response()->noContent();
    }
}
