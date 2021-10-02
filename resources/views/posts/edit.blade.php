@extends('layouts.app')
@section('content')

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('posts._form')
        <button class="btn btn-warning" type="submit">update Post</button>
    </form>

@endsection
