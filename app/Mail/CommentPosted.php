<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "comment for {$this->comment->commentable->title} Post";
        return $this
                // ->attach(storage_path('app/public/' . $this->comment->user->image->path))
                // ->attach(storage_path('app/public') . '/' . $this->comment->user->image->path )
                // ->attach(storage_path('app/public') . '/' . $this->comment->user->image->path , ['as' => 'profile-picture.jpeg' , 'mime' => 'image/jpeg'] )
                // ->attachFromStorage($this->comment->user->image->path , 'profile-picture.jpeg')
                ->attachFromStorageDisk('public' , $this->comment->user->image->path , 'profile-picture.jpeg')
                ->subject($subject)
                ->view('emails.posts.comment');
    }
}
