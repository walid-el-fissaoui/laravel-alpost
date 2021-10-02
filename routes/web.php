<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('mailable',function(){
    $comment = App\Models\Comment::find(1);
    return new App\Mail\CommentedPostMarkDown($comment);
});

Route::view('/',"welcome");
Route::view('/about','about');

/** Note : if you add this following two routes after route:resource it will not work */
Route::get('/posts/archive' , [App\Http\Controllers\PostController::class , 'archive'])->name('posts.archive');
Route::get('/posts/all' , [App\Http\Controllers\PostController::class , 'all'])->name('posts.all');
Route::patch('posts/{post}/restore', [App\Http\Controllers\PostController::class , 'restore'])->name('posts.restore');
Route::delete('posts/{post}/forcedelete', [App\Http\Controllers\PostController::class , 'forcedelete'])->name('posts.forcedelete');

Route::get('/posts/tag/{post}' , [App\Http\Controllers\PostTagController::class, 'index'])->name('posts.tag.index');

Route::resource('posts.comments',App\Http\Controllers\PostCommentController::class)->only(['store' , 'show']);
Route::resource('users.comments',App\Http\Controllers\UserCommentController::class)->only(['store']);
Route::resource('posts',App\Http\Controllers\PostController::class);

Route::resource('users',App\Http\Controllers\UserController::class)->only(['show','edit','update']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/secret', [App\Http\Controllers\HomeController::class, 'secret'])->name('secret')->middleware('can:secret.page');
