<?php

namespace App\Http\ViewComposers;

use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ActivityComposer {
    
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommented', now()->addMinutes(10), function () {
            return Post::mostCommented()->take(5)->get();
        });

        $mostActiveUsers = Cache::remember('mostActiveUsers', now()->addMinutes(10), function () {
            return User::mostActiveUsers()->take(5)->get();
        });

        $mostActiveUsersInLastMonth = Cache::remember('mostActiveUsersInLastMonth', now()->addMinutes(10), function () {
            return User::mostActiveUsersInLastMonth()->take(5)->get();
        });

        // $view->with('mostCommented',$mostCommented);
        // $view->with('mostActiveUsers',$mostActiveUsers);
        // $view->with('mostActiveUsersInLastMonth',$mostActiveUsersInLastMonth);

        // [OR] : add array 

        $view->with([
            'mostCommented' => $mostCommented,
            'mostActiveUsers'=> $mostActiveUsers,
            'mostActiveUsersInLastMonth' => $mostActiveUsersInLastMonth
        ]);
    }
}