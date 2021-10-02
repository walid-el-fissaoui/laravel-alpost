<x-card title="Most Commented Posts">
    @foreach ($mostCommented as $post)    
    <li class="list-group-item">
        <p><a href="{{route('posts.show' , ['post' => $post->id])}}">{{$post->title}}</a></p>
        @if ($post->comments_count > 1)
            <x-badge type="success"> {{$post->comments_count}} comments</x-badge>
        @elseif($post->comments_count)
            <x-badge type="success"> {{$post->comments_count}} comment</x-badge>
        @else
            <x-badge>no comments yet... !</x-badge>
        @endif
    </li>
    @endforeach
</x-card>

<x-card
    title="Most Active Users"
    :items="collect($mostActiveUsers)->pluck('name')"
></x-card>

<x-card
title="Most Active Users In Last Month"
:items="collect($mostActiveUsersInLastMonth)->pluck('name')"
></x-card>