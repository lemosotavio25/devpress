<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Botão voltar --}}
    <div class="mb-6">
        <a href="{{ route('articles.index') }}" 
           wire:navigate
           class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar para artigos
        </a>
    </div>

    {{-- Artigo --}}
    <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        {{-- Imagem de capa --}}
        @if($article->cover_image_path)
            <div class="w-full h-96 overflow-hidden bg-gray-200 dark:bg-gray-700">
                <img 
                    src="{{ asset('storage/' . $article->cover_image_path) }}" 
                    alt="{{ $article->title }}"
                    class="w-full h-full object-cover"
                >
            </div>
        @endif

        <div class="p-8">
            {{-- Cabeçalho --}}
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center gap-4 flex-wrap">
                    @if($article->published_at)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Publicado em {{ $article->published_at->format('d/m/Y') }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Rascunho
                        </span>
                    @endif

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Criado em {{ $article->created_at->format('d/m/Y') }}
                    </span>
                </div>

                {{-- Desenvolvedores --}}
                @if($article->developers->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            Desenvolvedores Relacionados:
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($article->developers as $dev)
                                <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $dev->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">{{ $dev->seniority }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </header>

            {{-- Conteúdo --}}
            <div class="prose prose-lg dark:prose-invert max-w-full overflow-x-auto break-words">
                {!! $article->content !!}
            </div>


            {{-- Ações --}}
            @if(!Auth::user()->isAdmin())
                <footer class="mt-12 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex gap-3 justify-end">
                        <button
                            wire:click="$dispatch('openArticleModal', { articleId: {{ $article->id }} })"
                            onclick="window.location.href='{{ route('articles.index') }}'"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Artigo
                        </button>
                    </div>
                </footer>
            @endif
        </div>
    </article>
</div>