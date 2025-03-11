<?php

namespace App\Models\post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Post\PostFactory> */
    use HasFactory;

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
