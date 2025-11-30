<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pega todos os desenvolvedores (role = developer)
        $developers = User::where('role', 'developer')->get();
        
        if ($developers->isEmpty()) {
            return;
        }

        $articles = [
            [
                'title' => 'Introdução ao Laravel 11',
                'content' => '<h2>O que há de novo no Laravel 11</h2><p>O Laravel 11 traz diversas melhorias e novos recursos que tornam o desenvolvimento ainda mais produtivo. Entre as principais mudanças estão:</p><ul><li>Nova estrutura de diretórios mais enxuta</li><li>Melhorias no sistema de rotas</li><li>Otimizações de performance</li></ul><h3>Novos recursos</h3><p>O framework agora inclui suporte nativo para <strong>health checks</strong>, melhorias no <code>Eloquent</code> e muito mais.</p><blockquote>Laravel continua sendo o framework PHP mais amado pelos desenvolvedores.</blockquote>',
                'published_at' => now()->subDays(5),
                'author_index' => 0,
                'contributor_indexes' => [0, 1],
            ],
            [
                'title' => 'Construindo APIs RESTful com Node.js',
                'content' => '<h2>Criando sua primeira API REST</h2><p>Node.js é uma excelente escolha para construir APIs escaláveis. Neste tutorial, vamos explorar:</p><ol><li>Configuração do ambiente</li><li>Criação de rotas com Express</li><li>Integração com banco de dados</li><li>Autenticação JWT</li></ol><h3>Exemplo de código</h3><pre><code>const express = require(\'express\');
const app = express();

app.get(\'/api/users\', (req, res) => {
  res.json({ users: [] });
});</code></pre><p>Este é apenas o começo de uma API robusta.</p>',
                'published_at' => now()->subDays(10),
                'author_index' => 1,
                'contributor_indexes' => [1, 2],
            ],
            [
                'title' => 'Python para Iniciantes',
                'content' => '<h2>Primeiros passos com Python</h2><p>Python é uma linguagem <em>versátil</em> e <strong>fácil de aprender</strong>. Ideal para iniciantes na programação.</p><h3>Instalação</h3><p>Para começar, você precisa instalar o Python no seu sistema:</p><ul><li>Download do site oficial</li><li>Instalação do pip</li><li>Configuração do ambiente virtual</li></ul><h3>Seu primeiro programa</h3><pre><code>print("Hello, World!")</code></pre><p>Simples assim! Python torna a programação acessível para todos.</p>',
                'published_at' => null,
                'author_index' => 2,
                'contributor_indexes' => [2],
            ],
            [
                'title' => 'Microservices com Spring Boot',
                'content' => '<h2>Arquitetura de Microserviços</h2><p>A arquitetura de microserviços revolucionou o desenvolvimento de aplicações empresariais. Com <strong>Spring Boot</strong>, implementar microserviços se tornou mais simples.</p><h3>Principais conceitos</h3><ul><li>Serviços independentes</li><li>Comunicação via REST/gRPC</li><li>Service Discovery</li><li>API Gateway</li></ul><h3>Vantagens</h3><p>Os microserviços oferecem:</p><ol><li>Escalabilidade horizontal</li><li>Desenvolvimento independente</li><li>Melhor manutenibilidade</li></ol><blockquote>Microserviços não são a solução para todos os problemas, mas quando bem aplicados, trazem grandes benefícios.</blockquote>',
                'published_at' => now()->subDays(3),
                'author_index' => 3,
                'contributor_indexes' => [3, 0],
            ],
            [
                'title' => 'Azure DevOps: CI/CD na prática',
                'content' => '<h2>Implementando CI/CD com Azure DevOps</h2><p>O Azure DevOps fornece ferramentas completas para implementar pipelines de integração e entrega contínuas.</p><h3>Componentes principais</h3><ul><li><strong>Azure Pipelines</strong>: automação de build e deploy</li><li><strong>Azure Repos</strong>: controle de versão Git</li><li><strong>Azure Boards</strong>: gestão de trabalho</li></ul><h3>Exemplo de Pipeline YAML</h3><pre><code>trigger:
  - main

pool:
  vmImage: \'ubuntu-latest\'

steps:
  - task: DotNetCoreCLI@2
    inputs:
      command: \'build\'</code></pre><p>Com Azure DevOps, você tem tudo o que precisa para entregar software de qualidade rapidamente.</p>',
                'published_at' => now()->subDays(1),
                'author_index' => 4,
                'contributor_indexes' => [4, 1],
            ],
            [
                'title' => 'Docker e Containers: Guia Completo',
                'content' => '<h2>Dominando Containers com Docker</h2><p>Docker transformou a forma como desenvolvemos e implantamos aplicações. Containers oferecem:</p><ul><li>Isolamento de ambientes</li><li>Portabilidade</li><li>Eficiência de recursos</li></ul><h3>Dockerfile básico</h3><pre><code>FROM node:18-alpine
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
EXPOSE 3000
CMD ["npm", "start"]</code></pre><h3>Docker Compose</h3><p>Para orquestrar múltiplos containers, use o <code>docker-compose.yml</code>:</p><pre><code>version: \'3.8\'
services:
  web:
    build: .
    ports:
      - "3000:3000"
  db:
    image: postgres:15</code></pre>',
                'published_at' => now()->subDays(7),
                'author_index' => 0,
                'contributor_indexes' => [0, 2, 3],
            ],
        ];

        foreach ($articles as $articleData) {
            // Verifica se o índice do autor existe
            if (!isset($developers[$articleData['author_index']])) {
                continue;
            }

            $author = $developers[$articleData['author_index']];

            $article = Article::create([
                'user_id' => $author->id,
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'content' => $articleData['content'],
                'published_at' => $articleData['published_at'],
            ]);

            // Associa desenvolvedores contribuidores ao artigo
            $contributorIds = collect($articleData['contributor_indexes'])
                ->map(fn($index) => $developers[$index] ?? null)
                ->filter()
                ->pluck('id')
                ->toArray();
            
            $article->developers()->attach($contributorIds);
        }
    }
}
