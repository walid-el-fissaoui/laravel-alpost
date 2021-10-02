@extends('layouts.app')
{{-- write b:section --}}
@section('content')

    @if (session()->has('status'))
        <h3 style="color: green">{{ session()->get('status') }}</h3>
    @endif
    <div class="row">
        <div class="col-8">
            @if ($post->image)
            <img src="{{ $post->image->url() ?? null }}" class="mt-3 img-fluid rounded" alt=""> 
            @endif
            <h1>{{ $post->title }}</h1>
            <x-tags :tags="$post->tags"></x-tags>
            <p>{{ $post->content }}</p> 
            <x-updated :date="$post->created_at" :name="$post->user->name" :user-id="$post->user->id" >published : </x-updated>
            <p> Status :
                @if ($post->active)
                    enabled
                @else
                    disabled
                @endif
            </p>
            <x-comment-list :comments="$post->comments"></x-comment-list>
            <x-comment-form :action="route('posts.comments.store',['post'=>$post->id])"></x-comment-form>
        </div>
        <div class="col-4">
        @include('posts.ActivitySidebar')
        </div>
    </div>

@endsection
