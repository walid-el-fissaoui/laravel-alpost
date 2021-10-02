@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <h5>user avatar :</h5>
            <img src="{{$user->image ? $user->image->url() : '' }}" alt="avatar" class="img-thumbnail avatar my-3">
            @can('update', $user) 
            <div><a href="{{route('users.edit',['user' => $user->id])}}" class="btn btn-primary">Edit</a></div>
            @endcan
        </div>
        <div class="col-md-8">
            <h3>{{$user->name}}</h3>
            <x-comment-list :comments="$user->comments"></x-comment-list>
            <x-comment-form :action="route('users.comments.store',['user'=>$user->id])"></x-comment-form>
        </div>
    </div>
@endsection