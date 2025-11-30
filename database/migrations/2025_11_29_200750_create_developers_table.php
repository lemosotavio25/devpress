<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('email');

            // jr / pl / sr
            $table->enum('seniority', ['jr', 'pl', 'sr']);

            // lista de skills (tags) em JSON
            $table->json('skills')->nullable();

            $table->timestamps();

            // garante que um mesmo user não cadastre 2 devs com o mesmo e-mail
            $table->unique(['user_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developers');
    }
};
