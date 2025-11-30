<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria usuário admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Cria desenvolvedor principal
        User::factory()->create([
            'name' => 'Developer User',
            'email' => 'dev@example.com',
            'password' => bcrypt('password'),
            'role' => 'developer',
            'seniority' => 'sr',
            'skills' => ['Laravel', 'PHP', 'MySQL', 'Vue.js', 'Tailwind CSS'],
        ]);

        // Cria 4 desenvolvedores adicionais
        User::factory()->count(4)->create([
            'role' => 'developer',
        ]);

        // Chama o seeder de artigos
        $this->call([
            ArticleSeeder::class,
        ]);
    }
}
