
<p>
    someone has commented your post <a href="{{route('posts.show',['post'=>$comment->commentable->id])}}">{{ $comment->commentable->title}}</a>
</p>

<p>
    <a href="{{route('users.show',['user' => $comment->user->id])}}">{{$comment->user->name}}</a>, said :
</p>

<p>
    {{$comment->content}}
</p>