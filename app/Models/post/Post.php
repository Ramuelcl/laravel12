<?php

namespace App\Models\post;

use App\Models\backend\Category;
use App\Models\backend\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Post\PostFactory> */
    use HasFactory;
    protected $fillable = ['title', 'slug', 'content', 'category_id', 'state', 'user_id', 'is_active'];

    // Mutador para generar el slug automáticamente
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
