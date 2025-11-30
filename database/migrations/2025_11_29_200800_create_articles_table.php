<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            // conteúdo pode ser HTML
            $table->longText('content')->nullable();

            // data de publicação opcional
            $table->date('published_at')->nullable();

            // caminho da imagem de capa (storage)
            $table->string('cover_image_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
