<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $table = 'posts';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->string('slug', 100)->unique();

            $table->text('content');

            // Definición de category_id y su clave foránea
            $table->unsignedBigInteger('category_id')->nullable();
            // Definición de user_id y su clave foránea
            $table->unsignedBigInteger('user_id');

            $table->string('image_path', 255)->nullable();
            $table->enum('state', ['draft', 'new', 'editing', 'published', 'archived', 'deleted'])->default('new');
            $table->boolean('is_active')->default(false);

            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->integer('comments')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Claves foráneas
            // Asegúrate de que la tabla categories y users existan antes de ejecutar esta migración
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
