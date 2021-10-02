@auth
<form action="{{ route('posts.comments.store' , ['post' => $id]) }}" method="POST">
    @csrf
    <textarea class="form-control my-3" name="content" id="content" rows="4"></textarea>
    <x-errors></x-errors>
    <button class="btn btn-primary btn-block" type="submit">comment</button>
</form>
@else
    <a href="{{route('login')}}" class="btn btn-primary btn-sm">Sign In</a> to comment !    
@endauth

