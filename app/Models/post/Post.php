<?php

namespace App\Models\post;

use App\Models\backend\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Post\PostFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id', 'user_id', 'image_path', 'state', 'is_active'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
