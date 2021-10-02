<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\AdminShowAlsoTrashedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'slug', 'active' , 'user_id'];

    public function comments()
    {
        return $this->morphMany('App\Models\Comment' , 'commentable')->dernier();
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag','taggable')->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image','imageable');
    } 

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count' , 'desc');
    }

    public function scopePostWithUserCommentsTags(Builder $query)
    {
        return $query->withCount('comments')->with(['user','tags']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        static::addGlobalScope(new AdminShowAlsoTrashedScope);
        parent::boot();
        static::addGlobalScope(new LatestScope);
    }
}
