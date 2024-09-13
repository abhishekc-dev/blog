<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'author_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
