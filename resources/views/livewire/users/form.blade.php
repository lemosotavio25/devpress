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
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            {{ $isEditing ? 'Editar Usuário' : 'Novo Usuário' }}
                        </h2>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="p-6 max-h-[70vh] overflow-y-auto">
                            <div class="space-y-6">
                                {{-- nome --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nome <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model.defer="name" 
                                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        placeholder="Digite o nome completo"
                                    >
                                    @error('name') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                </div>

                                {{-- email --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        wire:model.defer="email" 
                                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        placeholder="email@exemplo.com"
                                    >
                                    @error('email') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                </div>

                                {{-- senha --}}
                                @if(!$isEditing || $password)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Senha {{ !$isEditing ? '*' : '' }}
                                            </label>
                                            <input 
                                                type="password" 
                                                wire:model.defer="password" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="••••••••"
                                            >
                                            @error('password') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Confirmar Senha {{ !$isEditing ? '*' : '' }}
                                            </label>
                                            <input 
                                                type="password" 
                                                wire:model.defer="password_confirmation" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="••••••••"
                                            >
                                        </div>
                                    </div>
                                @endif

                                @if($isEditing && !$password)
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                        <p class="text-sm text-blue-800 dark:text-blue-300">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Deixe os campos de senha vazios para manter a senha atual.
                                        </p>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- role --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Role <span class="text-red-500">*</span>
                                        </label>
                                        <select 
                                            wire:model.defer="role" 
                                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        >
                                            <option value="developer">Developer</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                        @error('role') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- senioridade --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Senioridade
                                        </label>
                                        <select 
                                            wire:model.defer="seniority" 
                                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        >
                                            <option value="">Selecione...</option>
                                            <option value="jr">Junior</option>
                                            <option value="pl">Pleno</option>
                                            <option value="sr">Senior</option>
                                        </select>
                                        @error('seniority') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- skills --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Skills
                                    </label>
                                    
                                    <div class="flex gap-2 mb-3">
                                        <input 
                                            type="text" 
                                            wire:model.defer="newSkill"
                                            wire:keydown.enter.prevent="addSkill"
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                            placeholder="Digite uma skill e pressione Enter ou clique em Adicionar"
                                        >
                                        <button
                                            type="button"
                                            wire:click="addSkill"
                                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                        >
                                            Adicionar
                                        </button>
                                    </div>

                                    @if(count($skills) > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($skills as $index => $skill)
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                                    {{ $skill }}
                                                    <button
                                                        type="button"
                                                        wire:click="removeSkill({{ $index }})"
                                                        class="ml-2 text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-200 focus:outline-none"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Nenhuma skill adicionada ainda.
                                        </p>
                                    @endif
                                    @error('skills') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                </div>

                                {{-- Seção de Endereço --}}
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                        Endereço
                                    </h3>

                                    {{-- CEP --}}
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            CEP
                                        </label>
                                        <div class="flex gap-2">
                                            <input 
                                                type="text" 
                                                wire:model.defer="cep" 
                                                wire:keydown.enter.prevent="searchCep"
                                                maxlength="9"
                                                placeholder="00000-000"
                                                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                            >
                                            <button
                                                type="button"
                                                wire:click="searchCep"
                                                wire:loading.attr="disabled"
                                                wire:target="searchCep"
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                <span wire:loading.remove wire:target="searchCep">Buscar</span>
                                                <span wire:loading wire:target="searchCep">
                                                    <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                        @error('cep') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- Logradouro --}}
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Logradouro
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="logradouro" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="Rua, Avenida, etc."
                                            >
                                            @error('logradouro') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Complemento --}}
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Complemento
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="complemento" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="Apto, Bloco, etc."
                                            >
                                            @error('complemento') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Bairro --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Bairro
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="bairro" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="Bairro"
                                            >
                                            @error('bairro') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Localidade --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Cidade
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="localidade" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="Cidade"
                                            >
                                            @error('localidade') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Estado --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Estado
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="estado" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="Estado"
                                            >
                                            @error('estado') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Região --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Região
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="regiao" 
                                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                                placeholder="Região"
                                            >
                                            @error('regiao') <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex gap-3 justify-end">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-150"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                            >
                                {{ $isEditing ? 'Atualizar' : 'Criar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
