@extends('layouts.app')
@section('content')

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @include('posts._form')
        <button class="btn btn-primary" type="submit">add Post</button>
    </form>

@endsection
