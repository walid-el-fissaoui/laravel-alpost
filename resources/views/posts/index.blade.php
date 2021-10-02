@extends('layouts.app')
@section('content')

    @if (session()->has('status'))
        <h3 style="color: green">{{ session()->get('status') }}</h3>
    @endif

    <div class="row">
        <div class="col-8">
    <div>
        <h4>{{$posts->count()}} Post(s)</h4>
    </div>
    @forelse ($posts as $post)
        <p>
                @if($post->created_at->diffInHours() < 1)
                <x-badge type="success">new</x-badge>
                @else
                <x-badge>old</x-badge>
                @endif

                {{-- first method :  --}}
                {{-- <img src="http://localhost:8000/storage/{{$post->image->path ?? null }}" class="img-fluid rounded" alt="">  --}}
                {{-- second method :  --}}
                {{-- <img src="{{asset($post->image->path ?? null) }}" class="img-fluid rounded" alt="">  --}}
                {{-- third and best method :  --}}
                @if ($post->image)
                <img src="{{ $post->image->url() ?? null }}" class="mt-3 img-fluid rounded" alt=""> 
                @endif
                

                @if ($post->trashed())
                <h2> <del>{{$post->title}}</del> </h2>
                @else
                <h2> <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h2>
                @endif
                <x-tags :tags="$post->tags"></x-tags>
                <x-updated :date="$post->created_at">published :</x-updated>
                <x-updated :date="$post->updated_at" :name="$post->user->name" :user-id="$post->user->id">updated :</x-updated>
                <div>
                    @if ($post->comments_count > 1)
                    <x-badge type="success"> {{ $post->comments_count }} comments</x-badge>   
                    @elseif($post->comments_count)
                    <x-badge type="success"> {{ $post->comments_count }} comment</x-badge>    
                    @else
                    <x-badge>no comments yet !</x-badge>    
                    @endif
                </div>
            @auth
                @can('update', $post)
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">edit</a>
                @endcan

                @cannot('delete', $post)                   
                    <x-badge type="danger"> you can't delete this post !</x-badge>
                @endcannot                

                @if ($post->deleted_at)
                @can('restore', $post)
                <form class="form-inline" method="POST" action="{{ route('posts.restore', ['post' => $post->id]) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">restore</button>
                </form>
                @endcan
                @can('forceDelete', $post)
                <form class="form-inline" method="POST" action="{{ route('posts.forcedelete', ['post' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">permanently delete</button>
                </form>
                @endcan
                
                @else
                @can('delete', $post) 
                <form class="form-inline d-inline-block" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">delete</button>
                </form>
                @endif
                @endcan
            @endauth
            <hr class="bg-secondary"/>
        </p>
    @empty
        <div class="badge badge-danger">
            <span class="h1"> No Posts...☹</span>
        </div>
    @endforelse
        </div>
        <div class="col-4">
            @include('posts.ActivitySidebar')
        </div>
    </div>
@endsection
