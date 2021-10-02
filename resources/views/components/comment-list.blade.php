<div>
    @forelse ($comments as $comment)
        <p>
            <x-updated :date="$comment->created_at" :name="$comment->user->name" >added :</x-updated>

            <p>{{ $comment->content }}</p>
        </p>
        <hr class="bg-secondary"/>
    @empty
        <p>
            <div class="badge badge-warning ">
                <span class="h1">no comments..! ☹</span>
            </div>
        </p>
    @endforelse
</div>