<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Scopes\ShowAlsoTrashedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['content' , 'user_id'];

    public function commentable() 
    {
        return $this->morphTo();
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag','taggable')->withTimestamps();
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /** local scope should be prefixed with 'scope' */
    public function scopeDernier(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new ShowAlsoTrashedScope);
        parent::boot();
        static::addGlobalScope(new LatestScope);
    }
}
