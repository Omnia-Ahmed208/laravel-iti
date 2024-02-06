<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Post extends Model
{
    use HasFactory, Prunable;

//  insert into user ['title','desc.....]
    protected $fillable = [
        'title', //column name
        'description',
        'user_id',
        'slug',
        'image',
    ];

    // join to user table to get user name
    public function user(){
        // we say that post model(posts) belong to user calss
        return $this->belongsTo(User::class);
    }

    // if we used another name for function user()
    public function test(){
        return $this->belongsTo(User::class, foreignKey:'user_id');
    }

    public function comments(){
        // post may have many comments
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Prune to clean data at specific time
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subMonth(24)); // delete posts from 2 years
    }

    protected function pruning()
    {
        echo 'pruning '. $this->title . PHP_EOL;
    }
}

