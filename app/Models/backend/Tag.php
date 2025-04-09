<?php

namespace App\Models\backend;

use App\Models\post\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\Backend\TagFactory> */
    use HasFactory;

    protected $fillable = ['name',  'color', 'is_active']; // Ejemplo de campos permitidos

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
