<?php

namespace App\Providers;

use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\Comment;
use App\Observers\PostObserver;
use App\Observers\CommentObserver;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('posts.ActivitySidebar',ActivityComposer::class);
        // view()->composer('*',ActivityComposer::class); /** use : '*' if you want to inject the ActivityComposer for all views */
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);

        // CommentResource::withoutWrapping(); /** return json from commentresource without the wrapping : "data":["",""...] */
        JsonResource::withoutWrapping(); /** return all json resources withour wrapping */
    }
}
