<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DevPress - Gestão de Artigos Técnicos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-blue-600 selection:text-white">
                <div class="relative w-full max-w-7xl px-6 lg:px-8">

                    {{-- HEADER --}}
                    <header class="flex items-center justify-between py-8">
                        <div class="flex items-center gap-3">
                            {{-- Ícone DevPress minimalista --}}
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <path d="M16 14 L10 24 L16 34" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M32 14 L38 24 L32 34" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                </svg>
                            </div>

                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    DevPress
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Gestão de Desenvolvedores & Artigos Técnicos
                                </p>
                            </div>
                        </div>
                        {{-- removido welcome.navigation para não duplicar login --}}
                    </header>

                    {{-- HERO --}}
                    <main class="mt-12 mb-16">
                        <div class="text-center mb-16">
                            <h2 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                                Organize seu conteúdo
                                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                                    técnico com desenvolvedores
                                </span>
                            </h2>

                            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                                DevPress é uma mini aplicação em Laravel + Livewire para cadastro de desenvolvedores,
                                artigos e vínculo entre eles. Focada em boas práticas, UX responsiva e código limpo.
                            </p>

                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                @auth
                                    <a href="{{ route('dashboard') }}"
                                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        Ir para Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        Fazer Login
                                    </a>

                                    <a href="{{ route('register') }}"
                                       class="inline-flex items-center px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 border-2 border-gray-200 dark:border-gray-700">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Criar Conta
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
