@component('mail::message')
# alPost

### {{$comment->user->name}}  commented your post 

[alPost](http://localhost:8000/posts)

@component('mail::button', ['url' => route('posts.show',['post'=>$comment->commentable->id])])
{{ $comment->commentable->title}}
@endcomponent

@component('mail::button', ['url' => route('users.show',['user' => $comment->user->id])])
{{$comment->user->name}}
@endcomponent

@component('mail::panel')
    {{$comment->content}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
