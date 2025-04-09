<?php

namespace App\Models\backend;

use App\Models\post\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\Backend\CategoryFactory> */
    use HasFactory;
    protected $table = 'categories'; // Nombre de la tabla
    protected $primaryKey = 'id'; //

    protected $fillable = ['name', 'is_active']; // Ejemplo de campos permitidos

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
