<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Mail\CommentedPostMarkDown;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\NotifyUsersPostWasCommented;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserAboutNewComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        Mail::to($event->comment->commentable->user->email)->queue(new CommentedPostMarkDown($event->comment));
        NotifyUsersPostWasCommented::dispatch($event->comment);
    }
}
