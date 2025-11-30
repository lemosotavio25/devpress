<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function setUser(string $type): void
    {
        if ($type === 'admin') {
            $this->form->email = 'admin@example.com';
            $this->form->password = 'password';
        }

        if ($type === 'developer') {
            $this->form->email = 'dev@example.com';
            $this->form->password = 'password';
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="space-y-6">

    {{-- Quick Login Cards --}}
    <div class="flex flex-col sm:flex-row justify-center gap-4">

        <button
            wire:click="setUser('admin')"
            class="px-6 py-3 w-full sm:w-1/2 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold shadow-md hover:shadow-lg hover:from-purple-700 hover:to-indigo-700 transition">
             Entrar como Admin
        </button>

        <button
            wire:click="setUser('developer')"
            class="px-6 py-3 w-full sm:w-1/2 rounded-xl bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold shadow-md hover:shadow-lg hover:from-blue-700 hover:to-teal-700 transition">
             Entrar como Developer
        </button>
    </div>

    <p class="text-center text-gray-500 text-sm">
        Ou faça login manualmente:
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                wire:model="form.email"
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                required
                autofocus
                placeholder="admin@example.com ou dev@example.com"
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                wire:model="form.password"
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                placeholder="•••••••• (senha: password)"
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                       name="remember">

                <span class="ms-2 text-sm text-gray-600">Lembrar de mim</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md"
                   href="{{ route('password.request') }}" wire:navigate>
                    Esqueceu sua senha?
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
