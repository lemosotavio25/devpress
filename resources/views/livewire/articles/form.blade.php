<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- overlay --}}
                <div 
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                    aria-hidden="true"
                    wire:click="closeModal"
                ></div>

                {{-- centralização --}}
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- modal --}}
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            {{ $isEditing ? 'Editar Artigo' : 'Novo Artigo' }}
                        </h2>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="p-6 max-h-[70vh] overflow-y-auto">
                            <div class="space-y-6">
                                {{-- título --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Título <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model.defer="title" 
                                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Digite o título do artigo"
                                    >
                                    @error('title') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                </div>

                                {{-- imagem de capa --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Imagem de Capa
                                    </label>
                                    
                                    @if($isEditing && $article->cover_image_path && !$cover_image)
                                        <div class="mb-3 relative inline-block">
                                            <img 
                                                src="{{ asset('storage/' . $article->cover_image_path) }}" 
                                                alt="Capa atual"
                                                class="h-32 rounded-lg object-cover"
                                            >
                                            <button
                                                type="button"
                                                wire:click="removeCoverImage"
                                                class="absolute top-2 right-2 p-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg transition-colors"
                                                title="Remover imagem"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Imagem atual</p>
                                        </div>
                                    @endif

                                    @if($cover_image && !is_string($cover_image))
                                        <div class="mb-3 relative inline-block">
                                            <img 
                                                src="{{ $cover_image->temporaryUrl() }}" 
                                                alt="Preview"
                                                class="h-32 rounded-lg object-cover"
                                            >
                                            <button
                                                type="button"
                                                wire:click="$set('cover_image', null)"
                                                class="absolute top-2 right-2 p-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg transition-colors"
                                                title="Remover imagem"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nova imagem</p>
                                        </div>
                                    @endif

                                    <input 
                                        type="file" 
                                        wire:model="cover_image" 
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/20 dark:file:text-blue-400"
                                    >
                                    @error('cover_image') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                </div>

                                {{-- conteúdo --}}
                                <div x-data="quillEditor()" x-init="initQuill()">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Conteúdo
                                    </label>
                                    <div wire:ignore>
                                        <div id="quill-editor" style="height: 300px; background: white;"></div>
                                    </div>
                                    @error('content') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- data de publicação --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Data de Publicação
                                        </label>
                                        <input 
                                            type="date" 
                                            wire:model.defer="published_at" 
                                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            Deixe vazio para salvar como rascunho
                                        </p>
                                        @error('published_at') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- desenvolvedores --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Desenvolvedores Relacionados
                                        </label>
                                        <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-3 bg-white dark:bg-gray-700">
                                            @forelse($developers as $dev)
                                                <label class="flex items-center">
                                                    <input 
                                                        type="checkbox" 
                                                        wire:model.defer="selectedDevelopers" 
                                                        value="{{ $dev->id }}"
                                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                    >
                                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                        {{ $dev->name }}
                                                    </span>
                                                </label>
                                            @empty
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Nenhum desenvolvedor cadastrado
                                                </p>
                                            @endforelse
                                        </div>
                                        @error('selectedDevelopers') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex gap-3 justify-end">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                {{ $isEditing ? 'Atualizar' : 'Criar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        function quillEditor() {
            return {
                quill: null,
                
                initQuill() {
                    // Aguarda o Quill estar disponível
                    const checkQuill = setInterval(() => {
                        if (window.Quill) {
                            clearInterval(checkQuill);
                            this.setupEditor();
                        }
                    }, 100);
                },
                
                setupEditor() {
                    const editorEl = document.getElementById('quill-editor');
                    if (!editorEl) return;

                    // Remove instância anterior se existir
                    editorEl.innerHTML = '';

                    this.quill = new Quill('#quill-editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'color': [] }, { 'background': [] }],
                                ['link', 'image'],
                                ['clean']
                            ]
                        },
                        placeholder: 'Digite o conteúdo do artigo...'
                    });

                    // Carrega conteúdo inicial
                    const content = @this.get('content');
                    if (content) {
                        this.quill.root.innerHTML = content;
                    }

                    // Sincroniza mudanças com Livewire
                    this.quill.on('text-change', () => {
                        @this.set('content', this.quill.root.innerHTML);
                    });
                }
            }
        }
    </script>
</div>
