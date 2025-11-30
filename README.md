# LT Cloud - Laravel + Livewire

Sistema de gerenciamento de artigos técnicos desenvolvido com Laravel 12 e Livewire, com sistema de autenticação, roles (Admin/Developer) e gestão completa de conteúdo.

## 🌐 Demo Online

**🔗 [https://devpress.adoroautomacao.com.br/](https://devpress.adoroautomacao.com.br/)**

Acesse a aplicação em produção e teste todas as funcionalidades!

## 🚀 Tecnologias

- **Laravel 11** - Framework PHP
- **Livewire 3** - Componentes reativos full-stack
- **Tailwind CSS** - Framework CSS utility-first
- **Alpine.js** - Framework JavaScript leve (incluso no Livewire)
- **SQLite** - Banco de dados
- **Laravel Breeze** - Autenticação
- **Quill.js** - Editor de texto rico (WYSIWYG)

## ✨ Funcionalidades

### Autenticação
- Login, registro e recuperação de senha via Laravel Breeze
- Sistema de roles: **Admin** e **Developer**
- Policies para controle de acesso granular

### Gestão de Artigos (CRUD Completo)
- ✅ Criar, editar, visualizar e excluir artigos
- ✅ Editor de texto rico com Quill.js (suporta HTML)
- ✅ Upload de imagem de capa (opcional, com fallback)
- ✅ Sistema de slug único automático
- ✅ Status de publicação (publicado/rascunho)
- ✅ Associação de múltiplos desenvolvedores por artigo (many-to-many)
- ✅ Filtros em tempo real (busca por título/conteúdo e status)
- ✅ Paginação com 9 artigos por página

### Controle de Acesso (Policies)
- **Admin**: Visualiza e gerencia todos os artigos do sistema
- **Developer**: Visualiza e gerencia apenas seus próprios artigos
- ArticlePolicy implementada com regras de autorização para todas as operações

### Interface Responsiva
- 📱 Grid card-based (3 colunas) em desktop
- 📱 Lista otimizada (1 coluna) para mobile
- 🎨 Dark mode suportado
- 🔄 Navegação SPA com Livewire navigate (sem reload de página)
- 🎭 Modais para formulários e confirmações

## 📦 Instalação

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js 18+ e npm
- SQLite

### Passo a Passo

1. **Clone o repositório**
```bash
git clone <url-do-repositorio>
cd ltcloud
```

2. **Instale as dependências PHP**
```bash
composer install
```

3. **Instale as dependências JavaScript**
```bash
npm install
```

4. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Crie o banco de dados SQLite**
```bash
# Linux/Mac:
touch database/database.sqlite

# Windows PowerShell:
New-Item database/database.sqlite
```

6. **Execute as migrations e seeders**
```bash
php artisan migrate:fresh --seed
```
Este comando irá:
- Criar todas as tabelas do banco
- Criar 1 usuário Admin
- Criar 5 usuários Developers (com skills e senioridade variadas)
- Criar 6 artigos de exemplo com conteúdo HTML rico

7. **Crie o link simbólico para storage**
```bash
php artisan storage:link
```

8. **Compile os assets**
```bash
# Produção:
npm run build

# Ou para desenvolvimento (watch mode):
npm run dev
```

9. **Inicie o servidor**
```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## 🔑 Credenciais de Acesso

### Admin
- **Email**: test@example.com
- **Senha**: password
- **Permissões**: Acesso total - visualiza e gerencia todos os artigos
- **Role**: admin

### Developers (5 usuários criados automaticamente)
- **Senha padrão**: password
- **Emails**: Verifique os emails gerados pelo seeder (ex: john.doe@example.com)
- **Permissões**: Acesso restrito - visualiza e gerencia apenas seus próprios artigos
- **Role**: developer
- Cada desenvolvedor tem:
  - Senioridade: Júnior, Pleno ou Sênior
  - Skills: Array de tecnologias (ex: Laravel, PHP, MySQL, Vue.js)

## 📁 Estrutura do Projeto

```
ltcloud/
├── app/
│   ├── Livewire/
│   │   ├── Actions/
│   │   │   └── Logout.php         # Ação de logout
│   │   ├── articles/              # Componentes Livewire de Artigos
│   │   │   ├── Index.php          # Listagem com filtros
│   │   │   ├── Form.php           # Criar/Editar (modal)
│   │   │   ├── Show.php           # Visualização completa
│   │   │   └── Delete.php         # Exclusão (modal confirmação)
│   │   ├── Forms/
│   │   │   └── LoginForm.php      # Formulário de login
│   │   └── Users/
│   │       └── Index.php          # Listagem de usuários
│   ├── Models/
│   │   ├── User.php               # Modelo de Usuário (com roles e skills)
│   │   └── Article.php            # Modelo de Artigo
│   └── Policies/
│       └── ArticlePolicy.php      # Políticas de autorização
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_articles_table.php
│   │   ├── *_add_role_to_users_table.php        # Adiciona role, seniority, skills
│   │   └── *_update_article_developer_to_article_user.php  # Cria pivot table
│   ├── seeders/
│   │   ├── DatabaseSeeder.php     # Coordena os seeders
│   │   └── ArticleSeeder.php      # Cria artigos de exemplo
│   └── factories/
│       └── UserFactory.php        # Factory com suporte a roles
├── resources/
│   ├── views/
│   │   └── livewire/
│   │       ├── articles/          # Views dos componentes de artigos
│   │       │   ├── index.blade.php
│   │       │   ├── form.blade.php
│   │       │   ├── show.blade.php
│   │       │   └── delete.blade.php
│   │       ├── layout/
│   │       │   └── navigation.blade.php  # Menu de navegação
│   │       ├── pages/
│   │       │   └── auth/          # Páginas de autenticação
│   │       ├── profile/           # Views de perfil
│   │       ├── users/             # Views de usuários
│   │       └── welcome/           # Views de boas-vindas (Sem livewire)
│   ├── css/
│   │   └── app.css               # Tailwind CSS + estilos customizados
│   └── js/
│       └── app.js                # JavaScript (importa Quill.js)
├── routes/
│   └── web.php                   # Rotas da aplicação
├── public/
│   ├── article_fb.png            # Imagem fallback para artigos
│   └── storage/                  # Link simbólico para storage
└── storage/
    └── app/
        └── public/
            └── articles/          # Uploads de imagens de capa
```

## 🗄️ Estrutura do Banco de Dados

### Tabela `users`
```sql
- id (bigint, PK)
- name (string)
- email (string, unique)
- password (hashed)
- role (enum: 'admin', 'developer')
- seniority (enum: 'jr', 'pl', 'sr', nullable)
- skills (json, nullable)
- email_verified_at (timestamp)
- remember_token (string)
- created_at, updated_at
```

### Tabela `articles`
```sql
- id (bigint, PK)
- user_id (bigint, FK → users.id)
- title (string)
- slug (string, unique)
- content (text, nullable)
- published_at (date, nullable)
- cover_image_path (string, nullable)
- created_at, updated_at
```

### Tabela `article_user` (pivot - many-to-many)
```sql
- id (bigint, PK)
- article_id (bigint, FK → articles.id, cascade delete)
- user_id (bigint, FK → users.id, cascade delete)
- created_at, updated_at
```

**Relacionamento**: No contexto do Eloquent, um artigo pertence a vários desenvolvedores e um desenvolvedor tem muitos artigos associados. Ou seja, cada lado do relacionamento combina conceitos de belongsTo e hasMany, formando uma estrutura muitos-para-muitos.

## 🎨 Funcionalidades de UI/UX

### Componentes Visuais
- ✅ Modais animados para criar/editar/deletar
- ✅ Cards com hover effects e transições
- ✅ Mensagens de feedback (success/error) com auto-dismiss
- ✅ Badges coloridas de status (publicado/rascunho)
- ✅ Contador de desenvolvedores associados por artigo
- ✅ Preview de imagem ao fazer upload
- ✅ Imagem fallback automática para artigos sem capa
- ✅ Ícones SVG inline

### Funcionalidades Interativas
- ✅ Busca em tempo real com debounce (300ms)
- ✅ Filtros reativos sem reload de página
- ✅ Paginação estilizada com Livewire
- ✅ Editor WYSIWYG Quill.js com toolbar completa
- ✅ Seleção múltipla de desenvolvedores (checkboxes)
- ✅ Navegação SPA (sem recarregar página)

### Responsividade
- 📱 Breakpoints: sm (640px), md (768px), lg (1024px)
- 🎨 Grid adaptativo: 1 coluna (mobile) → 2 colunas (tablet) → 3 colunas (desktop)
- 📋 Menu hamburger para mobile
- 🔄 Layouts otimizados para touch

## 🔒 Segurança

### Autenticação e Autorização
- ✅ Autenticação com Laravel Breeze (login, registro, reset senha)
- ✅ Policies (ArticlePolicy) para autorização granular
- ✅ Gates automáticos via policies
- ✅ Middleware `auth` e `verified` nas rotas protegidas

### Validação e Proteção
- ✅ Validação de formulários server-side (Livewire rules)
- ✅ Proteção contra SQL Injection (Eloquent ORM)
- ✅ Proteção contra XSS (Blade templates com escape automático)
- ✅ CSRF Protection habilitado globalmente
- ✅ Upload de arquivos com validação:
  - Tipos permitidos: jpeg, jpg, png, gif, webp
  - Tamanho máximo: 10MB
- ✅ Slugs únicos com verificação de duplicatas
- ✅ Mass assignment protection nos models

## 📝 Comandos Úteis

```bash
# Desenvolvimento
php artisan serve                    # Iniciar servidor local
npm run dev                          # Watch mode para assets

# Banco de Dados
php artisan migrate                  # Executar migrations
php artisan migrate:fresh --seed    # Recriar banco com dados
php artisan db:show                  # Ver estrutura do banco

# Cache e Otimização
php artisan optimize:clear           # Limpar todos os caches
php artisan config:cache             # Cache de configurações
php artisan route:cache              # Cache de rotas
php artisan view:cache               # Cache de views

# Storage
php artisan storage:link             # Criar link simbólico

# Informações
php artisan route:list               # Listar todas as rotas
php artisan about                    # Informações do sistema
```

## 🏗️ Arquitetura e Padrões

### MVC + Livewire
- **Models**: Eloquent ORM com relacionamentos
- **Views**: Blade templates + Livewire components
- **Controllers**: Substituídos por Livewire components (full-stack)