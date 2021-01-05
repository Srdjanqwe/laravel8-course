<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table ='blogposts';
    protected $fillable =['title','content','user_id'];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
        // moze ovde ->latest() bez da ga ubacujem u PostController
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // local query scope
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        // comments_count
        return $query->withCount('comments')-> orderBy('comments_count','desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();

        // static::addGlobalScope(new LatestScope);
        // static::addGlobalScope(new DeletedAdminScope); // da bi radio mora biti iznad boot-a

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
