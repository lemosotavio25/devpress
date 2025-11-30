<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//pivot table
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_developer', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('developer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            // evita duplicar o mesmo dev no mesmo artigo
            $table->unique(['article_id', 'developer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_developer');
    }
};
