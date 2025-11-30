<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Saudação --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Olá, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    @if(Auth::user()->isAdmin())
                        Bem-vindo ao painel administrativo.
                    @else
                        Bem-vindo à sua área de desenvolvimento.
                    @endif
                </p>
            </div>

            {{-- Estatísticas --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                @if(Auth::user()->isAdmin())
                    {{-- Cards Admin --}}
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total de Usuários</p>
                                <p class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</p>
                            </div>
                            <div class="bg-blue-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Total de Artigos</p>
                                <p class="text-3xl font-bold mt-2">{{ \App\Models\Article::count() }}</p>
                            </div>
                            <div class="bg-purple-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Publicados</p>
                                <p class="text-3xl font-bold mt-2">{{ \App\Models\Article::whereNotNull('published_at')->count() }}</p>
                            </div>
                            <div class="bg-green-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Desenvolvedores</p>
                                <p class="text-3xl font-bold mt-2">{{ \App\Models\User::where('role', 'developer')->count() }}</p>
                            </div>
                            <div class="bg-orange-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Cards Developer --}}
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Meus Artigos</p>
                                <p class="text-3xl font-bold mt-2">{{ Auth::user()->articles()->count() }}</p>
                            </div>
                            <div class="bg-blue-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Publicados</p>
                                <p class="text-3xl font-bold mt-2">{{ Auth::user()->articles()->whereNotNull('published_at')->count() }}</p>
                            </div>
                            <div class="bg-green-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-100 text-sm font-medium">Rascunhos</p>
                                <p class="text-3xl font-bold mt-2">{{ Auth::user()->articles()->whereNull('published_at')->count() }}</p>
                            </div>
                            <div class="bg-gray-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Contribuições</p>
                                <p class="text-3xl font-bold mt-2">{{ Auth::user()->contributedArticles()->count() }}</p>
                            </div>
                            <div class="bg-purple-400/30 rounded-full p-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Ações Rápidas --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Ações Rápidas</h3>
                    <div class="space-y-3">
                        <a href="{{ route('articles.index') }}" 
                           wire:navigate
                           class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                            <div class="flex items-center">
                                <div class="bg-blue-500 rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Ver Artigos</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('users.index') }}" 
                               wire:navigate
                               class="flex items-center justify-between p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors group">
                                <div class="flex items-center">
                                    <div class="bg-purple-500 rounded-lg p-2 mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium">Gerenciar Usuários</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif

                        <a href="{{ route('profile') }}" 
                           wire:navigate
                           class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors group">
                            <div class="flex items-center">
                                <div class="bg-gray-500 rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">Editar Perfil</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Informações do Usuário --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Meu Perfil</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Role:</span>
                                @if(Auth::user()->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                        Developer
                                    </span>
                                @endif
                            </div>

                            @if(Auth::user()->seniority)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Senioridade:</span>
                                    @php
                                        $seniorityLabels = ['jr' => 'Junior', 'pl' => 'Pleno', 'sr' => 'Senior'];
                                    @endphp
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $seniorityLabels[Auth::user()->seniority] }}
                                    </span>
                                </div>
                            @endif

                            @if(Auth::user()->skills && count(Auth::user()->skills) > 0)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-2">Skills:</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(Auth::user()->skills as $skill)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Artigos Recentes --}}
            @if(!Auth::user()->isAdmin())
                @php
                    $recentArticles = Auth::user()->articles()->orderBy('created_at', 'desc')->take(5)->get();
                @endphp
                @if($recentArticles->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Meus Artigos Recentes</h3>
                            <a href="{{ route('articles.index') }}" wire:navigate class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                Ver todos →
                            </a>
                        </div>
                        <div class="space-y-3">
                            @foreach($recentArticles as $article)
                                <a href="{{ route('articles.show', $article->slug) }}" 
                                   wire:navigate
                                   class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors group">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                            {{ $article->title }}
                                        </h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($article->published_at)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    Publicado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-300">
                                                    Rascunho
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $article->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
