
@foreach ($tags as $tag)
    <a href="{{route('posts.tag.index',['post'=>$tag->id])}}" class="badge badge-primary">{{$tag->name}}</a>
@endforeach