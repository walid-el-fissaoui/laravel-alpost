<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;

class UserCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(StoreComment $request ,  User $user)
    {
        /** automaticaly find the user with $id passed */

        $user->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id
        ]);

        return redirect()->back();
    }
}
