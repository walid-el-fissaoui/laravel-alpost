<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public const LOCALES =  [
        'en' => 'english' ,
        'fr' => 'frensh'  ,
        'ar' => 'arabic'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeMostActiveUsers(Builder $query)
    {
        return  $query->withCount('posts')->orderBy('posts_count','desc');
    }

    public function scopeMostActiveUsersInLastMonth(Builder $query)
    {
        return $query->withCount(['posts' => function(Builder $query){
            return $query->whereBetween(static::CREATED_AT , [now()->subMonth(1), now()]);
        }])
        ->having('posts_count' , '>' , 3)
        ->orderby('posts_count','desc');
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment' , 'commentable')->dernier();
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image','imageable');
    } 

}
