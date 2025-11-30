<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Endereço') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Atualize as informações de endereço da sua conta.') }}
        </p>
    </header>

    <form wire:submit="updateAddress" class="mt-6 space-y-6">
        {{-- CEP --}}
        <div>
            <label for="cep" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                CEP
            </label>
            <div class="flex gap-2 mt-1">
                <input 
                    type="text" 
                    wire:model.defer="cep" 
                    wire:keydown.enter.prevent="searchCep"
                    id="cep"
                    maxlength="9"
                    placeholder="00000-000"
                    class="flex-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                <button
                    type="button"
                    wire:click="searchCep"
                    wire:loading.attr="disabled"
                    wire:target="searchCep"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
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
            <x-input-error :messages="$errors->get('cep')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Logradouro --}}
            <div class="md:col-span-2">
                <label for="logradouro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Logradouro
                </label>
                <input 
                    type="text" 
                    wire:model.defer="logradouro" 
                    id="logradouro"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Rua, Avenida, etc."
                >
                <x-input-error :messages="$errors->get('logradouro')" class="mt-2" />
            </div>

            {{-- Complemento --}}
            <div class="md:col-span-2">
                <label for="complemento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Complemento
                </label>
                <input 
                    type="text" 
                    wire:model.defer="complemento" 
                    id="complemento"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Apto, Bloco, etc."
                >
                <x-input-error :messages="$errors->get('complemento')" class="mt-2" />
            </div>

            {{-- Bairro --}}
            <div>
                <label for="bairro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Bairro
                </label>
                <input 
                    type="text" 
                    wire:model.defer="bairro" 
                    id="bairro"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Bairro"
                >
                <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
            </div>

            {{-- Localidade --}}
            <div>
                <label for="localidade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Cidade
                </label>
                <input 
                    type="text" 
                    wire:model.defer="localidade" 
                    id="localidade"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Cidade"
                >
                <x-input-error :messages="$errors->get('localidade')" class="mt-2" />
            </div>

            {{-- Estado --}}
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Estado
                </label>
                <input 
                    type="text" 
                    wire:model.defer="estado" 
                    id="estado"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="UF"
                    maxlength="2"
                >
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
            </div>

            {{-- Região --}}
            <div>
                <label for="regiao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Região
                </label>
                <input 
                    type="text" 
                    wire:model.defer="regiao" 
                    id="regiao"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Região"
                    readonly
                >
                <x-input-error :messages="$errors->get('regiao')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            <x-action-message class="me-3" on="address-updated">
                {{ __('Salvo.') }}
            </x-action-message>
        </div>
    </form>
</section>
